<?php
namespace App\Http\Controllers;
use App\User;
use App\Http\Controllers\Controller;

class BackController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function index()
    {
        return view('back.layout');
    }

    public function login()
    {
        return view('login');
    }
}