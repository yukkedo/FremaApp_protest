# 模擬案件　【フリマアプリ】

## Dockerビルド
1.  git clone git@github.com:coachtech-material/laravel-docker-template.git
2. docker-compose up -d --build

## Laravel環境構築
1. docker-compose exec php bash
2. composer install
3. .env.example ファイルから .envを作成し、環境変数を変更
4. php artisan key:generate
5. php artisan migrate
6. php artisan db:seed

## 開発環境
* ユーザー登録 : 
* phpMyAdmin : http://localhost:8080/

## 使用技術（実行環境）
* PHP : 7.4.9
* Laravel : 8.83.8
* MySQL : 8.0.26
* nginx : 1.21.1

## ER図
<img width="482" alt="Image" src="https://github.com/user-attachments/assets/77d4eedb-0593-4081-ba11-648962597f9f" />


