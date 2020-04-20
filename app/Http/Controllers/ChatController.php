<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Message;
use App\BadWord;
use Auth;
use App\Events\NewMessage;




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
        $data['messages']=null;
        $data['other_user']=null;
        return view('user.chat',$data);
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


         $request->validate([ 'body' => 'required',
         'user_sender_id'               => 'required',
         'user_reciver_id'              => 'required',
         ]);
         

         $message = new Message();
         $message->user_sender_id = $request->user_sender_id;
         $message->user_reciver_id = $request->user_reciver_id;
         $message->body = $request->body;
         $message->save();
         $data['message']=$message;
         $data['channel_id']=$this->getChannelID($message->user_sender_id,$message->user_reciver_id);
         $user = Auth::user();
         broadcast(new NewMessage($data))->toOthers();
         return  response()->json($message);
         // return redirect()->action('ChatController@show',$massege->user_sender_id,$message->user_reciver_id);


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
        $where1 = array('user_sender_id' => $id1,'user_reciver_id'=>$id2);
        $where2 = array('user_sender_id' => $id2,'user_reciver_id'=>$id1);
        $data['messages']= Message::where('user_sender_id',$id1)->where('user_reciver_id',$id2)->orwhere('user_sender_id',$id2)->where('user_reciver_id',$id1)->get();
        $data['other_user'] = User::find($id2);
        $data['channel_id']=$this->getChannelID($id1,$id2);
        return response()->json($data);
        //Message::where($where1)->orwhere($where2)->get();
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

    /**
     * Calculate a unique integer based on two integers (cantor pairing).
     * should be one unique integer based on sender ID - reciver ID and vis versal.
     * we cant depend on the arange cause the sender can be a reciver , then it will handeled as new channel. 
     */
    public function getChannelID($x,$y)
    {

        return ((($x + $y) * ($x + $y + 1)) / 2 );

    }

}
