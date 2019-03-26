<?php

namespace App\Http\Controllers;

use App\Department;
use App\Team;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Feedback;


class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feedbacks = Auth::user()->recievedFeedbacks;

        $display = array();

        foreach ($feedbacks as $feedback) {
            array_push($display,[
                'from' => User::find($feedback->from_id)->first_name ." ".User::find($feedback->from_id)->last_name,
                'message' => $feedback->message,
            ]);
        }
        return view('feedback.show')->with('feedbacks',$display)
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
    public function create(Request $req)
    {
        $id = $req->input('id');
        return view('feedback.create')->with('id',$id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $feedback = new Feedback();
        $feedback->from_id = Auth::user()->id;
        $feedback->to_id = $request->input('to_id');
        $feedback->message = $request->input('feedback');
        $feedback->save();

        return redirect('/home');
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
