<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function about()
    {
        return view('about');
    }
    public function features()
    {
        return view('features');
    }
     public function pricing()
    {
        return view('pricing');
    }
     public function solution()
    {
        return view('solution');
    }
     
}