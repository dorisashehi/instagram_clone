<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    //
     //index page
     public function index(){
        $title="Index Page";
        return view('pages.index',compact('title'));
       // return view('pages.index')->with('title',$title);
    }

    //about page
    public function about(){
        $title='About Page';
        return view('pages.about')->with('title',$title);
    }

    //services page
    public function services(){
        $title='Services Page';
        $data=array(

            'title'=>'services',
            'services'=>['Web design','e-commerce','design']
        );
        return view('pages.services')->with($data);
    }


}
