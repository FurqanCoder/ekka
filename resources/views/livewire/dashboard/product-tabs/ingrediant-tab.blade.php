<div>
    <h5 class="mb-3">Ingredients</h5>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Ingredient</th>
                <th>Percentage (%)</th>
                <th>Benefit</th>
                <th width="50">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ingredients as $index => $ingredient)
                <tr>
                    <td>
                        <input type="text" class="form-control" placeholder="e.g. Water"
                            wire:model="ingredients.{{ $index }}.ingredient">
                    </td>
                    <td>
                        <input type="number" step="0.01" class="form-control" placeholder="25"
                            wire:model="ingredients.{{ $index }}.percentage">
                    </td>
                    <td>
                        <input type="text" class="form-control" placeholder="Glowing your skin"
                            wire:model="ingredients.{{ $index }}.benefit">
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger"
                            wire:click="removeIngredientRow({{ $index }})">×</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-between mt-2">
        <button type="button" class="btn btn-sm btn-success" wire:click="addIngredientRow">
            + Add Ingredient
        </button>
        <button type="button" class="btn btn-sm btn-primary" wire:click="saveIngredients">
            Save Ingredients
        </button>

    </div>
</div>
