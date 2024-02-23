<div>
    <div class="row justify-content-between align-items-start mt-3">
        <div class="col">
            @if($lang != '')
            <a class="btn btn btn-outline-light m-0" wire:click="selectLang('')">
                <i class="fa fa-home"></i>
            </a>
            @endif
        </div>
        <div class="col">
            <h1 class="friends-title">{{ App\Models\Setting::get('Cafe Name') }}</h1>
        </div>
        <div class="col">
        </div>
    </div>    
    <div
        class="row justify-content-center align-items-center col-6 mt-3"
    >
        <h4 class="friends-text">{{App\Models\Setting::get('description')}}</h4>
    </div>
    @if($lang == "")
        @foreach ($langs as $value => $lang)
            <div class="row justify-content-center align-items-center col-6 mt-5">
                <button class="btn btn-light btn-lg rounded-pill d-flex align-items-center" wire:click="selectLang('{{$value}}')">
                    <span class="flex-grow-1 text-center">
                        {{$lang}}
                    </span>
                </button>                                              
            </div>
        @endforeach
    @else
    {{-- CHOOSE TYPE --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="overflow-auto">
                    <nav class="navbar navbar-expand-lg">
                        <div class="container-fluid">
                            <div class="navbar-nav flex-row">
                                @foreach($itemTypes as $itemTypesNav)
                                    <a class="nav-link px-2" wire:click="selectType({{$itemTypesNav->id}})">
                                        <div class="text-center">
                                            <div class="d-flex flex-column align-items-center">
                                                <img src="{{ asset('storage/' . $itemTypesNav->image) }}" 
                                                    class="rounded-circle mt-2" 
                                                    style="opacity: {{ $itemTypesNav->id != $itemType ? '0.5' : '1' }};"
                                                    alt="{{ $itemTypesNav->$lang }}" width="200" height="200">
                                                @if($itemTypesNav->id == $itemType)
                                                    <p class="btn btn-outline-light mt-2">{{ $itemTypesNav->$lang }}</p>
                                                @else
                                                    <p class="text-light">{{ $itemTypesNav->$lang }}</p> 
                                                @endif 
                                            </div>
                                        </div>
                                    </a>
                                @endforeach                            
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>  
    {{-- /CHOOSE TYPE --}}

    {{-- CHOOSE Category --}}
    @if($itemCategories->count() > 1)
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="overflow-auto">
                    <nav class="navbar navbar-expand-lg">
                        <div class="container-fluid">
                            <div class="navbar-nav flex-row">
                                @foreach($itemCategories as $itemCategoryNav)
                                    <a class="nav-link px-2" wire:click="selectCategory({{$itemCategoryNav->id}})">
                                        <div class="text-center">
                                            <div class="d-flex flex-column align-items-center">
                                                <img src="{{ asset('storage/' . $itemCategoryNav->image) }}" 
                                                    class="rounded-circle mt-2"
                                                    style="opacity: {{ $itemCategoryNav->id != $itemCategory ? '0.5' : '1' }};"
                                                    alt="{{ $itemCategoryNav->$lang }}" width="150" height="150">
                                                @if($itemCategoryNav->id == $itemCategory)
                                                    <p class="btn btn-outline-light mt-1">{{ $itemCategoryNav->$lang }}</p>
                                                @else
                                                    <p class="text-light">{{ $itemCategoryNav->$lang }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>        
    @endif
    {{-- /CHOOSE Category --}}
    {{-- Item --}}
    @foreach ($items as $item)
    <div class="card mt-2 mb-1" style="max-width: 540px; background-color: rgba(255, 255, 255, 0.5);">
        <div class="row g-0">
          <div class="col-md-4">
            <img src="{{ asset('storage/' . $item->image) }}"
            style="opacity: {{ !$item->available() ? '0.5' : '1' }};"
            class="img-fluid rounded-start">
          </div>
          <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title">{{$item->$lang}}</h5>
                @foreach ($item->prices as $price)
                    <p>@if($item->prices->count() > 1) {{$price->title}}: @endif {{number_format($price->amount)}} IQD</p>
                @endforeach
                @if ($item->show_ingredients)
                    @foreach ($item->itemIngredients as $itemIngredient)
                        @php $ingredient = $itemIngredient->ingredient @endphp
                        @if(!$ingredient->is_available) <span><del>{{$ingredient->$lang}}</del></span> @endif
                        @if($ingredient->is_available){{$ingredient->$lang}}@endif
                        @if ($loop->last). @else, @endif
                    @endforeach
                @endif
            </div>
          </div>
        </div>
      </div>
    @endforeach
    {{-- Item --}}
    @endif
</div>
