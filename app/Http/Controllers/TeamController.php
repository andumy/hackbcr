<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\User;
use App\Role;
use DB;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $user = User::where('id',$data['user_id'])->first();
        $team_worker = Role::where('name','team_worker')->first()->id;
        
            DB::table('role_user')->insert([
                'user_id' => $user->id,
                'role_id' => $team_worker,
                'team_id' => $data['team_id']
            ]);


        

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lead_id = Role::where('name','team_lead')->first()->id;
        $lead = DB::table('role_user')
        ->where('team_id',$id)
        ->where('role_id',$lead_id)->pluck('id')->toArray();


        if(array_key_exists('id',$lead))
            $lead = $lead->id;
        else
            $lead = null;


        $ids =  DB::table('role_user')
        ->where('team_id',$id)
        ->pluck('user_id')->toArray();

        $users = User::whereIn('id',$ids)->get();
        $team =  Team::where('id',$id)->first();
        $allusers = User::whereHas('roles',function($q){
            $q = $q->where('name','!=','admin');
        })->get();
        return view('team.edit')->with(['team' => $team,'users'=>$users ,'allusers' => $allusers,'lead' => $lead]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function remove($user_id,$team_id){
        
        $rls = Role::whereIn('name',['team_worker','team_lead'])->pluck('id')->toArray();

      
        DB::table('role_user')
            ->whereIn('role_id',$rls)
            ->where('team_id',$team_id)
            ->where('user_id',$user_id)
            ->delete();


        $team =  Team::where('id',$team_id)->first();

        $users_id = DB::table('role_user')
                ->where('team_id',$team_id)
                ->pluck('user_id')->toArray();
        
        $allusers = User::whereNotIn('id',$users_id)->get();
        
        return redirect()->route('home');
        return view('team.edit')->with(['team' => $team,'allusers' => $allusers]);
    }

    public function lead($user_id,$team_id){

        $lead_id = Role::where('name','team_lead')->first()->id;
        $worker_id = Role::where('name','team_worker')->first()->id;

        $ex_lead = DB::table('role_user')
        ->where('team_id',$team_id)
        ->where('role_id',$lead_id)->pluck('user_id')->toArray();



        

        DB::table('role_user')
            ->whereIn('role_id',[$lead_id,$worker_id])
            ->where('user_id',$user_id)
            ->where('team_id',$team_id)
            ->delete();
        
        
        
        DB::table('role_user')->insert([
                'user_id' => $user_id,
                'role_id' => $lead_id,
                'team_id' => $team_id
        ]);

        if(count($ex_lead) != 0)
        {
            $ex_lead = $ex_lead[0];

            DB::table('role_user')
            ->where('user_id' ,$ex_lead)
            ->where('role_id' , $lead_id)
            ->where('team_id' , $team_id)
            ->delete();

            DB::table('role_user')->insert([
                'user_id' => $ex_lead,
                'role_id' => $worker_id,
                'team_id' => $team_id
            ]);
    
        }

        return redirect()->route('home');
    }

}
