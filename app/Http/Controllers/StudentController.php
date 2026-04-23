<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentModel;
use App\Models\ClassModel;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class StudentController extends Controller
{
    public function index() {
        $students = StudentModel::with('class')->orderBy('class_id', 'asc')->get();
        $groupStudents = $students->groupBy('class.class_name')->values()->toArray();
        return Inertia::render('Student/Index', [
            'students' => $students,
            'groupStudents' => $groupStudents,
        ]);
    }

    public function create() {
        $kelas = ClassModel::orderBy('id', 'asc')->get();
        return Inertia::render('Student/Create', [
            'kelas' => $kelas,
        ]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:225',
            'class_name' => 'required|string|exists:class,class_name',
        ]);
        if ($validator->fails()) {
            \Log::info('Student created failed');
            return redirect()->route('student.create')->with('error', 'Name is required');
        }
        $class = ClassModel::where('class_name', $request->class_name)->first();
        if (!$class) {
            \Log::info('Student created failed');
            return redirect()->route('student.create')->with('error', 'Class not found');
        }
        StudentModel::create([
            'name' => $request->name,
            'class_id' => $class->id,
        ]);
        \Log::info('Student created successfully');
        return redirect()->route('student.index')->with('success', 'Student created successfully');
    }

    public function edit($id) {
        $student = StudentModel::with('class')->findOrFail($id);
        $kelas = ClassModel::orderBy('id', 'asc')->get();
        return Inertia::render('Student/Edit', [
            'student' => $student,
            'kelas' => $kelas,
        ]);
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:225',
            'class_name' => 'required|string|exists:class,class_name',
        ]);
        if ($validator->fails()) {
            \Log::info('Student updated failed');
            return redirect()->route('student.edit', $id)->with('error', 'Name is required');
        }
        $student = StudentModel::findOrFail($id);
        $class = ClassModel::where('class_name', $request->class_name)->first();
        if (!$class) {
            \Log::info('Student updated failed');
            return redirect()->route('student.edit', $id)->with('error', 'Class not found');
        }
        $student->name = $request->name;
        $student->class_id = $class->id;
        $student->save();
        \Log::info('Student updated successfully');
        return redirect()->route('student.index')->with('success', 'Student updated successfully');
    }

    public function destroy($id) {
        DB::transaction(function () use ($id) {
            $student = StudentModel::findOrFail($id);
            if (!$student) {
                \Log::info('Student deleted failed');
                throw new \Exception('Student not found');
            }
            $student->delete();
        });
        \Log::info('Student deleted successfully');
        return redirect()->route('student.index')->with('success', 'Student deleted successfully');
    }
}
