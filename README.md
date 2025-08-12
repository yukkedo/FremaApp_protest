# pro入会テスト　【フリマアプリ:機能追加】

## Dockerビルド
1.  git clone git@github.com:yukkedo/FleaApp.git
2. docker-compose up -d --build

## Laravel環境構築
1. docker-compose exec php bash
2. composer install
3. .env.example ファイルから .envを作成し、環境変数を変更
4. php artisan key:generate
5. php artisan migrate
6. php artisan db:seed

## 開発環境 
* phpMyAdmin : http://localhost:8080/

## 使用技術（実行環境）
* PHP : 7.4.9
* Laravel : 8.83.8
* MySQL : 8.0.26
* nginx : 1.21.1

## ER図
<img width="1286" height="828" alt="Image" src="https://github.com/user-attachments/assets/cdcdccb4-e28c-4c53-b7ad-7ff1725557d0" />

## テストユーザー
    name : 山田 太郎
    email : yamadataro@example.com
    password : test12345

    name : 田中 次郎
    email : tanakajiro@example.com
    password : test12345

    name : 鈴木 三郎
    email : suzukisaburo@example.com
    password : test12345