<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\Siswa;

class DashboardController extends Controller
{
    public function index() {
        return view('admin.dashboard');
    }
}
