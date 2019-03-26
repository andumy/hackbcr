<?php

namespace App\Http\Controllers;
use App\User;
use App\Department;
use App\Team;

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
        //set teams table
        $teams = Team::all();
        $data_team = [];
        foreach($teams as $team){
            $deps = [];
            foreach($team->users as $user){
                
                 $deps[] = $user->department->name;
            }
            
            $deps = array_unique($deps);
            $lead_user = User::whereHas('roles', function ($query) use($team){
                $query->where('name', '=', 'team_lead')->where('team_id','=',$team->id);
            })
            ->first();
            $lead_user_name = $lead_user ? $lead_user->first_name." ".$lead_user->last_name : null;
            
            $data_team[] = (object) [
                'id' => $team->id,
                'name' => $team->name,
                'lead' => $lead_user_name,
                'dep_comp' => $deps,
            ];
        }

        //set department table
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
                'id' => $depart->id,
                'name' => $depart->name,
                'count' => count($depart->users->toArray()),
                'lead' => $lead_user_name
            ];
            
        } 

        return view('dashboard')->with(['departments' => $data_dep, 'teams'=>  $data_team]);
    }
}
