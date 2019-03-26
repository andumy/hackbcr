<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Token;

class TwoFactorController extends Controller
{
	public function verifyTwoFactor(Request $request)
    {
        $request->validate([
            'token' => 'required',
        ]);

        $token = Auth::user()->loginToken();
        if($request->input('token') == $token->token ){            
            session(['token_validated' => True]);
            $token->used = True;
            $token->save();

            return redirect('/home');
        } else {
            return redirect('/2fa')->withErrors(['token', 'Wrong token']);
        }
    }

    public function show()
    {
        return view('auth.2fa');
    }  
}
