@extends('layouts.app')

@section('title')
<title>マイページ</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
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
<div class="profile-content">
    <div class="user">
        <div class="user-img">
            @if ($user->profile && $user->profile->image)
            <img src="{{ asset('storage/' . $user->profile->image) }}" alt="プロフィール画像">
            @else
            <div class="default-profile"></div>
            @endif
        </div>
        <div class="user-name">
            <h3>{{ $user->name }}</h3>
            @if (!is_null($averageRating))
            <div class="star-rating">
                @for ($i = 1; $i <= 5; $i++)
                    @if($i <= $averageRating)
                    <img src="{{ asset('items/Star_filled.png') }}" alt="">
                    @else
                    <img src="{{ asset('items/Star_empty.png') }}" alt="">
                    @endif
                @endfor
            </div>
            @endif
        </div>
        <div class=" user-button">
            <a class="profile__edit" href="/mypage/profile">プロフィールを編集する</a>
        </div>
    </div>

    <div class="page-tag">
        <a href="/mypage?tab=sell" class="tag {{ request('tab', 'sell') == 'sell' ? 'active' : '' }}">出品した商品</a>
        <a href="/mypage?tab=buy" class="tag {{ request('tab', 'buy') == 'buy' ? 'active' : '' }}">購入した商品</a>
        <a href="/mypage?tab=trading" class="tag {{ request('tab', 'trading') == 'trading' ? 'active' : '' }}">
            取引中の商品
            @if ($totalUnreadCount > 0)
            <span class="total-unread-count">
                {{ $totalUnreadCount }}
            </span>
            @endif
        </a>
    </div>
    <div class="tag-content">
        @foreach ($items as $item)
        <div class="item__group">
            <div class="item__img">
                @if ($tab === 'trading')
                <a href="/trading/{{$item->id}}" class="item-image__wrapper">
                    <img src="{{ asset($item->image) }}" alt="商品画像" width="250px" height="250px">
                </a>
                @php
                $chatRoomId = $itemChatRoomMap[$item->id] ?? null;
                $unread = $chatRoomId ? ($unreadCounts[$chatRoomId] ?? 0) : 0;
                @endphp
                @if ($unread > 0)
                <span class="unread-count">
                    {{ $unread }}
                </span>
                @endif
                @else
                <a href="/item/{{$item->id}}" class="item-image__wrapper">
                    <img src="{{ asset($item->image) }}" alt="商品画像" width="250px" height="250px">
                </a>
                @endif
            </div>
            <div class="item__name">
                <p>{{$item->name}}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection