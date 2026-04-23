<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeacherModel;
use App\Models\ClassModel;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class TeachersController extends Controller
{
    public function index(){
        $teachers = TeacherModel::with('class')->orderBy('class_id', 'asc')->get();
        $groupTeachers = $teachers->groupBy('class.class_name')->values()->toArray();
        return Inertia::render('Teacher/Index', [
            'teachers' => $teachers,
            'groupTeachers' => $groupTeachers,
        ]);
    }

    public function create() {
        $kelas = ClassModel::orderBy('id', 'asc')->get();
        return Inertia::render('Teacher/Create', [
            'kelas' => $kelas,
        ]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:225',
            'class_name' => 'required|string|exists:class,class_name',
        ]);
        if ($validator->fails()) {
            return redirect()->route('teacher.create')->with('error', 'Name is required');
        }
        $class = ClassModel::where('class_name', $request->class_name)->first();
        if (!$class) {
            \Log::info('Teacher created failed');
            return redirect()->route('teacher.create')->with('error', 'Class not found');
        }
        TeacherModel::create([
            'name' => $request->name,
            'class_id' => $class->id,
        ]);
        \Log::info('Teacher created successfully');
        return redirect()->route('teacher.index')->with('success', 'Teacher created successfully');
    }

    public function edit($id) {
        $teacher = TeacherModel::with('class')->findOrFail($id);
        $kelas = ClassModel::orderBy('id', 'asc')->get();
        return Inertia::render('Teacher/Edit', [
            'teacher' => $teacher,
            'kelas' => $kelas,
        ]);
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:225',
            'class_name' => 'required|string|exists:class,class_name',
        ]);
        if ($validator->fails()) {
            return redirect()->route('teacher.edit', $id)->with('error', 'Name is required');
        }
        $teacher = TeacherModel::findOrFail($id);
        $kelas = ClassModel::where('class_name', $request->class_name)->first();
        if(!$kelas) {
            \Log::info('Teacher updated failed');
            return redirect()->route('teacher.edit', $id)->with('error', 'Class not found');
        }
        $teacher->name = $request->name;
        $teacher->class_id = $kelas->id;
        $teacher->save();
        \Log::info('Teacher updated successfully');
        return redirect()->route('teacher.index')->with('success', 'Teacher updated successfully');
    }

    public function destroy($id) {
        DB::transaction(function () use ($id) {
            $teacher = TeacherModel::findOrFail($id);
            if(!$teacher) {
                \Log::info('Teacher deleted failed');
                throw new \Exception('Teacher not found');
            }
            $teacher->delete();
        });
        return redirect()->route('teacher.index')->with('success', 'Teacher deleted successfully');
    }
}
