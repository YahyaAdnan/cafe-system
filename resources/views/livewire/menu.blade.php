<div>
    @php
        $getColor = App\Models\Setting::get('color');

    @endphp
        <!--   section('menu-content')

      <h3 class="friends-title m-4 text-" style="
         font-family: 'NRT Bold';
         font-size: 24px;
         background-color: #146249;
         padding: 10px;
         border-radius: 10px;
         ">{App\Models\Setting::get('Cafe Name') }}</h3>
         endsection
 -->

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
                        <x-icon name="fas.house"
                                class=" h-12 w-12   p-3 -ml-16  -mt-2 rounded-xl   animate__animated animate__fadeInLeft bg-transparent transition-all border-1 border-white text-white  "
                                wire:click="selectLang('')"
                                style="

                                        "/>
                    </div>

                </div>
            @else

                <div class=" z-50  "
                            style="
                        position: fixed;
                        margin-top: -40px;
                        margin-right: 50px;
                        left: 80px;
                        font-size: 20px;
                ">
                    <div class="grid grid-cols-2 gap-0 ">
                        <x-icon name="fas.house"
                                class=" h-12 w-12   p-3 -ml-16  -mt-2 rounded-xl   animate__animated animate__fadeInLeft bg-transparent transition-all border-1 border-white text-white  "
                                wire:click="backHome()"
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

        <img src="{{ asset('storage/' . 'Central-Perk-Logo.png')}}" height="300" width="300" alt="cafe"
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
                background-color:{{$getColor}};
overflow-x: auto;
white-space: nowrap;
"
        >

            @foreach($itemTypes as $itemTypesNav)
                <div class="card-scroll">
                    @if($itemTypesNav->id == $itemType)
                        <x-button
                            class=" p-3 m-4 text-white rounded-lg btn-primary  "
                            wire:click="selectType({{$itemTypesNav->id}})"
                            style="
                      background: rgba(221, 255, 0, 0.45);
border-radius: 10px;
box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
backdrop-filter: blur(10.8px);
-webkit-backdrop-filter: blur(10.8px);
border: 1px solid rgba(221, 255, 0, 1);
">
                            {{$itemTypesNav->$lang}}
                        </x-button>
                    @else
                        <x-button
                            class="bg-emerald-500  p-3 m-4  text-white rounded-lg btn-primary border-white border-1 hover:bg-purple-600  "
                            wire:click="selectType({{$itemTypesNav->id}})"
                            style="
                        background: transparent;
box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
backdrop-filter: blur( 4px );
-webkit-backdrop-filter: blur( 9px );
border-radius: 10px;
border: 1px solid rgba( 255, 255, 255, 0.18 );
">
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
                class=" -mt-9  h-52 flex flex-row items-center transition-all overflow-y-hidden"
                style="
                /* From https://css.glass */

overflow-x: auto;
white-space: nowrap;
"
            >
                @foreach($itemCategories as $itemCategoryNav)
                    <div class="card-scroll p-3 transition-all">
                        @if($itemCategoryNav->id == $itemCategory)
                            <x-card class=" shadow-xl transition-all text-center text-white w-44 "
                                    wire:click="selectCategory({{$itemCategoryNav->id}})"
                                    style="align-items: center; font-size: 15px;
background: {{$getColor}};
box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
backdrop-filter: blur( 9px );
-webkit-backdrop-filter: blur( 9px );
border-radius: 10px;
border: 1px solid rgba( 255, 255, 255, 0.18 );
height: 7rem;
                    ">
                                <x-slot name="figure" class="">
                                    <img class="rounded-xl shadow-lg border-transparent border-1 h-16 -mt-4 w-24"
                                         src="{{ asset('storage/' . $itemCategoryNav->image) }}"
                                         alt="{{ $itemCategoryNav->$lang }}" width="150" height="150"
                                         style="opacity: 1 "
                                    />
                                </x-slot>
                                <p class="font-bold">{{ $itemCategoryNav->$lang }}</p>

                            </x-card>

                            <!-- { asset('storage/' . $itemCategoryNav->image) }} -->


                            <div class=" transition-all mt-3"></div>
                        @else
                            <x-card class=" shadow-xl transition-all text-center text-white w-44 "
                                    wire:click="selectCategory({{$itemCategoryNav->id}})"
                                    style="align-items: center; font-size: 15px;
                                        background: transparent;
                                        box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
                                        backdrop-filter: blur( 4px );
                                        -webkit-backdrop-filter: blur( 9px );
                                        border-radius: 10px;
                                        border: 1px solid rgba( 255, 255, 255, 0.18 );
                                        height: 7rem;
                                        ">
                                <x-slot name="figure" class="">
                                    <img class="rounded-xl shadow-lg border-transparent border-1 h-16 -mt-4 w-24"
                                        src="{{ asset('storage/' . $itemCategoryNav->image) }}"
                                         alt="{{ $itemCategoryNav->$lang }}" width="150" height="150"
                                         style="opacity: 1 "
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
        <div class=" m-2 mt-10 grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-2 md:gap-5 mb-5">

            @foreach ($items as $item)

                <style>


                    /* Rest of your CSS styles */
                    .card-c {
                        background: transparent;
                        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
                        backdrop-filter: blur(5px);
                        -webkit-backdrop-filter: blur(9px);
                        border-radius: 10px;
                        border: 1px solid rgba(255, 255, 255, 0.18);
                        color: white;
                    }
                </style>
                <div class="">
                    <x-card style="
                    padding: 25px !important;
                    overflow-y: hidden;
                    height: 450px;

}"
                            class="card-c mt-3 shadow-xl justify-center  w-full h-48 md:w-80 overflow-x-hidden "
                            wire:click="showModal({{$item->id}})">
                        <div class="-mt-5">
                            @php
                                $itemVal = App\Models\Item::find($item->id);
                                    $isAvailable = $itemVal->available();
                            @endphp
                                <!-- { asset('storage/' . $item->image) }} -->
                            @if(!$isAvailable && $lang == 'title')

                                <img
                                    src="{{ asset('storage/' . $item->image) }}"
                                    class="rounded-xl "
                                    style="height:150px;
                                    filter: blur(2px) saturate(99%) opacity(77%);
