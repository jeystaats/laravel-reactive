<?php

namespace App\Http\Controllers;

use App\Events\IncomingMessage;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function handle(Request $request)
    {
        event(new IncomingMessage($request->user(), $request->get('message')));

        return response()->json(['user' => $request->user(), 'message' => $request->get('message')]);
    }
}
