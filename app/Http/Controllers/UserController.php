<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\CoverLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function editor(Request $request)
    {
        /* dd($request->type); */

        if ($request->type == 'lang') {
            $type = 'lang';
            $data = Language::where('user_id', Auth::id())->findOrFail($request->id);
        } else {
            $type = 'cover';
            $data = CoverLetter::where('user_id', Auth::id())->findOrFail($request->id);
        }
        if ($data->status =="error") {
            abort(404);
        }
        $data_id = $data->id;
        return view('editor', compact('data','data_id','type'));
    }

    public function saveCover(Request $request)
    {
        if ($request->type =='cover') {
            $cover = CoverLetter::where('user_id', Auth::id())->findOrFail($request->cover_id);

        //$NewCover = strip_tags($request->cover);
        $extractedContent = preg_replace('/<[\/]?p[^>]*>/', '', $request->cover);

        $cover->letter = $extractedContent;
        $cover->save();
        return 'saved';
        } else {
            $article = Language::where('user_id', Auth::id())->findOrFail($request->cover_id);
            //$NewCover = strip_tags($request->cover);
            $extractedContent = preg_replace('/<[\/]?p[^>]*>/', '', $request->cover);

            $article->article = $extractedContent;
            $article->save();
            return 'saved';
        }

    }
}
