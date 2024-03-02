@extends('layouts/app')

@section('title', 'Intro')

@section('content')
    @php
        $socialMedias = App\Models\SocialMedia::where('show', 1)->get()->sortBy('order');
        $settings = App\Models\Setting::all();
          $getColor = App\Models\Setting::get('color');
    @endphp
    <center>


        <!-- <div
            class="row justify-content-center align-items-center col-6 mt-3"
        >
          <h4 class="friends-text">{App\Models\Setting::get('description')}}</h4>
        </div> -->


        <img src="{{@asset('friends-stuff/logo-text.png')}}" height="300" width="300"
             class="absolute m-5  rounded-xl p-3 bottom-0 right-0" style="background-color: {{  $getColor}}">

        <div
            class="flex flex-col  rounded-2xl w-10/12 md:w-96   mt-24 animate__animated animate__backInUp"
            style="

background:{{$getColor}};
box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
backdrop-filter: blur( 8.5px );
-webkit-backdrop-filter: blur( 8.5px );
border-radius: 10px;
border: 1px solid rgba( 255, 255, 255, 0.18 );
">
            <div class="flex flex-col p-8  animate__animated " style="margin:10px !important;">

                @foreach ($socialMedias as $socialMedia)
                    <div class="row justify-content-center align-items-center col-6 mt-5" style="width: 100%;">
                        <a style="  background-color: rgba(255, 255, 255, 0.125);" href="{{$socialMedia->url}}"
                           target="_blank"
                           class="btn btn-light btn-lg rounded-pill d-flex align-items-center bg-blue-950 text-white">
                            <img src="{{ asset('storage/' . $socialMedia->image) }}" alt="Image" class="me-2"
                                 style="max-height: 2rem; border-radius: 50%;">
                            <span class="flex-grow-1 text-center">
                            {{$socialMedia->title}}
                        </span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <div style="background-color:{{$getColor}};
            display: flex;
            align-items: flex-end;
            justify-content: flex-start;
            position: fixed;
            bottom: 0;
            left: 0;
            padding: 1rem;
            width: 100%;
            max-width: 11rem;
            "
             class="">

            <x-icon name="fab.facebook" class="w-6 h-6" style="color: #d7af4e; margin-right: 1rem;"/>
            <x-icon name="fab.twitter" class="w-6 h-6" style="color: #d7af4e; margin-right: 1rem;"/>
            <x-icon name="fab.instagram" class="w-6 h-6" style="color: #d7af4e; margin-right: 1rem;"/>

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
