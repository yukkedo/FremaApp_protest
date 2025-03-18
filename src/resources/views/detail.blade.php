@extends('layouts.app')

@section('title')
<title>商品詳細</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
            @else
            <li>
                <a href="/login" class="header-nav__item--button no-border">ログイン</a>
            </li>
            @endif
            <li><a href="" class="header-nav__item">マイページ</a></li>
            <li><a href="" class="header-nav__item--sell">出品</a></li>
        </ul>
    </nav>
</div>
@endsection

@section('content')
<div class="detail">
    <div class="left-content">
        <img src="{{ asset($item->image) }}" alt="商品画像" class="left-content__img">
    </div>
    <div class="right-content">
        <div class="item-name">
            <h3>{{$item->name}}</h3>
        </div>
        <div class="item-brand">
            <p>{{$item->brand}}</p>
        </div>
        <div class="item-price">
            <p>￥<span class="price-style">{{$item->price}} </span>(税込)</p>
        </div>
        <div class="item-check">
            <label for="favorite">
                <input type="checkbox" id="favorite" class="favorite-checkbox">
                <i class="fa-regular fa-star"></i>
            </label>
            <div class="button-comment">
                <i class="fa-regular fa-comment"></i>
            </div>
        </div>
        <div class="button-buy">
            <button class="purchase-button">購入手続きへ</button>
        </div>
        <div class="item__explain">
            <h3 class="item-title">商品説明</h3>
            <p class="item-text">{{$item->description}}</p>
        </div>
        <div class="item__info">
            <h3 class="item-title">商品説明</h3>
            <div class="info-content">
                <label for="" class="label">カテゴリー</label>
                @foreach($item->categories as $category)
                <p class="content--category">{{ $category->name }}</p>
                @endforeach
            </div>
            <div class="info-content">
                <label for="" class="label">商品の状態</label>
                <p class="content--condition">{{$item->condition->name}}</p>
            </div>
            <div class="comment">
                <h3 class="comment-title">コメント</h3>
                <div class="comment-user">
                    <img src="" alt="">
                    <p>admin</p>
                </div>
                <div class="comment-view">

                </div>
                <div class="comment-post">
                    <p>商品へのコメント</p>
                    <textarea></textarea>
                </div>
            </div>
        </div>
    </div>
    @endsection