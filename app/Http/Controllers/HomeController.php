<?php

namespace App\Http\Controllers;
use App\Message;
use Illuminate\Http\Request;
use App\Events\MessageSent;

class HomeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('chats');
    }

    public function fetchMessage(){
        return Message::with('user')->get();
    }
    public function sendMessage(Request $request)
    {
        /*dd($request->message);
        auth()->user()->messages()->create([
            'message' => $request->message
        ]);*/
        $message = new Message;
        $message->user_id = auth()->user()->id;
        $message->message = $request->message;
        $message->save();
        //dd($message->load('user'));
        broadcast(new MessageSent($message->load('user')))->toOthers(); 

        return ['status' => 'success'];
    }
}
