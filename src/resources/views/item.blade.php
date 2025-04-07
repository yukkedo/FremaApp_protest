@extends('layouts.app')

@section('title')
<title>商品一覧</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection

@section('header')
<div class="header">
    <form class="header__search" action="/" method="get">
        @csrf
        <input class="header__search--input" type="text" name="search" value="{{request()->input('search')}}" placeholder="なにをお探しですか？">
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
            <li><a href="/sell" class="header-nav__item--sell">出品</a></li>
        </ul>
    </nav>
</div>
@endsection

@section('content')
<div class="item-list">
    <div class="page-tag">
        <a href="/" class="list-view">おすすめ</a>
        <a href="/?tab=mylist" class="my-list">マイページ</a>
    </div>

    <div class="item__content">
        @foreach ($items as $item)
        <div class="item__group">
            <div class="item__img">
                <a href="/item/{{$item->id}}">
                    <img src="{{ asset($item->image) }}" alt="商品画像" width="250px" height="250px">
                </a>
            </div>
            <div class="item__name">
                <p>{{$item->name}}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection