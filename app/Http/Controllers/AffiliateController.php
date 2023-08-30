<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;

class AffiliateController extends Controller
{
    public function index(Request $request) {
        $affiliateLink = route('register.form', ['r' => \Helper::setReferrer(Auth::user()->id)]);
        $users = User::where('referrer', Auth::user()->id)->get();
        return view('backend.affiliate.index', compact('users', 'affiliateLink'));
    }
}
