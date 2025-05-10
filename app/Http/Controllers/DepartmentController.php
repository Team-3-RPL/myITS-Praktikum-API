<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Department::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        $department = Department::create($request->validated());

        return response()->json([
            'status' => 'true',
            'message' => 'Department created successfully',
            'data' => $department,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $department->update($request->validated());

        return response()->json([
            'status' => 'true',
            'message' => 'Department updated successfully',
            'data' => $department,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return response()->json([
            'status' => 'true',
            'message' => 'Department deleted successfully',
        ], 200);
    }
}
