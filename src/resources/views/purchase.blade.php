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
            <img src="" alt="商品画像" class="product__img">
            <div class="product__others">
                <h3 class="product__other--name">{{$item->name}}</h3>
                <p class="product__other--price">￥{{number_format($item->price)}}</p>
            </div>
        </div>
        <div class="payment-area">
            <h3 class="left-content--title">支払い方法</h3>
            <select name="" id="" class="payment__content">
                <option value="" disabled selected hidden>選択してください</option>
                <option value="">コンビニ払い</option>
                <option value="">カード支払い</option>
            </select>
        </div>
        <div class="address-area">
            <div class="address-area--title">
                <h3 class="left-content--title">配送先</h3>
                <a href="" class="address__change">変更する</a>
            </div>
            <div class="address__content">
                <p>〒000-0000</p>
                <p>ここは住所と建物名が入ります</p>
            </div>
        </div>
    </div>
    <div class="right-content">
        <table class="payment__confirmation">
            <tr class="price__item">
                <td class="payment__item--title">商品代金</td>
                <td class="payment__item--content">￥47,000</td>
            </tr>
            <tr class="payment__item">
                <td class="payment__item--title">支払い方法</td>
                <td class="payment__item--content">コンビニ払い</td>
            </tr>
        </table>
        <div class="payment__button">
            <button class="button">購入する</button>
        </div>
    </div>
</div>
@endsection