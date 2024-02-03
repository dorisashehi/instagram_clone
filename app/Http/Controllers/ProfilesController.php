<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\User;

class ProfilesController extends Controller
{
    //

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($user)
    {
        $user=User::findOrFail($user);
        $follows=(auth()->user()) ? auth()->user()->following->contains($user->id) : false;
        $same_user = (auth()->user()->id === $user->id) ? true : false;
    
       $postCount=Cache::remember(
           'count.posts.'.$user->id,
           now()->addseconds(30),
           function() use($user){

                return $user->posts->count();
            }
        );
       $followersCount=Cache::remember(
            'count.followers.'.$user->id,
            now()->addseconds(30),
            function() use($user){

                return  $user->profile->followers->count();
            }
        );

       $followingCount=Cache::remember(
            'count.following.'.$user->id,
            now()->addseconds(30),
            function() use($user){
                return  $user->following->count();
            }
       );

        return view('profiles.index',compact('user','follows','postCount','followersCount','followingCount','same_user'));
    }

    public function edit(\App\User $user)
    {

        $this->authorize('update',$user->profile);

        return view('profiles.edit',compact('user'));
    }

    public function update(\App\User $user)
    {
        $this->authorize('update',$user->profile);

        $data=request()->validate([
            'title'=>'required',
            'description'=>'required',
            'url'=>'url',
            'image'=>'',
        ]);


        if(request('image')){
            $imagePath=request('image')->store('profile','public');
            $image=Image::make(public_path('storage/'.$imagePath));
            $image->save();
            $imageArray=['image'=>$image->basename];
        }

        auth()->user()->profile->update(array_merge(
            $data,
            $imageArray ?? []
        ));


        return redirect("/profile/{$user->id}");
    }
}
