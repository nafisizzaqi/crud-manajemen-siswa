<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentModel;
use Inertia\Inertia;
use App\Models\TeacherModel;
use Illuminate\Support\Facades\Log;
class DashboardController extends Controller
{
    public function index() {
        $students = StudentModel::with('class')->orderBy('class_id', 'asc')->get();
        $teachers = TeacherModel::with('class')->orderBy('class_id', 'asc')->get();
        $groupData = array_merge($students->toArray(), $teachers->toArray());
        $groupData = collect($groupData)->groupBy('class.class_name')->values()->toArray();
        return Inertia::render('Dashboard/Index', [
            'students' => $students,
            'teachers' => $teachers,
            'groupData' => $groupData,
        ]);
    }
}