-webkit-filter: blur(2px) saturate(99%) opacity(77%);
-moz-filter: blur(2px) saturate(99%) opacity(77%);
"
                                >
                                <p class="font-bold mt-2 mb-2">{{$item->$lang}}</p>
                                <p class="absolute top-2 " style="left: 28%; top: 25%;
                                    background: transparent;
                        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
                        backdrop-filter: blur(5px);
                        -webkit-backdrop-filter: blur(9px);
                        border-radius: 10px;
                        border: 1px solid rgba(255, 255, 255, 0.18);
                        color: white;
                        font-weight: bold; font-size: 20px; padding: 10px;
                        ">Not Available</p>
                            @elseif(!$isAvailable && $lang == 'title_ku')
                                <img
                                    src="{{ asset('storage/' . $item->image) }}"
                                    class="rounded-xl "
                                    style="height:150px;
                                    filter: blur(2px) saturate(99%) opacity(77%);
-webkit-filter: blur(2px) saturate(99%) opacity(77%);
-moz-filter: blur(2px) saturate(99%) opacity(77%);
"
                                >
                                <p class="font-bold mt-2 mb-2">{{$item->$lang}}</p>
                                <p class="absolute top-2 " style="left: 28%; top: 25%;
                                    background: transparent;
                        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
                        backdrop-filter: blur(5px);
                        -webkit-backdrop-filter: blur(9px);
                        border-radius: 10px;
                        border: 1px solid rgba(255, 255, 255, 0.18);
                        color: white;
                        font-weight: bold; font-size: 20px; padding: 10px;
                        ">.بەردەست نییە</p>
                            @elseif(!$isAvailable && $lang == 'title_ar')
                                <img
                                    src="https://central-perk-erbil.qodology.com/storage/01HPVR1HZSBBRMRZMTTQYP9EA2.jpg"
                                    class="rounded-xl "
                                    style="height:150px;
                                    filter: blur(2px) saturate(99%) opacity(77%);
-webkit-filter: blur(2px) saturate(99%) opacity(77%);
-moz-filter: blur(2px) saturate(99%) opacity(77%);
"
                                >
                                <p class="font-bold mt-2 mb-2">{{$item->$lang}}</p>
                                <p class="absolute top-2 " style="left: 35%; top: 26%;
                                    background: transparent;
                        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
                        backdrop-filter: blur(5px);
                        -webkit-backdrop-filter: blur(9px);
                        border-radius: 10px;
                        border: 1px solid rgba(255, 255, 255, 0.18);
                        color: white;
                        font-weight: bold; font-size: 20px; padding: 10px;
                        ">غير متاح</p>
                            @else
                                <img
                                    src="{{ asset('storage/' . $item->image) }}"
                                    class="rounded-xl "
                                    style="height:150px">
                                <p class="font-bold mt-2 mb-2">{{$item->$lang}}</p>
                            @endif
                        </div>


                        <hr class="relative mb-3">
                        <div>


                            <p class="font-bold text-white text-center p-1 rounded-xl"
                            >

                            @foreach ($item->prices as $key => $price)

                                <p class="font-bold">{{$price->title}}: {{number_format($price->amount)}} IQD<p>
                                    @endforeach
                                </p>

                                @if ($item->show_ingredients)
                                @if(count($item->itemIngredients) > 1)
                                    <div class="font-bold text-white text-center p-1 rounded-xl" dir={{$lang == "title" ? "ltr" : "rtl"}}>
                                        @foreach ($item->itemIngredients as $key => $itemIngredient)
                                            @php $ingredient = $itemIngredient->ingredient @endphp
                                            @if(!$ingredient->is_available)
                                                <span class="mt-2"><del>{{$ingredient->$lang}}</del></span>
                                            @endif
                                            @if($ingredient->is_available)
                                                <span>{{$ingredient->$lang}}</span>
                                            @endif
                                            @if(!$loop->last),@endif
                                        @endforeach
                                        .
                                    </div>
                                @endif
                            @endif                            
                        </div>

                        <style>
                            .rounded-image {
                                border-radius: 45px;

                            }

                            .item-container {
                                max-height: 200px; /* Adjust this value based on your needs */
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
