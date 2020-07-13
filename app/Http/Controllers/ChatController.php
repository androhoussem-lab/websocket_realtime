<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        return view('chat');
    }
    public function fetchMessages(){
        return Message::with('user')->get();
    }
    public function sendMessage(Request $request){
       $message = new Message();
       $message->message = $request->message;
       $message->save();
        return [
            'status' => 'success'
        ];
    }
}
