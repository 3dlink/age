<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();
        if ($user->hasRole('analista') || $user->hasRole('supervisor')) {
            return redirect(url('/task'));
        } elseif ($user->hasRole('usuario')) {
            return redirect(url('/analyst/'.date('Y', strtotime('now')).'/'.date('m', strtotime('now'))));
        } else {
            return view('pages.home');
        }
    }

    public function getHome()
    {
        return view('pages.home');
    }

}
