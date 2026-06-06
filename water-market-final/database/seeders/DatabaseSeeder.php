<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Inventory;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@watermarket.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'address' => 'Station Office, Water Market HQ'
        ]);

        // Create Staff
        User::create([
            'name' => 'Staff Member',
            'email' => 'staff@watermarket.com',
            'password' => Hash::make('staff123'),
            'role' => 'staff',
            'address' => 'Staff Quarters, Sector 7'
        ]);

        // Create Sample Customer
        User::create([
            'name' => 'John Customer',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('user123'),
            'role' => 'customer',
            'address' => '123 Residential Area, North Side'
        ]);

        // Initial Inventory
        Inventory::create([
            'name' => 'Purified Water', 
            'category' => 'Water', 
            'description' => 'Refill of purified water using 24-stage filtration process.', 
            'quantity' => 491, 
            'unit' => 'containers', 
            'price' => 30.00
        ]);
        
        Inventory::create([
            'name' => 'Slim Container', 
            'category' => 'Container', 
            'description' => 'Brand new 5-gallon slim blue container.', 
            'quantity' => 150, 
            'unit' => 'pcs', 
            'price' => 250.00
        ]);
        
        Inventory::create([
            'name' => 'Bottled Water (500ml)', 
            'category' => 'Product', 
            'description' => 'Convenient small bottled water for on-the-go.', 
            'quantity' => 45, 
            'unit' => 'bottles', 
            'price' => 10.00
        ]);
    }
}
