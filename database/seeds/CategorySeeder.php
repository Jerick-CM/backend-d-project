<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Laptop Computer',
            'Desktop Computer',
            'Furniture',
            'Accessory',
            'Audio & Speakers',
            'Others',
        ];

        foreach ($categories as $category) {
            $this->execute($category);
        }
    }

    public function execute($name)
    {
        Category::create([
            'name' => $name,
        ]);
    }
}
