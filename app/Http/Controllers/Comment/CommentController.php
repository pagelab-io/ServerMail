<?php

namespace PageLab\ServerMail\Http\Controllers\Comment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PageLab\ServerMail\Http\Requests;
use PageLab\ServerMail\Http\Controllers\Controller;
use PageLab\ServerMail\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = Comment::all();

        return $todos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comment = Comment::create($request->all());
        $comment->user_id = Auth::user()->id;
        $comment->save();

        return $comment;
    }

}
