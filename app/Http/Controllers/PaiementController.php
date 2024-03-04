<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaiementController extends Controller
{
    public function create(Request $request)
    {
        dd(Auth::user());
        $plan = Plan::where('id', $request->id)->firstOrFail();
        User::where('id', $request->id)->increment('available_tcf',$plan->tcf);
        User::where('id', $request->id)->increment('available_ielts',$plan->ielts);
        User::where('id', $request->id)->increment('available_lettres',$plan->letters);

        $user = Auth::user();

        $user->max_tcf=$plan->tcf;
        $user->max_ielts=$plan->ielts;
        $user->max_lettres=$plan->letters;
        $user->plan=$plan->id;
        $user->subscribed='yes';
        $user->save();

        return view('paiement');
    }
}
