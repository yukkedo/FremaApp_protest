@extends('layouts.app')

@section('title')
<title>商品一覧</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection

@section('header')
<div class="header">
    <form class="header__search" action="">
        <input class="header__search--input" type="text" placeholder="なにをお探しですか？">
    </form>
    <nav class="header-nav">
        <ul class="header-nav__list">
            <li><a href="" class="header-nav__item">ログアウト</a></li>
            <li><a href="" class="header-nav__item">マイページ</a></li>
            <li><a href="" class="header-nav__item--sell">出品</a></li>
        </ul>
    </nav>
</div>
@endsection

@section('content')
<div class="item-list">
    <div class="page-tag">
        <a href="" class="list-view">おすすめ</a>
        <a href="" class="my-list">マイページ</a>
    </div>

    <div class="item__content">
        <div class="item__group">
            <div class="item__img">
                <img src="{{ asset('storage/item_img/watch.jpg') }}" alt="商品画像" width="290px" height="290px">
            </div>
            <div class="item__name">
                <p>商品名</p>
            </div>
        </div>
    </div>
</div>
@endsection