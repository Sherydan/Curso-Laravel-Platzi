<?php

namespace App\Http\Controllers;
\Debugbar::disable();
use App\Message;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
    
    $messages = Message::with('user')->orderBy('created_at', 'desc')->paginate(10);
    
    return view('pages.index', ['messages' => $messages]);
    }

    public function about(){
        return view('pages.about');
    }
}
