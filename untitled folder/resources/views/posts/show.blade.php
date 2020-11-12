@extends('layouts.app')

@section('content')
   <br>
   <a href="/posts" class="btn btn-outline-secondary">Go Back</a>
   <h1>{{$post->title}}</h1>
   <img style="width:100%" src="/storage/{{$post->cover_image}}">

   <div>
       {{$post->body}}
   </div>
   <hr>
   <small>Written on {{$post->created_at}} by user {{$post->user->name}}</small>
   <br>


    @if (!Auth::guest())
       @if (Auth::user()->id==$post->user_id)
        <a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a>
        {!!Form::open(['action'=>['PostsController@destroy',$post->id],'method'=>'POST','class'=>'float-right'])!!}
            {{Form::hidden('_method','DELETE')}}
            {{Form::submit('Delete',['class'=>'btn btn-danger'])}}
        {!!Form::close()!!}
       @endif
    @endif
@endsection
