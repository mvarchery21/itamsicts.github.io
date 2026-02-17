<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\AssetAssignment;
use App\Models\User;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    public function run(): void
    {
        $assets = [
            [
                'name' => 'Dell Latitude 5520',
                'asset_tag' => 'LAP-001',
                'category' => 'Laptop',
                'description' => 'Dell Latitude 5520 - 15.6" FHD, Intel i7, 16GB RAM, 512GB SSD',
                'serial_number' => 'DL5520-2023-001',
                'manufacturer' => 'Dell',
                'model' => 'Latitude 5520',
                'purchase_date' => '2023-01-15',
                'purchase_price' => 1299.99,
                'status' => 'available',
            ],
            [
                'name' => 'HP EliteBook 840',
                'asset_tag' => 'LAP-002',
                'category' => 'Laptop',
                'description' => 'HP EliteBook 840 G8 - 14" FHD, Intel i5, 8GB RAM, 256GB SSD',
                'serial_number' => 'HP840-2023-002',
                'manufacturer' => 'HP',
                'model' => 'EliteBook 840 G8',
                'purchase_date' => '2023-02-20',
                'purchase_price' => 1099.99,
                'status' => 'available',
            ],
            [
                'name' => 'Lenovo ThinkPad X1',
                'asset_tag' => 'LAP-003',
                'category' => 'Laptop',
                'description' => 'Lenovo ThinkPad X1 Carbon - 14" FHD, Intel i7, 16GB RAM, 1TB SSD',
                'serial_number' => 'LVX1-2023-003',
                'manufacturer' => 'Lenovo',
                'model' => 'ThinkPad X1 Carbon Gen 9',
                'purchase_date' => '2023-03-10',
                'purchase_price' => 1599.99,
                'status' => 'assigned',
            ],
            [
                'name' => 'Apple MacBook Pro',
                'asset_tag' => 'LAP-004',
                'category' => 'Laptop',
                'description' => 'MacBook Pro 14" - M1 Pro, 16GB RAM, 512GB SSD',
                'serial_number' => 'MBP14-2023-004',
                'manufacturer' => 'Apple',
                'model' => 'MacBook Pro 14" M1',
                'purchase_date' => '2023-04-05',
                'purchase_price' => 1999.99,
                'status' => 'assigned',
            ],
            [
                'name' => 'Dell UltraSharp U2720Q',
                'asset_tag' => 'MON-001',
                'category' => 'Monitor',
                'description' => '27" 4K USB-C Monitor',
                'serial_number' => 'DLU27-2023-001',
                'manufacturer' => 'Dell',
                'model' => 'UltraSharp U2720Q',
                'purchase_date' => '2023-01-20',
                'purchase_price' => 549.99,
                'status' => 'available',
            ],
            [
                'name' => 'Logitech MX Keys',
                'asset_tag' => 'KBD-001',
                'category' => 'Keyboard',
                'description' => 'Wireless Illuminated Keyboard',
                'serial_number' => 'LGMX-2023-001',
                'manufacturer' => 'Logitech',
                'model' => 'MX Keys',
                'purchase_date' => '2023-02-15',
                'purchase_price' => 99.99,
                'status' => 'available',
            ],
            [
                'name' => 'iPhone 13 Pro',
                'asset_tag' => 'PHN-001',
                'category' => 'Mobile Phone',
                'description' => 'iPhone 13 Pro - 256GB, Graphite',
                'serial_number' => 'IP13-2023-001',
                'manufacturer' => 'Apple',
                'model' => 'iPhone 13 Pro',
                'purchase_date' => '2023-05-01',
                'purchase_price' => 1099.00,
                'status' => 'assigned',
            ],
        ];

        foreach ($assets as $assetData) {
            Asset::create($assetData);
        }

        // Create some assignments
        $john = User::where('email', 'john@example.com')->first();
        $jane = User::where('email', 'jane@example.com')->first();

        if ($john) {
            $laptop = Asset::where('asset_tag', 'LAP-003')->first();
            if ($laptop) {
                AssetAssignment::create([
                    'asset_id' => $laptop->id,
                    'user_id' => $john->id,
                    'assigned_date' => now()->subDays(30),
                    'notes' => 'Primary work laptop',
                    'status' => 'active',
                ]);
            }
        }

        if ($jane) {
            $macbook = Asset::where('asset_tag', 'LAP-004')->first();
            $iphone = Asset::where('asset_tag', 'PHN-001')->first();
            
            if ($macbook) {
                AssetAssignment::create([
                    'asset_id' => $macbook->id,
                    'user_id' => $jane->id,
                    'assigned_date' => now()->subDays(15),
                    'notes' => 'For design work',
                    'status' => 'active',
                ]);
            }
            
            if ($iphone) {
                AssetAssignment::create([
                    'asset_id' => $iphone->id,
                    'user_id' => $jane->id,
                    'assigned_date' => now()->subDays(10),
                    'notes' => 'Company mobile phone',
                    'status' => 'active',
                ]);
            }
        }
    }
}
