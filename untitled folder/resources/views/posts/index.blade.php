@extends('layouts.app')

@section('content')
  <h1>Posts</h1>

  @if(count($posts)>0)
    @foreach ($posts as $post)
      <div class="card card-body bg-light">
        <div class="col-md-4 col-sm-4">


        <img style="width:100%" src="/storage/{{$post->cover_image}}">
        </div>
        <div class="col-md-8 col-sm-8">
            <h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
            <small>written {{$post->created_at}} by user {{$post->user->name}}</small>
        </div>
      </div>
      </br>
    @endforeach
    {{$posts->links()}}
  @else
     <p>No posts found</p>
  @endif
@endsection
