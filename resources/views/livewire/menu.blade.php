<div>

    @section('menu-content')

        <img src="{{asset('friends-stuff/cafe-logo.jpg')}}" style="margin: 5px;" class="h-16 rounded-lg shadow-xl ">
        <h3 class="friends-title m-4 text-" style="
        font-family: 'NRT Bold';
        font-size: 24px;
        background-color: #146249;
        padding: 10px;
        border-radius: 10px;
        ">{{App\Models\Setting::get('Cafe Name') }}</h3>

    @endsection
    <div class="row justify-content-between align-items-start mt-3">
        <div class="col">
            @if($lang != '')

                <div class=" z-50  "
                     style="
                    position: fixed;
                    margin-top: -40px;
                    margin-right: 50px;
                    left: 80px;
                    font-size: 20px;
            ">
                    <div class="grid grid-cols-2 gap-0 ">
                        <div class="w-1 rounded-lg h-10 inline-block bg-white "></div>
                        <x-icon name="fas.house"
                                class=" h-12 w-12   p-3 -ml-5 mr-3 -mt-2 rounded-xl   animate__animated animate__fadeInLeft bg-transparent transition-all border-1 border-white text-white  "
                                wire:click="selectLang('')"
                                style="

                                        "/>
                    </div>

                </div>

            @endif

        </div>

        <div class="col">
        </div>
    </div>
    <div
        class="row justify-content-center align-items-center col-6 mt-3"
    >
        <!-- <h4 class="friends-text">{App\Models\Setting::get('description')}}</h4> -->
    </div>


    @if($lang == "")

        <img src="{{@asset('friends-stuff/logo-text.png')}}" height="300" width="300"
             class="absolute m-5  rounded-xl p-3 bottom-0 right-0" style="background-color: #8f6fbd">


        <div
            class="flex flex-col  rounded-2xl w-10/12 md:w-96   mt-24 animate__animated animate__backInUp"
            style="

background: rgba( 143, 111, 189, 0.75 );
box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
backdrop-filter: blur( 8.5px );
-webkit-backdrop-filter: blur( 8.5px );
border-radius: 10px;
border: 1px solid rgba( 255, 255, 255, 0.18 );
">
            <div class="flex flex-col p-8  animate__animated " style="margin:10px !important;">
                <div
                    class="text-2xl font-bold  text-center text-[#374151] pb-6 text-white">@lang('Choose a Language')</div>
                @foreach ($langs as $value => $lang)
                    <div class="row justify-content-center align-items-center col-6 mt-5" style="width: 100%;">
                        <button style="  background-color: rgba(255, 255, 255, 0.125);"
                                class="btn btn-light btn-lg rounded-pill d-flex align-items-center bg-blue-950 text-white"
                                wire:click="selectLang('{{$value}}')" wire:model="selectedLang">
                    <span class="flex-grow-1 text-center">
                        {{$lang}}
                    </span>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
        <div style="background-color: #8f6fbd;
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
    @else
        {{-- arrow --}}
        <a href="#top">
            <div class="fixed z-50 bottom-0 right-0 m-3 ">
                <x-icon name="fas.arrow-up"
                        class=" h-16 w-16   p-3 -ml-5 rounded-xl   animate__animated animate__fadeInUp bg-transparent transition-all border-1 border-white text-white  "

                        style="
   background: rgba(189, 16, 224, 0.11);
                        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
                        backdrop-filter: blur(9px);
                        -webkit-backdrop-filter: blur(9px);
                        border-radius: 10px;
                        border: 1px solid rgba(255, 255, 255, 0.18);
                        color: white;
                                        "/>
            </div>
        </a>
        {{-- CHOOSE TYPE --}}

        <div
            class=" w-full h-full flex flex-row items-center   overflow-y-hidden "
            style="
                background-color: #8f6fbd;
