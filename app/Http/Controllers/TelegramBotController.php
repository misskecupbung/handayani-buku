<?php

namespace App\Http\Controllers;

use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Http\Request;

class TelegramBotController extends Controller
{
    public function updatedActivity()
    {
        $activity = Telegram::getUpdates();
        dd($activity); //die and dump
    }

    public function sendMessage()
    {
        return view('message');
    }

    public function storeMessage(Request $request)
    {
        $request->validate([
            'email'     => 'required|email',
            'message'   => 'required'
        ]);

        $text = "<b>Anda mendapat pesan baru dari :</b>\n\n"
            . "<b>Email  : </b>" . "$request->email\n"
            . "<b>Pesan : </b>" . "$request->message";

        Telegram::sendMessage([
            'chat_id'       => env('TELEGRAM_CHANNEL_ID', '-1001441893813'),
            'parse_mode'    => 'HTML',
            'text'          => $text
        ]);

        return redirect()->back();
    }
}