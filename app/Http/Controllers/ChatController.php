<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Message;
use App\BadWord;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['current_user']= Auth::user();
        $data['users']= User::all()->sortBy('name');
        return view('user.users_list',$data);
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
        //
         $request->validate([ 'message' => 'required',
         'user_sender_id'               => 'required',
         'user_reciver_id'              => 'required',
         ]);

         $massege = new Message();
         $massege->user_sender_id = $request->user_sender_id;
         $message->user_reciver_id = $request->user_reciver_id;
         $message->message = $request->message;
         $message->save();
         return redirect()->action('ChatController@show',$massege->user_sender_id,$message->user_reciver_id);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id1,$id2)
    {
        //
        $where = array('user_sender_id' => $id1,'user_reciver_id'=>$id2);
        $data['masseges']= Message::where($where)->get()->sortBy('created_at');
        return view('user.chat',$data);
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
