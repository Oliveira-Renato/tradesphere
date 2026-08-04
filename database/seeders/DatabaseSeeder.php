<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;
use App\Models\Product;
use App\Models\Inventory;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Tenant 1: Empresa Global de Tecnologia
        $tenant1 = Tenant::create([
            'name' => 'Acme Global Tech',
            'slug' => 'acme-tech',
        ]);

        $product1 = Product::create([
            'tenant_id' => $tenant1->id,
            'sku' => 'MACBOOK-M3-PRO',
            'name' => 'MacBook Pro M3 Max 36GB',
            'price' => 3499.00,
        ]);

        Inventory::create([
            'product_id' => $product1->id,
            'quantity' => 10, // Estoque inicial
        ]);

        $product2 = Product::create([
            'tenant_id' => $tenant1->id,
            'sku' => 'DELL-XPS-15',
            'name' => 'Dell XPS 15 Intel i9',
            'price' => 2299.00,
        ]);

        Inventory::create([
            'product_id' => $product2->id,
            'quantity' => 5,
        ]);

        // Tenant 2: Distribuidora de Eletrônicos
        $tenant2 = Tenant::create([
            'name' => 'LogiExpress Logistics',
            'slug' => 'logiexpress',
        ]);

        $product3 = Product::create([
            'tenant_id' => $tenant2->id,
            'sku' => 'MONITOR-LG-4K',
            'name' => 'Monitor LG UltraFine 32" 4K',
            'price' => 699.00,
        ]);

        Inventory::create([
            'product_id' => $product3->id,
            'quantity' => 20,
        ]);
    }
}