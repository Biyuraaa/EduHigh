<?php

namespace App\Http\Controllers;

use App\Models\ResultSeminar;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreResultSeminarRequest;
use App\Http\Requests\UpdateResultSeminarRequest;
use Illuminate\Support\Facades\Auth;

class ResultSeminarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role == "dosen") {
        } else if (Auth::user()->role == "admin") {
        } else {
        }
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
    public function store(StoreResultSeminarRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ResultSeminar $resultSeminar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResultSeminar $resultSeminar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateResultSeminarRequest $request, ResultSeminar $resultSeminar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResultSeminar $resultSeminar)
    {
        //
    }
}
