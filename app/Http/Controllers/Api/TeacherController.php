<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class TeacherController extends Controller
{

    public function attendanceList()
    {
        return Attendance::with('user')->latest()->get();
    }
}
