<?php

namespace App\Livewire\Dashboard;
use App\Models\{
    Brand,
    Category,
    Product,
    ProductCategory,
    ProductIngredients,
    ProductInstruction,
    ProductMedia,
    ProductPrice,
    ProductTags,
    ProductVariant,
    ProductVariantValue,
    Tag
};
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class EditProductComponent extends Component
{
     use WithFileUploads;

    // UI state
    public $activeTab = 'general';
     public $description = '';
    public $howtouse  = '';

    // general
    public $name;
    public $slug;
    public $brand;
    public $status = 'draft';
    public $schedule_time;

    // media
    public $thumbnail;       // single file
    public $gallery = [];    // multiple files

    // pricing
    public $c_price = 0;
    public $b_price = 0;
    public $discountType = 'none'; // none|percent|fixed
    public $d_value = 0;
    public $taxType = 'tax_free'; // tax_free|taxable|digital
    public $vat = 0;
    public $f_price = 0;
    public $a_profit = 0;

    // inventory
    public $sku;
    public $track_stock = false;
    public $quantity = 0;

    // variants
    public $variants = [];

    // categories & tags
    public $categories = [];
    public $subcategories = [];
    public $selectedParent = null;
    public $selectedTags = [];

    // instructions
    public $ins_media; // single file (image or video)

    // ingredients
    public $ingredients = [];

    // seo
    public $meta_title;
    public $meta_des;
    public $meta_keywords;

    protected $listeners = [
        'ingredientsUpdated' => 'setIngredients',
        'variantsUpdated'    => 'setVariants',
    ];
    public $product;
    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }
    public function mount($id){

    }
    public function render()
    {
        return view('livewire.dashboard.edit-product-component');
    }
}
