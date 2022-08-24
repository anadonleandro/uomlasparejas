<?php

namespace App\Http\Controllers;


class PagesController extends Controller
{
    public static function index(string $page)
    { 
        if (view()->exists("pages.{$page}")) {
            return view("pages.{$page}");
        }

        return abort(404);

    }

  
}
