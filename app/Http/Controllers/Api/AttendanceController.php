<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{

    public function checkIn(Request $request)
{
    $user = $request->user();

    $attendance = Attendance::create([
        'user_id'=> $user->id,
        'status' => 'checked_in',
        'time'   => now(),
    ]);

    // Send notification to teachers via Firebase
    $this->sendNotificationToRole('teacher', $user->name.' has checked in.');

    return response()->json(['message'=>'Checked in successfully', 'attendance'=>$attendance]);
}

protected function sendNotificationToRole($roleName, $message)
{
    $firebase = app('firebase.messaging');
    $users = User::whereHas('role', fn($q)=>$q->where('name',$roleName))
                    ->whereNotNull('fcm_token')
                    ->get();

    foreach ($users as $user) {
        $firebase->send([
            'token' => $user->fcm_token,
            'notification' => [
                'title' => 'Attendance Update',
                'body'  => $message
            ]
        ]);
    }
}


}
