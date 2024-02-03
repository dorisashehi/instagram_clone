<?php

namespace App\Http\Controllers;
use App\Post;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');//protect accessing a specific route without login as a user.
    }

    //index
    public function index(){

        $users=auth()->user()->following()->pluck('profiles.user_id');
        $posts=Post::whereIn('user_id',$users)->orderBy('created_at','DESC')->with('user')->paginate(5);
        //dd($posts);
        return view('posts.index',compact('posts'));


    }

    //create
    public function create()
    {
        # code...
        return view('posts.create');

    }

    //store
    public function store()
    {//dd(request()->all());
        # code...
        $data=request()->validate([
            'another'=>'',
            'caption'=>'required',
            'image'=>['required','image'],
        ]);

        $imagePath=request('image')->store('uploads','public');
        $image=Image::make(public_path('storage/'.$imagePath))->fit(900,900);
        $image->save();
        auth()->user()->posts()->create([
            'caption'=>$data['caption'],
            'image'=>$imagePath,
        ]);

        return redirect('/profile/'.auth()->user()->id);
    }

    //show
    public function show(\App\Post $post){
        //dd($post);
        return view('posts.show',compact('post'));
    }
}
