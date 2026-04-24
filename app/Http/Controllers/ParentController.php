<?php

namespace App\Http\Controllers;

use App\Models\ParentModel;
use App\Models\StudentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ParentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parent = ParentModel::with('student')->get();
        return Inertia::render('Parent/Index', [
            'parent' => $parent
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $student = StudentModel::orderBy('id', 'asc')->get();
        return Inertia::render('Parent/Create', [
            'student' => $student
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // \Log::info('request', $request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:225|unique:parent_models,name',
            'student_id' => 'required|exists:students,id|unique:parent_models,student_id',
        ]);
        if ($validator->fails()) {
            // \Log::info('Class created failed');
            return redirect()->route('parent.create')->with('error', 'Parent name already exists, please enter another name or student already has a parent');
        }
        ParentModel::create($request->all());
        return redirect()->route('parent.index')->with('success', 'Parent created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $parent = ParentModel::with('student')->findOrFail($id);
        $student = StudentModel::orderBy('id', 'asc')->get();
        return Inertia::render('Parent/Edit', [
            'parent' => $parent,
            'student' => $student
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:225',
            'student_id' => 'required|exists:students,id',
        ]);
        if ($validator->fails()) {
            return redirect()->route('parent.edit', $id)->with('error', 'Name is required');
        }
        $parent = ParentModel::findOrFail($id);
        $parent->name = $request->name;
        $parent->student_id = $request->student_id;
        $parent->save();
        return redirect()->route('parent.index')->with('success', 'Parent updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $parent = ParentModel::findOrFail($id);
        if (!$parent) {
            return redirect()->route('parent.index')->with('error', 'Parent not found');
        }
        $parent->delete();
        return redirect()->route('parent.index')->with('success', 'Parent deleted successfully');
    }
}
