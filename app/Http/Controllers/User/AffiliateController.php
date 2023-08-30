<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

class AffiliateController extends Controller
{
    public function index(Request $request) {
        $affiliateLink = route('register.form', ['r' => \Helper::setReferrer(Auth::user()->id)]);
        $users = User::where('referrer', Auth::user()->id)->get();
        return view('user.affiliate.index', compact('users', 'affiliateLink'));
    }
}
