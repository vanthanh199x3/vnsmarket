<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArtisanController extends Controller
{
    function command(Request $request) {
        \Artisan::call($request->command);
        echo 'php artisan '.$request->command;
    }
}
