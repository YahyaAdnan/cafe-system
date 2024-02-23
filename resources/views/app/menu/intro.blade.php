@extends('layouts/app')

@section('title', 'Menu')

@section('content')
@php
    $socialMedias = App\Models\SocialMedia::where('show', 1)->get()->sortBy('order');
    $settings = App\Models\Setting::all();
@endphp
<center>
<div class="row">
    <div class="col">
            <div
                class="row justify-content-center align-items-center col-6 mt-3"
            >
                <h1 class="friends-title">{{App\Models\Setting::get('Cafe Name')}}</h1>
            </div>
            <div
                class="row justify-content-center align-items-center col-6 mt-3"
            >
                <h4 class="friends-text">{{App\Models\Setting::get('description')}}</h4>
            </div>
            @foreach ($socialMedias as $socialMedia)                
                <div
                    class="row justify-content-center align-items-center col-6 mt-3"
                >
                    <a href="{{$socialMedia->url}}" target="_blank" class="btn btn-light btn-lg rounded-pill d-flex align-items-center">
                        <img src="{{ asset('storage/' . $socialMedia->image) }}" alt="Image" class="me-2" style="max-height: 2rem; border-radius: 50%;">
                        <span class="flex-grow-1 text-center">
                            {{$socialMedia->title}}
                        </span>
                    </a>                                              
                </div>
            @endforeach
        </div>
    </div>
</div>
</center>
@endsection

{{-- @foreach (App\Models\SocialMedia::where('show', 1)->get() as $socialMedia)
<div
    class="row justify-content-center align-items-center g-2"
>
    <div class="col-12">
        <div class="container mt-5">
            <a href="{{$socialMedia->url}}" class="btn btn-success btn-lg rounded">
                Click Me
            </a>
        </div>      
    </div>
</div>    
@endforeach --}}