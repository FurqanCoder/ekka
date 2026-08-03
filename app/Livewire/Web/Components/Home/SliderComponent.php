<?php

namespace App\Livewire\Web\Components\Home;

use App\Models\CarouselItem;
use Livewire\Component;

class SliderComponent extends Component
{
    public $slides = [];
    public $autoplaySpeed = 5000;
    public $showIndicators = true;
    public $showArrows = true;

    public function mount()
    {
        $this->loadSlides();
    }

    public function loadSlides()
    {
        // Fetch active carousel items ordered by sort_order
        $this->slides = CarouselItem::with('creator')
            ->where('status', 'active')
            ->where(function($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->where(function($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->orderBy('sort_order', 'asc')
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'offer_label' => $item->offer_label,
                    'discount_badge' => $item->discount_badge,
                    'description' => $item->description,
                    'button_text' => $item->button_text,
                    'button_link' => $item->button_link,
                    'image_url' => $item->image_url,
                    'image_path' => $item->image_path,
                    'status' => $item->status,
                    'sort_order' => $item->sort_order,
                ];
            })
            ->toArray();

        // If no slides found, add default demo slides
        if (empty($this->slides)) {
            $this->slides = $this->getDefaultSlides();
        }
    }

    protected function getDefaultSlides()
    {
        return [
            [
                'id' => null,
                'title' => 'New Fashion Collection',
                'offer_label' => 'Sale Offer',
                'discount_badge' => '50% OFF',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do',
                'button_text' => 'Order Now',
                'button_link' => '#',
                'image_url' => asset('web/images/main-slider-banner/1.jpg'),
                'image_path' => null,
                'sort_order' => 1,
            ],
            [
                'id' => null,
                'title' => 'Boat Headphone Sets',
                'offer_label' => 'Sale Offer',
                'discount_badge' => '30% OFF',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do',
                'button_text' => 'Order Now',
                'button_link' => '#',
                'image_url' => asset('web/images/main-slider-banner/2.jpg'),
                'image_path' => null,
                'sort_order' => 2,
            ],
        ];
    }

    public function refreshSlides()
    {
        $this->loadSlides();
        $this->dispatch('slidesRefreshed');
    }

    public function render()
    {
        return view('livewire.web.components.home.slider-component');
    }
}