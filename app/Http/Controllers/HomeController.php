<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


    public function ajaxCalculateMatrix(Request $request)
    {
        $post = $request->post();

        $this->validate($request, [
            'a11' => 'required|integer',
            'a12' => 'required|integer',
            'a13' => 'required|integer',
            'a21' => 'required|integer',
            'a22' => 'required|integer',
            'a23' => 'required|integer',
            'a31' => 'required|integer',
            'a32' => 'required|integer',
            'a33' => 'required|integer',
        ]);

        $res = $post['a11'] + $post['a22'] + $post['a33']
            + $post['a13'] + $post['a22'] + $post['a31'];


        return response()->json([
            'res' => $res,
        ], 200);
    }
}
