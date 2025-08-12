@extends('layouts.app')

@section('title')
<title>商品出品</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('header')
<div class="header">
    <form class="header__search" action="">
        <input class="header__search--input" type="text" placeholder="なにをお探しですか？">
    </form>
    <nav class="header-nav">
        <ul class="header-nav__list">
            @if (Auth::check())
            <li>
                <form action="/logout" class="logout" method="post">
                    @csrf
                    <button class="header-nav__item--button">ログアウト</button>
                </form>
            </li>
            @endif
            <li><a href="/mypage?tab=sell" class="header-nav__item">マイページ</a></li>
            <li><a href="/sell" class="header-nav__item--sell">出品</a></li>
        </ul>
    </nav>
</div>
@endsection

@section('content')
<div class="sell">
    <h1 class="content__title">商品の出品</h1>
    <form action="/sell/image" class="form-area" method="post" enctype="multipart/form-data">
        @csrf
        <div class="content__item--img">
            <h3 class="item--title">商品の画像</h3>
            <div class="item--img-space">
                @if(session('image.path'))
                <div class="img-preview">
                    <img src="{{ asset(session('image.path')) }}" alt="商品画像" style="max-height: 140px;">
                </div>
                @else
                <input type="file" class="img-input" id="image" name="image" onchange="this.form.submit();" hidden>
                <label for="image" class="img-input--label">画像を選択する</label>
                @endif
            </div>
        </div>
    </form>
    <form action="/sell" class="form-area" method="post">
        @csrf
        <div class="content__item--detail">
            <h2 class="h2--title">商品の詳細</h2>

            <div class="item--area">
                <h3 class="item--title">カテゴリー</h3>
                <div class="category__item">
                    @foreach($categories as $category)
                    <input class="category__button" type="checkbox" id="category-{{ $loop->index }}" name="categories[]" value="{{ $category->id }}" hidden>
                    <label for="category-{{ $loop->index }}" class="category__input--label">{{$category->name}}</label>
                    @endforeach
                </div>
            </div>
            <div class="item--area">
                <h3 class="item--title">商品の状態</h3>
                <div class="condition__item">
                    <select name="condition_id" class="condition-select">
                        <option value="" disabled selected hidden>選択してください</option>
                        @foreach($conditions as $condition)
                        <option value="{{ $condition->id }}">{{$condition->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="content__item--explain">
            <h2 class="h2--title">商品名と説明</h2>

            <div class="item--area">
                <h3 class="item--title">商品名</h3>
                <div class="item--area">
                    <input type="text" class="item--input" name="name">
                </div>
            </div>
            <div class="detail__item--area">
                <h3 class="item-title">ブランド名</h3>
                <div class="item--area">
                    <input type="text" class="item--input" name="brand">
                </div>
            </div>
            <div class="detail__item--area">
                <h3 class="item-title">商品の説明</h3>
                <div class="item--area">
                    <textarea type="text" class="item--text" name="description"></textarea>
                </div>
            </div>
            <div class="detail__item--area">
                <h3 class="item-title">販売価格</h3>
                <div class="item--area">
                    <input type="text" class="item--input" name="price" placeholder="￥">
                </div>
            </div>
        </div>
        <div class="content__item--button">
            <button class="button">出品する</button>
        </div>
    </form>
</div>
@endsection