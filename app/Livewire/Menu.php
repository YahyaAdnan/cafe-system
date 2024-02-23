<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Item;
use App\Models\ItemType;
use App\Models\ItemCategory;

class Menu extends Component
{
    public $lang = "";
    public $langs;
    public $items;
    public $itemTypes;
    public $itemCategories;

    public $itemType;
    public $itemCategory;

    public function mount()
    {
        $this->itemTypes = ItemType::whereIn('id', Item::pluck('item_type_id'))->get();
        $this->langs = array(
            'title' => "English",
            'title_ku' => "كردي",
            'title_ar' => "عربي",
        );
        $this->selectType($this->itemTypes->first()->id);
    }


    public function selectType($type)
    {
        if($type == $this->itemType)
        {
            return;
        }

        $this->itemType = $type;

        $this->itemCategories = ItemCategory::where('item_type_id', $type)
            ->whereIn('id', Item::pluck('item_category_id'))->get();
        
        $this->selectCategory($this->itemCategories->first()->id);
    }

    public function selectCategory($category)
    {
        if($category == $this->itemCategory)
        {
            return;
        }

        $this->itemCategory = $category;
        $this->items = Item::where('item_category_id', $category)
            ->where('show', 1)->get();
    }

    public function selectLang($lang)
    {
        $this->lang = $lang;
    }

    public function render()
    {
        return view('livewire.menu');
    }
}