overflow-x: auto;
white-space: nowrap;
"
        >

            @foreach($itemTypes as $itemTypesNav)
                <div class="card-scroll">
                    @if($itemTypesNav->id == $itemType)
                        <x-button
                            class=" p-3 m-4 text-white bg-purple-600 rounded-lg btn-primary border-white border-1 hover:bg-emerald-500 "
                            wire:click="selectType({{$itemTypesNav->id}})">
                            {{$itemTypesNav->$lang}}
                        </x-button>
                    @else
                        <x-button
                            class="bg-emerald-500  p-3 m-4  text-white rounded-lg btn-primary border-white border-1 hover:bg-purple-600  "
                            wire:click="selectType({{$itemTypesNav->id}})">
                            {{$itemTypesNav->$lang}}
                        </x-button>
                    @endif
                </div>
            @endforeach
        </div>
        {{-- /CHOOSE TYPE --}}

        {{-- CHOOSE Category --}}
        @if($itemCategories->count() > 1)
            <div
                class=" m-2  h-52 flex flex-row items-center mt-8 transition-all overflow-y-hidden"
                style="
                /* From https://css.glass */
background: rgba(189, 111, 184, 0.85);
border-radius: 16px;
box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
backdrop-filter: blur(12.6px);
-webkit-backdrop-filter: blur(12.6px);
border: 1px solid rgba(189, 111, 184, 1);
overflow-x: auto;
white-space: nowrap;
"
            >
                @foreach($itemCategories as $itemCategoryNav)
                    <div class="card-scroll transition-all">
                        @if($itemCategoryNav->id == $itemCategory)
                            <x-card class="m-2 shadow-xl transition-all text-center text-white w-52 "
                                    wire:click="selectCategory({{$itemCategoryNav->id}})"
                                    style="align-items: center; font-size: 15px;
background: rgba(16, 224, 78, 0.4);
box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
backdrop-filter: blur( 9px );
-webkit-backdrop-filter: blur( 9px );
border-radius: 10px;
border: 1px solid rgba( 255, 255, 255, 0.18 );
height: 9.3rem;
                    ">
                                <x-slot name="figure">
                                    <img class="rounded-xl shadow-lg border-transparent border-1 h-20"
                                         src="https://central-perk-erbil.qodology.com/storage/01HPVR1HZSBBRMRZMTTQYP9EA2.jpg"
                                         alt="{{ $itemCategoryNav->$lang }}" width="150" height="150"
                                         style="opacity: 1 "
                                    />
                                </x-slot>
                                <p class="font-bold">{{ $itemCategoryNav->$lang }}</p>

                            </x-card>

                            <!-- { asset('storage/' . $itemCategoryNav->image) }} -->


                            <div class=" transition-all mt-3"></div>
                        @else
                            <x-card class="m-2 shadow-xl transition-all text-center text-white w-52 "
                                    wire:click="selectCategory({{$itemCategoryNav->id}})"
                                    style="align-items: center; font-size: 15px;
