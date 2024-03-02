<?php

namespace App\Http\Controllers;

use App\Models\CoverLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function editor(Request $request)
    {
        /* dd($request->id); */
        $cover = CoverLetter::where('user_id', Auth::id())->findOrFail($request->id);
        $cover_id = $request->id;
        return view('editor', compact('cover','cover_id'));
    }
    public function saveCover(Request $request)
    {
        $cover = CoverLetter::where('user_id', Auth::id())->findOrFail($request->cover_id);
        //$NewCover = strip_tags($request->cover);
        $extractedContent = preg_replace('/<[\/]?p[^>]*>/', '', $request->cover);

        $cover->letter = $extractedContent;
        $cover->save();
        return 'saved';
    }
}
