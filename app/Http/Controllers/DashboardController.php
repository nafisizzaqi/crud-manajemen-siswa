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
        $students = StudentModel::with('class')->orderBy('class_id', 'desc')->get();
        $teachers = TeacherModel::with('class')->orderBy('class_id', 'desc')->get();
        $groupData = array_merge($students->toArray(), $teachers->toArray());
        \Log::info('groupData before groupBy', [$groupData[0]]);
        $groupData = collect($groupData)->groupBy('class_id')->values()->toArray();
        \Log::info('groupData after groupBy', [$groupData[0]]);
        return Inertia::render('Dashboard/Index', [
            'students' => $students,
            'teachers' => $teachers,
            'groupData' => $groupData,
        ]);
    }
}
