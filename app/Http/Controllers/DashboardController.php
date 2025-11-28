<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalStudents' => Student::count(),
            'totalTeachers' => Teacher::count(),
            'totalClasses' => SchoolClass::count(),
            'totalSubjects' => Subject::count(),
        ]);
    }
}