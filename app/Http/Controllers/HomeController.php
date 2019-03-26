<?php

namespace App\Http\Controllers;
use App\User;
use App\Department;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $departments = Department::all();
//        foreach($departments as $depart){
//            var_dump($depart->name);
//            var_dump(count($depart->users->toArray()));
//
//        }
//        die();
        return view('dashboard')->with('departments', $departments);
    }
}
