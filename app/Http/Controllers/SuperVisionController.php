<?php

namespace App\Http\Controllers;

use App\Models\SuperVision;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSuperVisionRequest;
use App\Http\Requests\UpdateSuperVisionRequest;

class SuperVisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('dashboard.mahasiswa.supervisions.index');
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
    public function store(StoreSuperVisionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SuperVision $superVision)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuperVision $superVision)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSuperVisionRequest $request, SuperVision $superVision)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuperVision $superVision)
    {
        //
    }
}
