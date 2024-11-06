<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            return view('dashboard.admin.index');
        } else if (Auth::user()->role == 'dosen') {
            return view('dashboard.dosen.index');
        } else {
            return view('dashboard.mahasiswa.index');
        }
    }
}
