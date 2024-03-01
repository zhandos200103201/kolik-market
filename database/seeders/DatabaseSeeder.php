<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Feedback;
use App\Models\Product;
use App\Models\Role;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /** @var Role $role */
        $role = Role::factory()->create();

        User::factory(4)->create([
            'role_id' => $role->role_id
        ]);

        /** @var Role $roleSeller */
        $roleSeller = Role::factory()->create([
            'title' => 'Admin'
        ]);
        $user = User::factory()->create([
            'role_id' => $roleSeller->role_id
        ]);
        /** @var Category $details */
        $details = Category::factory()->create([
            'name' => 'Mechanical details'
        ]);
        /** @var Product $carDetail */
        $carDetail = Product::factory()->create([
            'user_id' => $user->user_id,
            'category_id' => $details->category_id
        ]);
        Feedback::factory(2)->create([
            'product_id' => $carDetail->product_id
        ]);

        /** @var Category $serviceCategory */
        $serviceCategory = Category::factory()->create([
            'name' => 'Washing the car.'
        ]);

        Service::factory(2)->create([
            'category_id' => $serviceCategory->category_id
        ]);
    }
}
