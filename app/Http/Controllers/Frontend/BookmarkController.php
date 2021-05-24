<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Bookmark;
use App\Models\Commercial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookmarkController extends Controller
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
    public function store(Request $request)
    {
        abort_unless($request->ajax(), 404);
        if(!auth()->check()) {
            $message = [
                'status'    => 'danger',
                'body'      => "برای نشان کردن آگهی، ابتدا باید ثبت نام کنید.",
            ];
            return response()->json($message);
        }
        $commercial = Commercial::whereSlug($request->commercial)->first();
        if(!$commercial) {
            $message = [
                'status'    => 'danger',
                'body'      => "آگهی مورد نظر شما معتبر نیست!",
            ];
            return response()->json($message);
        }
        $bookmark = $commercial->bookmarks()->wherePivot('user_id', auth()->id())->first();
        if($bookmark) {
            Bookmark::where('user_id', auth()->id())->where('commercial_id', $commercial->id)->delete();
            //$commercial->bookmarks()->detach();//wherePivot('user_id', auth()->id())->delete();
            $msg = 'نشان آگهی شما با موفقیت حذف شد.';
        } else {
            $commercial->bookmarks()->save(auth()->user());
            $msg = 'آگهی شما با موفقیت نشان شد.';
        }
        $message = [
            'status'    => 'success',
            'body'      => $msg,
            'fields'    => '',
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
