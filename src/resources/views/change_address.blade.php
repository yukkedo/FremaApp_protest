@extends('layouts.app')

@section('title')
<title>住所変更</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/change_address.css') }}">
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
            <li><a href="" class="header-nav__item">マイページ</a></li>
            <li><a href="/sell" class="header-nav__item--sell">出品</a></li>
        </ul>
    </nav>
</div>
@endsection

@section('content')
<div class="change-address">
    <div class="change-address__header">
        <h2>住所の変更</h2>
    </div>

    <form class="change-address__content" action="/purchase/address/{{ $item->id }}" method="post">
        @csrf
        <input type="hidden" name="item_id" value="{{ $item->id }}">
        <div class="form__group">
            <div class="form__group--title">
                <span class="form__label--item">郵便番号</span>
            </div>
            <div class="form__group--content">
                <input type="text" name="postcode" value="{{ $profile->postcode }}">
            </div>
        </div>
        <div class="form__group">
            <div class="form__group--title">
                <span class="form__label--item">住所</span>
            </div>
            <div class="form__group--content">
                <input type="text" name="address" value="{{ $profile->address }}">
            </div>
        </div>
        <div class="form__group">
            <div class="form__group--title">
                <span class="form__label--item">建物名</span>
            </div>
            <div class="form__group--content">
                <input type="text" name="building" value="{{ $profile->building }}">
            </div>
        </div>

        <div class="form__button">
            <button class="form__button--submit" type="submit">更新する</button>
        </div>
    </form>
</div>
@endsection