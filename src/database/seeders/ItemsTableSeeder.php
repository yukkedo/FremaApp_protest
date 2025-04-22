<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            [
                'image' => 'storage/item_img/watch.jpg',
                'user_id' => '1',
                'condition_id' => '1',
                'name' => '腕時計',
                'brand' => 'Velnora',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'price' => '15000',
            ],
            [
                'image' => 'storage/item_img/hdd.jpg',
                'user_id' => '2',
                'condition_id' => '2',
                'name' => 'HDD',
                'brand' => 'Syntique',
                'description' => '高速で信頼性の高いハードディスク',
                'price' => '5000',
            ],
            [
                'image' => 'storage/item_img/onion.jpg',
                'user_id' => '3',
                'condition_id' => '3',
                'name' => '玉ねぎ3束',
                'brand' => 'Luvéro',
                'description' => '新鮮な玉ねぎ3束のセット',
                'price' => '300',
            ],
            [
                'image' => 'storage/item_img/shoes.jpg',
                'user_id' => '1',
                'condition_id' => '4',
                'name' => '革靴',
                'brand' => 'Zerqon',
                'description' => 'クラシックなデザインの革靴',
                'price' => '4000',
            ],
            [
                'image' => 'storage/item_img/pc.jpg',
                'user_id' => '2',
                'condition_id' => '1',
                'name' => 'ノートPC',
                'brand' => 'Nuvetta',
                'description' => '高性能なノートパソコン',
                'price' => '45000',
            ],
            [
                'image' => 'storage/item_img/mike.jpg',
                'user_id' => '3',
                'condition_id' => '2',
                'name' => 'マイク',
                'brand' => 'Kaeliv',
                'description' => '高品質のレコーディング用マイク',
                'price' => '8000',
            ],
            [
                'image' => 'storage/item_img/shoulderbag.jpg',
                'user_id' => '1',
                'condition_id' => '3',
                'name' => 'ショルダーバッグ',
                'brand' => 'Orrélle',
                'description' => 'おしゃれなショルダーバッグ',
                'price' => '3500',
            ],
            [
                'image' => 'storage/item_img/tumbler.jpg',
                'user_id' => '2',
                'condition_id' => '4',
                'name' => 'タンブラー',
                'brand' => 'Fayvora',
                'description' => '使いやすいタンブラー',
                'price' => '500',
            ],
            [
                'image' => 'storage/item_img/coffeemill.jpg',
                'user_id' => '3',
                'condition_id' => '1',
                'name' => 'コーヒーミル',
                'brand' => 'Treliant',
                'description' => '手動のコーヒーミル',
                'price' => '4000',
            ],
            [
                'image' => 'storage/item_img/makeup.jpg',
                'user_id' => '1',
                'condition_id' => '2',
                'name' => 'メイクセット',
                'brand' => 'Myssoro',
                'description' => '便利なメイクアップセット',
                'price' => '2500',
            ],
        ]);
    }
}
