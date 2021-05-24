<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Commercial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
     * @param  \App\Http\Requests\CommentRequest  $request
     * @param  \App\Models\Commercial  $commercial
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request, Commercial $commercial)
    {
        abort_unless($request->ajax(), 404);
        $request->merge([
            'is_private'    => $request->is_private ?? 0,
            'receiver_id'   => $commercial->user_id,
            'sender_id'     => auth()->check() ? auth()->id() : null,
        ]);
        $comment = $commercial->comments()->create($request->only([
            'name',
            'mobile',
            'content',
            'is_private',
            'receiver_id',
            'sender_id',
        ]));
        session(['sentComment' => true]);
        $message = [
            'status'    => 'success',
            'body'      => 'پیام شما با موفقیت ذخیره گردید.',
        ];
        return response()->json($message);
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
}
