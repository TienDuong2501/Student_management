<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentCreateRequest;
use App\Models\Comment;
use App\Models\User;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(CommentCreateRequest $request)
    {
        $comment = Comment::create([
            'commenter_id' => auth()->id(),
            'user_id' => $request->user_id,
            'content' => $request->content,
        ]);

        $user = User::find($request->user_id);

        if ($comment) {
            return redirect()->back()->with(['user' => $user, 'success' => 'commented  successfully']);
        }

        return redirect()->back()->with(['user' => $user, 'error' => 'commented failed']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, Comment $comment)
    {
        $comment->content = $request->content;
        $comment->save();

        if ($comment) {
            return redirect()->route('users.show', ['id' => $request->user_id])->with(['success' => 'updated comment  successfully']);
        }

        return redirect()->route('users.show', ['id' => $request->user_id])->with(['error' => 'updated comment failed']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Comment $comment)
    {
        if ($comment->delete()) {
            return redirect()->back()->with(['success' => 'deleted comment  successfully']);
        }

        return redirect()->back()->with(['error' => 'deleted comment failed']);
    }
}
