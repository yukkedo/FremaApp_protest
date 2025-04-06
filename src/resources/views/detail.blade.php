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
            <li><a href="/mypage" class="header-nav__item">マイページ</a></li>
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
            <p>￥<span class="price-style">{{ number_format($item->price) }}</span>(税込)</p>
        </div>
        <div class="item-check">
            <div class="item-check--like">
                <form action="/item/{item_id}" method="post">
                    @csrf
                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                    <button type="submit" class="like-button border-none bg-transparent cursor-pointer">
                        <span class="{{ $isLiked ? 'fas fa-star text-yellow-500' : 'far fa-star text-gray-400' }} text-4xl"></span>
                    </button>
                </form>
                <p class="text-sm text-gray-600">{{ $likeCount }}</p>
            </div>
            <div class="item-check--comment">
                <i class="fa-regular fa-comment"></i>
                <p class="text-sm text-gray-600">{{ $commentCount }}</p>
            </div>
        </div>
        <div class="button-buy">
            <a class="purchase-button" href="/purchase/{{$item->id}}">購入手続きへ</a>
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
                <h3 class="comment-title">コメント（<span>{{$commentCount}}</span>）</h3>
                @foreach($comments as $comment)
                <div class="comment-user">
                    <img src="" alt="">
                    <p>{{$comment->user->name}}</p>
                </div>
                <div class="comment-view">
                    <p>{{$comment->content}}</p>
                </div>
                @endforeach
                <div class="comment-area">
                    <p class="label">商品へのコメント</p>
                    <form action="/item/{item_id}" method="post">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <textarea class="comment-text" name="content"></textarea>
                        <button class="comment-button">コメントを送信する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection