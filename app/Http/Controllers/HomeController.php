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
        $data_dep = [];
        foreach($departments as $depart){
            $lead_user = User::where('department_id',$depart->id)
                        ->whereHas('roles', function ($query) {
                            $query->where('name', '=', 'dep_lead');
                        })
                        ->first();
            $lead_user_name = $lead_user ? $lead_user->first_name." ".$lead_user->last_name : null;
            $data_dep[] = (object)[
                'name' => $depart->name,
                'count' => count($depart->users->toArray()),
                'lead' => $lead_user_name
            ];
            
        } 

        return view('dashboard')->with(['departments' => $data_dep]);
    }
}
