<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\SubscribeRequest;
use App\Http\Controllers\Controller;
use App\Mail\Subscribe;
use Mail;

class SubscribesController extends Controller
{
    public function subscribe(SubscribeRequest $request)
    {
        $data = $request->only('subscribe_first_name', 'subscribe_last_name', 'subscribe_phone', 'subscribe_email');
        Mail::send(new Subscribe($data));
        return redirect()->route('client.index');
    }
}
