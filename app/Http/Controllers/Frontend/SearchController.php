<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Commercial;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Process the search form.
     *
     * @param  \Illuminate\Http\Request  $page
     * @return \Illuminate\Http\Response
     */
    public function process(Request $request)
    {
        if($request->input('search-number')) {
            $commercial = Commercial::accepted()->find($request->input('search-number'));
            if($commercial) {
                return redirect()->route('frontend.commercials.show', $commercial->slug);
            }
            return view('frontend.search.blank');
        }
        return redirect()->route('frontend.search.show', ['phrase' => $request->input('search-phrase')]);
    }
    
    public function show(Request $request, $phrase = '')
    {
        $commercials = Commercial::accepted()->where('title', 'LIKE', '%'. $phrase . '%')->paginate();
        return view('frontend.search.show', compact('commercials'));
    }
} 
