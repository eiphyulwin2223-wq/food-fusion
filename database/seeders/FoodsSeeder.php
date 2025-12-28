<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('foods')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'title' => 'Spicy Chicken Fusion Curry',
                'description' => 'A blend of Indian spices with Thai coconut flavors.',
                'recipe' => 'Step 1: Heat oil... Step 2: Add chicken...',
                'main_image' => 'foods/chicken_curry.jpg',
                'type' => 'admin',
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'title' => 'Italian Cheese Burst Pasta',
                'description' => 'Creamy pasta with cheese-loaded sauce.',
                'recipe' => 'Boil pasta... Add cheese...',
                'main_image' => 'foods/cheese_pasta.jpg',
                'type' => 'user',
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'title' => 'Garlic Butter Rice Bowl',
                'description' => 'Simple aromatic rice with garlic butter.',
                'recipe' => 'Melt butter... Mix rice...',
                'main_image' => 'foods/garlic_rice.jpg',
                'type' => 'admin',
            ],
            [
                'id' => 4,
                'user_id' => 3,
                'title' => 'Chocolate Banana Shake',
                'description' => 'Refreshing drink with banana and dark chocolate.',
                'recipe' => 'Blend all ingredients...',
                'main_image' => 'foods/banana_shake.jpg',
                'type' => 'user',
            ],
            [
                'id' => 5,
                'user_id' => 1,
                'title' => 'Crispy BBQ Wings',
                'description' => 'BBQ glazed crispy chicken wings.',
                'recipe' => 'Marinate chicken... Fry...',
                'main_image' => 'foods/bbq_wings.jpg',
                'type' => 'admin',
            ],
            [
                'id' => 6,
                'user_id' => 4,
                'title' => 'Fusion Egg Fried Noodles',
                'description' => 'Chinese-style noodles with Indian tadka.',
                'recipe' => 'Boil noodles... Stir fry...',
                'main_image' => 'foods/egg_noodles.jpg',
                'type' => 'user',
            ],
            [
                'id' => 7,
                'user_id' => 1,
                'title' => 'Sweet Honey Glazed Salmon',
                'description' => 'Oven-baked salmon with honey glaze.',
                'recipe' => 'Brush honey sauce... Bake...',
                'main_image' => 'foods/salmon.jpg',
                'type' => 'admin',
            ],
            [
                'id' => 8,
                'user_id' => 5,
                'title' => 'Creamy Mushroom Soup',
                'description' => 'Thick soup made with mushrooms and cream.',
                'recipe' => 'Cook mushrooms... Blend...',
                'main_image' => 'foods/mushroom_soup.jpg',
                'type' => 'user',
            ],
            [
                'id' => 9,
                'user_id' => 1,
                'title' => 'Veggie Loaded Pizza',
                'description' => 'Homemade pizza topped with colorful vegetables.',
                'recipe' => 'Prepare dough... Add toppings...',
                'main_image' => 'foods/pizza.jpg',
                'type' => 'admin',
            ],
            [
                'id' => 10,
                'user_id' => 6,
                'title' => 'Strawberry Yogurt Parfait',
                'description' => 'Layers of yogurt, strawberry, and oats.',
                'recipe' => 'Layer yogurt... Add strawberries...',
                'main_image' => 'foods/yogurt_parfait.jpg',
                'type' => 'user',
            ],
        ]);
    }
}
