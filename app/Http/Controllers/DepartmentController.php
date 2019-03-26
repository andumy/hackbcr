<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use App\User;
use App\Role;
use DB;

class DepartmentController extends Controller
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

        if($user->hasRole('dep_lead')){
            
            $worker_id = Role::where('name','dep_worker')->first()->id;
            $lead_id = Role::where('name','dep_lead')->first()->id;

            DB::table('role_user')
            ->where('role_id',$lead_id)
            ->where('user_id',$user->id)
            ->delete();

            DB::table('role_user')->insert([
                'user_id' => $user->id,
                'role_id' => $worker_id,
                'team_id' => null
            ]);
        }

        $user->department_id = $data['department_id'];
        $user->save();
        

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
        $department =  Department::where('id',$id)->first();
        $allusers = User::whereHas('roles',function($q){
            $q = $q->where('name','!=','admin');
        })->get();
        return view('department.edit')->with(['department' => $department,'allusers' => $allusers]);
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

    public function remove($user_id,$depart_id){
        
        $user = User::where('id',$user_id)->first();
        $depart = Department::where('id',$depart_id)->first();
        $rls = Role::whereIn('name',['dep_worker','dep_lead'])->pluck('id')->toArray();
        DB::table('role_user')
            ->whereIn('role_id',$rls)
            ->where('user_id',$user->id)
            ->delete();

        $user->department_id = null;
        $user->save();

        $department =  Department::where('id',$depart_id)->first();
        $allusers = User::where('department_id','!=',$id)->get();
        return redirect()->route('home');
        return view('department.edit')->with(['department' => $department,'allusers' => $allusers]);
    }

    public function lead($user_id,$depart_id){

        $lead_id = Role::where('name','dep_lead')->first()->id;
        $worker_id = Role::where('name','dep_worker')->first()->id;

        $ex_lead = User::whereHas('roles',function($q){
            $q = $q->where('name','dep_lead');
        })
        ->where('department_id',$depart_id)->first();

        DB::table('role_user')
            ->whereIn('role_id',[$lead_id,$worker_id])
            ->where('user_id',$user_id)
            ->delete();
        
        
        
        DB::table('role_user')->insert([
                'user_id' => $user_id,
                'role_id' => $lead_id,
                'team_id' => null
        ]);
        
    

        
        
        

        if($ex_lead)
        {
            $ex_lead = $ex_lead->id;

            $ex_line = DB::table('role_user')
            ->where('user_id' ,$ex_lead)
            ->where('role_id' , $lead_id)
            ->delete();

            DB::table('role_user')->insert([
                'user_id' => $ex_lead,
                'role_id' => $worker_id,
                'team_id' => null
            ]);
    
        }

        $department =  Department::where('id',$depart_id)->first();
        $allusers = User::where('department_id','!=',$depart_id)->get();
        return redirect()->route('home');
    }
}
