<?php

namespace Database\Factories; // <-- PHẢI CÓ DÒNG NÀY

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    // ...
   // database/factories/CategoryFactory.php

public function definition(): array
{
    return [
        'name' => $this->faker->unique()->word(), 
        // Dòng này phải tồn tại:
        'code' => $this->faker->unique()->numerify('####'), 
    ];
}
}