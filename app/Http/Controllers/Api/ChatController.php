<?php

namespace App\Http\Controllers\Api;

use App\Events\SendMessageEvent;
use App\Http\Controllers\Controller;
use App\Message;
use App\User as AppUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ChatController extends Controller
{

    //
    public function fetchMessages(){
        return Message::with('user')->get();
    }
    public function sendMessage(Request $request){

        $request->validate([
            'user_id'=> 'required',
            'message' => 'required'
        ]);

       $message = new Message();
       $message->user_id = intval($request->input('user_id'));
       $message->message = $request->input('message');
       $message->save();
       broadcast(new SendMessageEvent($message->load('user')))->toOthers();
        return [
            'status' => 'success'
        ];
    }
}