background:rgba(189, 111, 184, 0.85);
box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
backdrop-filter: blur( 9px );
-webkit-backdrop-filter: blur( 9px );
border-radius: 10px;
border: 1px solid rgb(196, 153, 193);
height: 9.3rem;
                    ">
                                <x-slot name="figure">
                                    <img class="rounded-xl shadow-lg border-transparent border-1 "
                                         src="https://central-perk-erbil.qodology.com/storage/01HPVR1HZSBBRMRZMTTQYP9EA2.jpg"
                                         alt="{{ $itemCategoryNav->$lang }}" width="150" height="150"
                                         style="opacity: 0.5;  "
                                    />
                                </x-slot>
                                <p class="font-bold">{{ $itemCategoryNav->$lang }}</p>
                            </x-card>

                            <!-- { asset('storage/' . $itemCategoryNav->image) }} -->


                            <div class=" transition-all mt-1"></div>
                        @endif
                    </div>
                @endforeach
            </div>

        @endif
        {{-- /CHOOSE Category --}}
        {{-- Item --}}
        <div class=" m-2 mt-10 grid lg:grid-cols-4 md:grid-cols-3 grid-cols-1 gap-2 md:gap-5 mb-5">

            @foreach ($items as $item)

                <style>
                    /* Define the animation */
                    @keyframes animatedBackground {
                        0% {
                            background-position: 0% 0%, 0% 0%;
                        }
                        50% {
                            background-position: 100% 100%, 0% 0%;
                        }
                        100% {
                            background-position: 0% 0%, 100% 100%;
                        }
                    }

                    /* Apply the animation to the element */
                    .animated-card {
                        animation: animatedBackground 10s infinite;
                    }

                    /* Rest of your CSS styles */
                    .card-c {
                        background: rgba(189, 16, 224, 0.11);
                        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
                        backdrop-filter: blur(9px);
                        -webkit-backdrop-filter: blur(9px);
                        border-radius: 10px;
                        border: 1px solid rgba(255, 255, 255, 0.18);
                        color: white;
                    }
                </style>
                <div class="">
                    <x-card style="padding: 10px !important;"
                            class="card-c overflow-y-scroll shadow-xl justify-center  w-full h-48 md:w-80 overflow-x-hidden "
                            wire:click="showModal({{$item->id}})">
                        <x-slot:figure>

                            <!-- { asset('storage/' . $item->image) }} -->
                            <img src="https://central-perk-erbil.qodology.com/storage/01HPVR1HZSBBRMRZMTTQYP9EA2.jpg"
                                 class="rounded-xl mt-20 h-20 border-2 border-dotted border-white">
                            <p class="font-bold">{{$item->$lang}}</p>
                        </x-slot:figure>
                        <hr class="relative mb-1">
                        <div>


                            <p class="mb-2 font-bold text-white text-left flex flex-wrap p-1 rounded-xl shadow-xl border-solid border-1 border-white">
                                <x-heroicon-o-currency-dollar class="w-6 h-6 mr-1"/>
                                @foreach ($item->prices as $key => $price)
                                    @if($key === 0)
                                        {{$price->title}}: {{number_format($price->amount)}} IQD
                                    @else
                                        <span
                                            class="">,More...</span>
                                        @break
                                    @endif

                                @endforeach
                            </p>

                            @if ($item->show_ingredients)
                                @if(count($item->itemIngredients) > 1)
                                    <div
                                        class=" font-bold text-white text-left flex flex-wrap   p-1  rounded-xl shadow-xl border-solid border-1  border-white">
                                        <x-heroicon-o-beaker class="w-6 h-6 mr-1"/>

                                        @foreach ($item->itemIngredients as $key => $itemIngredient)
                                            @php $ingredient = $itemIngredient->ingredient @endphp
                                            @if(!$ingredient->is_available)
                                                <span><del>{{$ingredient->$lang}}</del></span>
                                            @endif
                                            @if($ingredient->is_available)
                                                <span>{{$ingredient->$lang}}</span>
                                            @endif

                                        @endforeach

                                    </div>
                                @endif
                            @endif

                        </div>

                        <style>
                            .rounded-image {
                                border-radius: 45px;

                            }

                            .item-container {
                                max-height: 100px; /* Adjust this value based on your needs */
                                overflow-y: auto;
                            }

                            .ing-container {
                                max-height: 30px; /* Adjust this value based on your needs */
                                overflow-y: auto;
                            }

                            /* Define the animation */
                            @keyframes animatedBackground {
                                0% {
                                    background-position: 0% 0%, 0% 0%;
                                }
                                50% {
                                    background-position: 100% 100%, 0% 0%;
                                }
                                100% {
                                    background-position: 0% 0%, 100% 100%;
                                }
                            }

                            /* Apply the animation to the button */
                            .animated-button {
                                animation: animatedBackground 10s infinite;
                            }
                        </style>

                    </x-card>

                </div>

            @endforeach
        </div>

        {{-- Item --}}
    @endif
</div>
