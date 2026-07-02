<?php

namespace App\Livewire\Dashboard\ProductTabs;

use Livewire\Component;

class IngrediantTab extends Component
{
    public $ingredients = [];

    public function mount($ingredients = [])
    {
        // Hydrate when editing
        if (!empty($ingredients)) {
            $this->ingredients = collect($ingredients)->map(function ($ing) {
                return [
                    'ingredient' => $ing['ingredient'] ?? '',
                    'percentage' => $ing['percentage'] ?? '',
                    'benefit'    => $ing['benefit'] ?? '',
                ];
            })->toArray();
        }

        // Default for creating new
        if (empty($this->ingredients)) {
            $this->ingredients = [
                ['ingredient' => '', 'percentage' => '', 'benefit' => '']
            ];
        }
    }

    public function addIngredientRow()
    {
        $this->ingredients[] = ['ingredient' => '', 'percentage' => '', 'benefit' => ''];
        $this->dispatch('ingredientsUpdated', $this->ingredients);
    }

    public function removeIngredientRow($index)
    {
        unset($this->ingredients[$index]);
        $this->ingredients = array_values($this->ingredients);
        $this->dispatch('ingredientsUpdated', $this->ingredients);
    }

    /**
     * Lifecycle hook — called automatically when $ingredients changes
     */
    public function updatedIngredients()
    {
        $this->dispatch('ingredientsUpdated', $this->ingredients);
    }

    /**
     * Explicit save method for button click
     */
    public function saveIngredients()
    {
        $this->dispatch('ingredientsUpdated', $this->ingredients);
        session()->flash('success', 'Ingredients saved successfully!');
    }

    public function render()
    {
        return view('livewire.dashboard.product-tabs.ingrediant-tab');
    }
}
