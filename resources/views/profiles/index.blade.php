@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 p-5">
           <img style="width: 150px;height:150px;" class="rounded-circle" src="{{$user->profile->profileImage() }}" alt="">
        </div>
        <div class="col-9 pt-5">
        <div class="d-flex justify-content-between align-items-baseline">
            <div class="d-flex align-items-center pb-3">
                <div class="h4">{{$user->username}}</div>
            @if (!$same_user)
                <follow-button user-id="{{ $user->id }}" follows="{{ $follows }}"></follow-button>
            @endif
           
            </div>
            @can('update', $user->profile)
                <a href="/p/create">Add New Post</a>
            @endcan
        </div>
           <!--
            we use :can for allowing only authorized users to edit.
            The authorizes is related to policy rule we have put.
            -->
           @can('update', $user->profile)
                <a href="/profile/{{$user->id}}/edit">Edit profile link</a>
           @endcan
           <div class="d-flex">
                <div class="pr-5"><strong>{{ $postCount }}</strong> posts</div>
                <div class="pr-5"><strong>{{ $followersCount }}</strong> followers</div>
                <div class="pr-5"><strong>{{ $followingCount }}</strong> following</div>
           </div>

        <div class="pt-4 font-weight-bold">{{$user->profile->title }}</div>
        <div>{{$user->profile->description}}</div>
        <div><a href="#" >{{$user->profile->url ?? 'N/A'}}</a></div>
        </div>
    </div>


    <div class="row pt-5">
        @foreach ($user->posts as $post)
            <div class="col-4 pb-4">
            <a href="/p/{{$post->id}}">
                    <img  class="v-100" style="width:100%" src="/storage/{{$post->image}}">
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
