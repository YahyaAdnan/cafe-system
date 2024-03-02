<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\ItemIngredient;
use App\Models\ItemType;
use App\Models\Setting;
use App\Models\Price;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Menu extends Component
{

    use LivewireAlert;

    public bool $myModal = false;
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
            'title_ku' => "كوردی",
            'title_ar' => "عربي",
        );

        $this->selectType($this->itemTypes->first()->id);
    }

    public function selectType($type)
    {
        if ($type == $this->itemType) {
            return;
        }

        $this->itemType = $type;

        $this->itemCategories = ItemCategory::where('item_type_id', $type)
            ->whereIn('id', Item::pluck('item_category_id'))->get();

        $this->selectCategory($this->itemCategories->first()->id);
    }

    public function selectCategory($category)
    {
        if ($category == $this->itemCategory) {
            return;
        }

        $this->itemCategory = $category;
        $this->items = Item::where('item_category_id', $category)
            ->where('show', 1)->get();
    }

    public function showModal($id)
    {
        $item = Item::find($id);
        $lang = $this->lang;
        $title = $item->$lang;

        $ingredients = ItemIngredient::where('item_id', $id)->get();
        $ingredientNames = $ingredients->map(function ($itemIngredient) {
            return $itemIngredient->ingredient->title;
        })->implode(', ');

        $prices = Price::where('item_id', $id)->get();
        $priceAmounts = $prices->map(function ($price) {
            return $price->title . ": " . $price->amount;
        })->implode("IQD </br>");


        $this->alert('', "", [
            'position' => 'center',
            'timer' => '',
            'toast' => false,
            'timerProgressBar' => true,
            'width' => '300',
            'customClass' => [
                'popup' => "bg-[".Setting::get('Color')."]",
            ],            
            'html' => $ingredientNames ? "<div class='flex flex-col justify-center content-center items-center'><img src='https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fimages.pexels.com%2Fphotos%2F1633578%2Fpexels-photo-1633578.jpeg%3Fcs%3Dsrgb%26dl%3Dbeef-bread-buns-1633578.jpg%26fm%3Djpg&f=1&nofb=1&ipt=911e8a06b39ecaf8c6bb3bfc9b18b1cbb7ca4960d9550678ed6e33e0ed59469b&ipo=images' width='200' height='200' style='border-radius: 20px' class='shadow-xl mb-3 '> </br> <p class='mb-3 text-white text-lg font-bold'>$title</p> </div> <style>hr{background-color: black}</style><div style='padding: 3px; border-radius: 10px; color:white; font-weight: bold'>" . __("Ingredients: ") . $ingredientNames . ".</div> </br> <hr> </br> <div style='padding: 3px; border-radius: 10px; color:white; font-weight: bold'> " . $priceAmounts . " IQD </div>" : "</br><div class='flex flex-col justify-center content-center items-center'><img src='https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fimages.pexels.com%2Fphotos%2F1633578%2Fpexels-photo-1633578.jpeg%3Fcs%3Dsrgb%26dl%3Dbeef-bread-buns-1633578.jpg%26fm%3Djpg&f=1&nofb=1&ipt=911e8a06b39ecaf8c6bb3bfc9b18b1cbb7ca4960d9550678ed6e33e0ed59469b&ipo=images' width='200' height='200' style='border-radius: 20px' class='shadow-xl mb-3 '> </br> <p class='mb-3 text-lg font-bold'>$title</p> </div> <style>hr{background-color: black}</style><div style='padding: 3px; border-radius: 10px; color:white; font-weight: bold'>" . $priceAmounts . " IQD </div>",
        ]);
    }

    public function selectLang($lang)
    {
        $this->lang = $lang;
    }

    public function backHome()
    {
        return redirect('/home');
    }

    public function render()
    {
        return view('livewire.menu');
    }
}
