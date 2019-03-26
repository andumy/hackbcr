<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExempleController extends Controller
{
    public function __construct(){
        $this->middleware('permission:manage-user', ['only' => ['create', 'store', 'edit', 'delete']]);
        $this->middleware('permission:manage-altceva', ['except' => ['index', 'show']]);
    }


    public function view(){
        // la nivel de view se face asa:
        /*

        @permission('manage-altceva')
            cod de blade
        @endpermission

        */
    }
}
