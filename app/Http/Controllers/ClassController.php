<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class ClassController extends Controller
{
    public function index() {
        $kelas = ClassModel::latest()->get();
        return Inertia::render('Class/Index', [
            'kelas' => $kelas,
        ]);
    }

    public function create() {
        return Inertia::render('Class/Create');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'class_name' => 'required|string|max:225|unique:class,class_name',
        ]);
        if ($validator->fails()) {
            // \Log::info('Class created failed');
            return redirect()->route('class.create')->with('error', 'Class name already exists, please enter another class name');
        } 
        $kelas = ClassModel::create($request->all());
        // g\Log::info('Class created successfully');
        return redirect()->route('class.index')->with('success', 'Class created successfully')->with('kelas', $kelas);
    }

    public function edit($id) {
        $kelas = ClassModel::findOrFail($id);
        return Inertia::render('Class/Edit', [
            'kelas' => $kelas,
        ]);
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'class_name' => 'required|string|max:225|unique:class,class_name',
        ]);
        if ($validator->fails()) {
            // \Log::info('Class updated failed');
            return redirect()->route('class.edit', $id)->with('error', 'Class name already exists, please enter another class name');
        }
        $kelas = ClassModel::findOrFail($id);
        $kelas->update($request->all());
        if (!$kelas) {
            // \Log::info('Class updated failed');
            return redirect()->route('class.edit', $id)->with('error', 'Class not found');
        }
        // \Log::info('Class updated successfully');
        return redirect()->route('class.index')->with('success', 'Class updated successfully');
    }

    public function destroy($id) {
        DB::transaction(function () use ($id) {
            $kelas = ClassModel::findOrFail($id);
            if (!$kelas) {
                throw new \Exception('Class not found');
            }
            $kelas->delete();
        });
        return redirect()->route('class.index')->with('success', 'Class deleted successfully');
    }
}
