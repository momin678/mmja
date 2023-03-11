<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view('backend.dashboard');
    }

    public function form_layout(){
        return view('backend.forms.form-layout');
    }

    public function form_input(){
        return view('backend.forms.form-layout');
    }
}
