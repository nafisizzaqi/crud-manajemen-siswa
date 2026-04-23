<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $request->validate([
            'class_name' => 'required|string|max:225|unique:class,class_name',
        ]);
        $kelas = ClassModel::create($request->all());
        return redirect()->route('class.index')->with('success', 'Class created successfully')->with('kelas', $kelas);
    }

    public function edit($id) {
        $kelas = ClassModel::findOrFail($id);
        return Inertia::render('Class/Edit', [
            'kelas' => $kelas,
        ]);
    }

    public function update(Request $request, $id) {
        $request->validate([
            'class_name' => 'required|string|max:225|unique:class,class_name',
        ]);
        $kelas = ClassModel::findOrFail($id);
        $kelas->update($request->all());
        return redirect()->route('class.index')->with('success', 'Class updated successfully')->with('kelas', $kelas);
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
