<?php

namespace App\Http\Controllers;

use App\Department;
use App\Feedback;
use App\Team;
use App\User;
use Illuminate\Http\Request;
use Auth;
use App\Transaction;
use App\Token;



class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Auth::user()->transactions;

        return view('transactions.show')->with('transactions',$transactions)
            ->with('no_departments', Department::count())
            ->with('no_teams', Team::count())
            ->with('no_users', User::count())
            ->with('no_feedbacks', Feedback::count());;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('transactions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $transaction = new Transaction();
        $transaction->type = $request->input('type');
        $transaction->description = $request->input('description');
        $transaction->status = 'pending';
        $transaction->user_id = Auth::user()->id;
        $transaction->save();

        $token = new Token();
        $token->user_id = Auth::user()->id;
        $token->type = 'transaction';
        $token->transaction_id = $transaction->id;
        $token->token = mt_rand(10000,99999);
        $token->used = false;
        $token->save();

        $telefon = Auth::user()->phone;
        $send_token = $token->token;
        // $ch = curl_init();
        // $user = env('SMSHW_USER',null);
        // $password = env('SMSHW_PASSWORD',null);
        // $number = "$telefon";
        // $label = 'CodeFest';
        // $text = "Your code for transaction is $send_token";
        // $data = array(
        //  'user' => $user,
        //  'number' => $number,
        //  'text' => $text,
        //  'label' => $label,
        //  'sum' => sha1($user . $number . $text . $label . sha1($password))
        // );
        // curl_setopt($ch, CURLOPT_URL, 'https://api.smshighway.com/sms/send');
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        // $request_output = curl_exec($ch);
        // $request_info = curl_getinfo($ch);

        return view('transactions.sign')->with('transaction',$transaction);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sign(Transaction $trans, Request $req)
    {
        $token = $req->input('token') ? $req->input('token') : 'error' ;
        $actula_token = Token::where('transaction_id',$trans->id)->where('used',false)->orderBy('created_at','desc')->first();

        if( $token == $actula_token->token){
            $token_model = Token::where('token',$token)->where('transaction_id',$trans->id)->first();
            $token_model->used = True;
            $token_model->save();
            $trans->status = 'Signed';
            $trans->save();
        }else{
            return view('transactions.sign')->with('transaction',$trans)->withErrors(['token' => 'Invalid token']);
        }


        return redirect('/transaction');
    }

    public function sign_off(Transaction $trans)
    {

        $actula_token = Token::where('transaction_id',$trans->id)->where('used',false)->orderBy('created_at','desc')->first();
        $telefon = Auth::user()->phone;
        $send_token = $actula_token->token;
        // $ch = curl_init();
        // $user = env('SMSHW_USER',null);
        // $password = env('SMSHW_PASSWORD',null);
        // $number = "$telefon";
        // $label = 'CodeFest';
        // $text = "Your code for transaction is $send_token";
        // $data = array(
        //  'user' => $user,
        //  'number' => $number,
        //  'text' => $text,
        //  'label' => $label,
        //  'sum' => sha1($user . $number . $text . $label . sha1($password))
        // );
        // curl_setopt($ch, CURLOPT_URL, 'https://api.smshighway.com/sms/send');
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        // $request_output = curl_exec($ch);
        // $request_info = curl_getinfo($ch);
        
       return view('transactions.sign')->with('transaction',$trans);
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
        //
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
}
