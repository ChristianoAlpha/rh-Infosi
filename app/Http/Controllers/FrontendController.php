<?php

namespace App\Http\Controllers;
use App\Models\Department;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return view('frontend.index', compact('departments'));
    }

    public function about()
    {
        return view('frontend.about');
    }
}
