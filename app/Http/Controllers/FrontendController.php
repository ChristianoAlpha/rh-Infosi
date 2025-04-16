<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Statute;
use App\Models\Admin;

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

    public function statute()
    {
        $statute = Statute::orderBy('created_at', 'desc')->first();
        return view('frontend.statute', compact('statute'));
    }

    public function directors()
    {
        $directors = Admin::where('role', 'director')->get();
        return view('frontend.directors', compact('directors'));
    }
}