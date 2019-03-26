<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Team;
use App\Department;
use App\Feedback;

class ExempleController extends Controller
{
    public function __construct(){
       // $this->middleware('permission:manage-user', ['only' => ['create', 'store', 'edit', 'delete']]);
      //  $this->middleware('permission:manage-altceva', ['except' => ['index', 'show']]);
    }


    public function view(){
        // la nivel de view se face asa:
        /*

        @permission('manage-altceva')
            cod de blade
        @endpermission

        */
    }

    public function index(){
        $user_id = 4;

        $user = User::where('id',$user_id)->first();
        foreach($user->sentFeedbacks as $feedback)
        var_dump($feedback->message);
    }

}
