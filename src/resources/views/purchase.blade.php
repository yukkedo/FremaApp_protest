@extends('layouts.app')

@section('title')
<title>商品購入</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
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
<div class="purchase">
    <div class="left-content">
        <div class="product-area">

            <img src="{{ asset($item->image) }}" alt="商品画像" class="product__img">
            <div class="product__others">
                <h3 class="product__other--name">{{ $item->name }}</h3>
                <p class="product__other--price">￥{{ number_format($item->price) }}</p>
            </div>
        </div>
        <div class="payment-area">
            <h3 class="left-content--title">支払い方法</h3>
            <form action="/purchase/{{ $item->id }}" method="get">
                <select name="payment_method" onchange="this.form.submit()" class=" payment__content">
                    <option value="" disabled selected hidden {{ $paymentMethod === null ? 'selected' : '' }}>選択してください</option>
                    <option value="convenience" {{ $paymentMethod === 'convenience' ? 'selected' : '' }}>コンビニ払い</option>
                    <option value="card" {{ $paymentMethod === 'card' ? 'selected' : '' }}>カード支払い</option>
                </select>
            </form>
        </div>
        <div class="address-area">
            <div class="address-area--title">
                <h3 class="left-content--title">配送先</h3>
                <a href="/purchase/address/{{ $item->id }}" class="address__change">変更する</a>
            </div>
            <div class="address__content">
                @if($profile)
                <p>〒{{ $profile->postcode }} </p>
                <p>{{ $profile->address }}{{ $profile->building }}</p>
                @endif
            </div>
        </div>
    </div>
    <div class=" right-content">
        <table class="payment__confirmation">
            <tr class="price__item">
                <td class="payment__item--title">商品代金</td>
                <td class="payment__item--content">￥{{ number_format($item->price) }}</td>
            </tr>
            <tr class="payment__item">
                <td class="payment__item--title">支払い方法</td>
                <td class="payment__item--content">
                    @if($displayPayment === 'card')
                    カード支払い
                    @else
                    コンビニ払い
                    @endif
                </td>
            </tr>
        </table>
        <form class="payment__button" action="/purchase/{{ $item->id }}" method="post">
            @csrf
            <button class="button" type="submit">購入する</button>
        </form>
    </div>
</div>
@endsection