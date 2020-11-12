<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

//Perdorim modelin e krijuar
use App\Post;

//perdorim klasen DB per query
use DB;

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Marrim te gjitha postet nga db me all()
        //$posts=Post::all();
        //return Post::where('title','Post Tow')->get();
        //me query perdorim klasen DB
        //$posts=DB::select('SELECT * FROM posts');
        //$posts=Post::orderBy('title','desc')->take(1)->get(); //me limitu numrin e posteve

        //$posts=Post::orderBy('title','desc')->get();
        $posts=Post::orderBy('created_at','desc')->paginate(10); //me pagination

        return view('posts.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'title'=>'required',
            'body'=>'required',
            'cover_image'=>'image|nullable|max:1999'
        ]);

        if($request->hasFile('cover_image')){
            //Get filename with the extension
            $filenameWithExt=$request->file('cover_image')->getClientOriginalName();
            //get just filename
            $filename=pathinfo($filenameWithExt,PATHINFO_FILENAME);
            //GET just ext
            $extension=$request->file('cover_image')->getClientOriginalExtension();
            //filename to store
            $fileNameToStore=$filename.'_'.time().'.'.$extension;
            //Upload Image
            $path=$request->file('cover_image')->storeAs('images',$fileNameToStore);

        }
        else
        {
            $fileNameToStore='noimage.jpg';
        }

        $post=new Post;
        $post->title=$request->input('title');
        $post->body=$request->input('body');
        $post->user_id=auth()->user()->id;
        $post->cover_image=$fileNameToStore;
        $post->save();

        return redirect('/posts')->with('success','Post created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //merr id e postit nga url dhe e kerkon ate me find()
        $post=Post::find($id);
        return view('posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post=Post::find($id);
        //
        if(auth()->user()->id!==$post->user_id){
            return redirect('/posts')->with('error','Unauthorized Page');
        }
        return view('posts.edit')->with('post',$post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request,[
            'title'=>'required',
            'body'=>'required'
        ]);

        if($request->hasFile('cover_image')){
            //Get filename with the extension
            $filenameWithExt=$request->file('cover_image')->getClientOriginalName();
            //get just filename
            $filename=pathinfo($filenameWithExt,PATHINFO_FILENAME);
            //GET just ext
            $extension=$request->file('cover_image')->getClientOriginalExtension();
            //filename to store
            $fileNameToStore=$filename.'_'.time().'.'.$extension;
            //Upload Image
            $path=$request->file('cover_image')->storeAs('images',$fileNameToStore);

        }


        $post=Post::find($id);
        $post->title=$request->input('title');
        $post->body=$request->input('body');
        if($request->hasFile('cover_image')){
           $post->cover_image=$fileNameToStore;
        }
        $post->save();

        return redirect('/posts')->with('success','Post updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post=Post::find($id);
        if(auth()->user()->id!==$post->user_id){
            return redirect('/posts')->with('error','Unauthorized Page');
        }

        if($post->cover_image!='noimage.jpg'){
            Storage::delete('public/cover_image/'.$post->cover_image);

        }

        $post->delete();
        return redirect('/posts')->with('success','Post removed');
    }
}
