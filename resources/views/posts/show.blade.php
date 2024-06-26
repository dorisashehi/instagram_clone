@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8">
            <img src="/storage/{{$post->image}}" class='w-100'>
        </div>
        <div class="col-4">
            <div>
                <div class="d-flex align-items-center">
                    <div class="pr-3">
                        <img src="{{ $post->user->profile->profileImage() }}" style="max-width:40px;" class="rounded-circle w-100">
                    </div>
                    @php
                        $same_user = (auth()->user()->id === $post->user->id) ? true : false;
                    @endphp
                    
                    <div>
                        <div class="font-weight-bold">
                            <a href="/profile/{{$post->user->id}}">
                                <span class="text-dark">{{$post->user->username}}</span>
                            </a>
                            @if (!$same_user)
                                <a href="#" class="pl-3">Follow</a>
                            @endif
                        </div>
                    </div>
                </div>
                <hr>
                <p>
                    <span class="font-weight-bold">
                        <a href="/profile/{{$post->user->id}}">
                            <span class="text-dark">{{$post->user->username}}</span>
                        </a>
                    </span> {{$post->caption}}
                </p>
            </div>
        </div>
    </div>

</div>
@endsection
