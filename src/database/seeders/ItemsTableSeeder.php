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
                'image' => 'img/dummy/product/watch.jpg',
                'user_id' => '1',
                'condition_id' => '1',
                'name' => '腕時計',
                'brand' => 'Velnora',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'price' => '15000',
            ],
            [
                'image' => 'img/dummy/product/hdd.jpg',
                'user_id' => '1',
                'condition_id' => '2',
                'name' => 'HDD',
                'brand' => 'Syntique',
                'description' => '高速で信頼性の高いハードディスク',
                'price' => '5000',
            ],
            [
                'image' => 'img/dummy/product/onion.jpg',
                'user_id' => '1',
                'condition_id' => '3',
                'name' => '玉ねぎ3束',
                'brand' => 'Luvéro',
                'description' => '新鮮な玉ねぎ3束のセット',
                'price' => '300',
            ],
            [
                'image' => 'img/dummy/product/shoes.jpg',
                'user_id' => '1',
                'condition_id' => '4',
                'name' => '革靴',
                'brand' => 'Zerqon',
                'description' => 'クラシックなデザインの革靴',
                'price' => '4000',
            ],
            [
                'image' => 'img/dummy/product/pc.jpg',
                'user_id' => '1',
                'condition_id' => '1',
                'name' => 'ノートPC',
                'brand' => 'Nuvetta',
                'description' => '高性能なノートパソコン',
                'price' => '45000',
            ],
            [
                'image' => 'img/dummy/product/mike.jpg',
                'user_id' => '2',
                'condition_id' => '2',
                'name' => 'マイク',
                'brand' => 'Kaeliv',
                'description' => '高品質のレコーディング用マイク',
                'price' => '8000',
            ],
            [
                'image' => 'img/dummy/product/shoulderbag.jpg',
                'user_id' => '2',
                'condition_id' => '3',
                'name' => 'ショルダーバッグ',
                'brand' => 'Orrélle',
                'description' => 'おしゃれなショルダーバッグ',
                'price' => '3500',
            ],
            [
                'image' => 'img/dummy/product/tumbler.jpg',
                'user_id' => '2',
                'condition_id' => '4',
                'name' => 'タンブラー',
                'brand' => 'Fayvora',
                'description' => '使いやすいタンブラー',
                'price' => '500',
            ],
            [
                'image' => 'img/dummy/product/coffeemill.jpg',
                'user_id' => '2',
                'condition_id' => '1',
                'name' => 'コーヒーミル',
                'brand' => 'Treliant',
                'description' => '手動のコーヒーミル',
                'price' => '4000',
            ],
            [
                'image' => 'img/dummy/product/makeup.jpg',
                'user_id' => '2',
                'condition_id' => '2',
                'name' => 'メイクセット',
                'brand' => 'Myssoro',
                'description' => '便利なメイクアップセット',
                'price' => '2500',
            ],
        ]);
    }
}
