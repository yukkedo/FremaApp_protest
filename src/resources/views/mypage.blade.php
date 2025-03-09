@extends('layouts.app')

@section('title')
<title>プロフィール設定</title>
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
            <form action="/logout" class="logout" method="post">
                @csrf
                <button class="header-nav__item--button">ログアウト</></button>
            </form>
            @endif
            <li><a href="" class="header-nav__item">マイページ</a></li>
            <li><a href="" class="header-nav__item--sell">出品</a></li>
        </ul>
    </nav>
</div>
@endsection

@section('content')
<div class="profile">
    <div class="form__header">
        <h2>プロフィール設定</h2>
    </div>

    <form class="form__content" action="" method="">
        @csrf
        <div class="profile__upload">
            <label class="image-box" for="imageUpload">
                <img id="preview" alt="選択された画像">
            </label>
            <input class="file-input" type="file" id="imageUpload" accept="image/*">
            <label class="custom-button" for="imageUpload">画像を選択する</label>
        </div>
        <div class="form__group--error" style="color: red;">

        </div>

        <div class="form__group">
            <div class="form__group--title">
                <span class="form__label--item">ユーザー名</span>
            </div>
            <div class="form__group--content">
                <input type="text" name="name" value="{{ old('name') }}">
            </div>
            <div class="form__group--error" style="color: red;">
                @error('name')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form__group">
            <div class="form__group--title">
                <span class="form__label--item">郵便番号</span>
            </div>
            <div class="form__group--content">
                <input type="" name="postcord" value="">
            </div>
            <div class="form__group--error" style="color: red;">

            </div>
        </div>
        <div class="form__group">
            <div class="form__group--title">
                <span class="form__label--item">住所</span>
            </div>
            <div class="form__group--content">
                <input type="" name="address" value="">
            </div>
            <div class="form__group--error" style="color: red;">

            </div>
        </div>
        <div class="form__group">
            <div class="form__group--title">
                <span class="form__label--item">建物名</span>
            </div>
            <div class="form__group--content">
                <input type="" name="building" value="">
            </div>
            <div class="form__group--error" style="color: red;">

            </div>
        </div>

        <div class="form__button">
            <button class="form__button--submit" type="submit">更新する</button>
        </div>
    </form>
</div>

@endsection