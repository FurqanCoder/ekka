<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'Organic',
            'Vegan',
            'Cruelty-Free',
            'Best Seller',
            'New Arrival',
            'Limited Edition',
        ];
        foreach($tags as $tag){
            DB::table('tags')->insert([
                'name' => $tag,
                // 'slug' => Str::slug($tag),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
