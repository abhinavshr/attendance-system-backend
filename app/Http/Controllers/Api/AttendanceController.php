<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Kreait\Firebase\Messaging\CloudMessage;

class AttendanceController extends Controller
{
    public function checkIn(Request $request)
    {
        $user = $request->user(); // logged-in student/employee

        // Save check-in in MySQL
        $attendance = Attendance::create([
            'user_id' => $user->id,
            'status'  => 'checked_in',
            'time'    => now(),
        ]);

        // Send notification to all teachers/admins with FCM token
        $this->sendNotificationToRole('teacher', $user->name . ' has checked in');
        $this->sendNotificationToRole('admin', $user->name . ' has checked in');

        return response()->json([
            'message'    => 'Checked in successfully',
            'attendance' => $attendance,
        ]);
    }

    // Firebase notification function
    protected function sendNotificationToRole($roleName, $message)
    {
        $messaging = app('firebase.messaging');

        $users = User::whereHas('role', fn($q) => $q->where('name', $roleName))
                     ->whereNotNull('fcm_token')
                     ->get();

        foreach ($users as $user) {
            $firebaseMessage = CloudMessage::withTarget('token', $user->fcm_token)
                ->withNotification([
                    'title' => 'Attendance Update',
                    'body'  => $message,
                ]);

            $messaging->send($firebaseMessage);
        }
    }
}
