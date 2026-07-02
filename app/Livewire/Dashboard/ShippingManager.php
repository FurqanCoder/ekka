<?php

namespace App\Livewire\Dashboard;

use App\Models\ShippingMethod;
use App\Models\ShippingZone;
use Livewire\Component;

class ShippingManager extends Component
{
    public $zones, $methods;

    // Form data
    public $zoneId, $zoneName, $regions = [];
    public $methodId, $methodName, $type = 'flat_rate', $cost, $estimated_days, $zone_id;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->zones = ShippingZone::with('methods')->get();
        $this->methods = ShippingMethod::with('zone')->get();
    }

    /** ------------------------------
     * Zone Functions
     * ------------------------------ */
    public function saveZone()
    {
        $this->validate([
            'zoneName' => 'required|string|max:255',
        ]);

        ShippingZone::updateOrCreate(
            ['id' => $this->zoneId],
            ['name' => $this->zoneName, 'regions' => $this->regions]
        );

        $this->reset(['zoneId', 'zoneName', 'regions']);
        $this->loadData();
        session()->flash('success', 'Zone saved successfully!');
    }

    public function editZone($id)
    {
        $zone = ShippingZone::findOrFail($id);
        $this->zoneId = $zone->id;
        $this->zoneName = $zone->name;
        $this->regions = $zone->regions ?? [];
    }

    public function deleteZone($id)
    {
        ShippingZone::destroy($id);
        $this->loadData();
    }

    /** ------------------------------
     * Method Functions
     * ------------------------------ */
    public function saveMethod()
    {
        $this->validate([
            'methodName' => 'required|string|max:255',
            'type' => 'required|in:flat_rate,free,courier_api',
            'zone_id' => 'nullable|exists:shipping_zones,id',
        ]);

        ShippingMethod::updateOrCreate(
            ['id' => $this->methodId],
            [
                'name' => $this->methodName,
                'type' => $this->type,
                'cost' => $this->type === 'free' ? 0 : ($this->cost ?? 0),
                'estimated_days' => $this->estimated_days,
                'shipping_zone_id' => $this->zone_id,
            ]
        );

        $this->reset(['methodId', 'methodName', 'type', 'cost', 'estimated_days', 'zone_id']);
        $this->loadData();
        session()->flash('success', 'Shipping method saved!');
    }

    public function editMethod($id)
    {
        $method = ShippingMethod::findOrFail($id);
        $this->methodId = $method->id;
        $this->methodName = $method->name;
        $this->type = $method->type;
        $this->cost = $method->cost;
        $this->estimated_days = $method->estimated_days;
        $this->zone_id = $method->shipping_zone_id;
    }

    public function deleteMethod($id)
    {
        ShippingMethod::destroy($id);
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.dashboard.shipping-manager')->extends('layouts.admin')->section('admin-content');
    }
}
