<?php

namespace App\Http\Controllers;
use App\User;
use App\Department;
use App\Team;
use App\Role;
use Auth;

use DB;
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
        if(Auth::user()->hasRole('admin')){
            //set teams table
            $teams = Team::all();
            $data_team = [];
            foreach($teams as $team){
                $deps = [];
                $ids =  DB::table('role_user')
                    ->where('team_id',$team->id)
                    ->pluck('user_id')->toArray();
                
                $users = User::whereIn('id',$ids)->get();
                
                foreach($users as $user){
                    if($user->department_id != null){
                        $deps[] = $user->department->name;
                    }
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
        }
        else{
            $data_dep = new \stdClass;
            $data_dep->id = Auth::user()->department_id;
            $data_dep->name = Department::where('id', $data_dep->id)->first()->name;
            
            if(Auth::user()->hasRole('dep_lead')){
                $users = User::where('department_id',$data_dep->id)->whereNot('id',Auth::user()->id)->get();
            }
            if(Auth::user()->hasRole('dep_worker')){
                $users = User::where('department_id',$data_dep->id)
                ->whereHas('roles',function($q){
                    $q = $q->where('name','!=','dep_lead');
                })
                ->where('id','!=',Auth::user()->id)
                ->get();
            }
            $data_dep->users = $users;

            $worker_id = Role::where('name','team_worker')->first()->id;
            $lead_id = Role::where('name','team_lead')->first()->id;



            $teams_work = DB::table('role_user')
                ->where('user_id',Auth::user()->id)
                ->where('role_id',$worker_id)
                ->pluck('team_id')->toArray();

            $teams_work = Team::whereIn('id',$teams_work)->get();

            

            $teams_lead = DB::table('role_user')
                ->where('user_id',Auth::user()->id)
                ->where('role_id',$lead_id)
                ->pluck('team_id')->toArray();
            $teams_lead = Team::whereIn('id',$teams_lead)->get();

            
            $data_team = [];
            foreach($teams_work as $team){
                $ids = DB::table('role_user')
                ->where('team_id',$team->id)
                ->where('role_id',$worker_id)
                ->pluck('user_id')->toArray();

                $users = User::whereIn('id',$ids)->where('id','!=',Auth::user()->id)->get();

                $data_team[] = (object)[
                    'name' => $team->name,
                    'users' => $users,
                ];

            }

            foreach($teams_lead as $team){
                $ids = DB::table('role_user')
                ->where('team_id',$team->id)
                ->where('role_id',$worker_id)
                ->pluck('user_id')->toArray();

                $users = User::whereIn('id',$ids)->get();
                
                $data_team[] = (object)[
                    'name' => $team->name,
                    'users' => $users,
                ];

            }
        }


        return view('dashboard')->with(['departments' => $data_dep, 'teams'=>  $data_team]);
    }
}
