<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Response;

class TwoFactorVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $value = session('token_validated');
        session(['token_validated' => True]);
        $value = True;

        if($value){
            return $next($request);
        }

        if(Auth::guest()){
            return redirect('/login');
        }

        if (!$request->session()->has('token_validated')) {
            $user = Auth::user();
            $user->generateToken();
            // $user->sendToken();
            session(['token_validated' => False]);
        }

        // var_dump($request->all());
        // die();
        // if ($errors->isEmpty()) {

        // }else{
        //     var_dump($errors);
        //     die();
        // }


        return new Response(view('auth.2fa'));
    }
}
