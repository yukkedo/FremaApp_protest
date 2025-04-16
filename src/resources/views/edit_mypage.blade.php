@extends('layouts.app')

@section('title')
<title>プロフィール設定</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/edit_mypage.css') }}">
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
            <li><a href="/mypage" class="header-nav__item">マイページ</a></li>
            <li><a href="/sell" class="header-nav__item--sell">出品</a></li>
        </ul>
    </nav>
</div>
@endsection

@section('content')
<div class="profile">
    <div class="form__header">
        <h2>プロフィール設定</h2>
    </div>

    <form class="form__content" action="/mypage/profile/image" method="post" enctype="multipart/form-data">
        @csrf
        <div class="profile__image">
            <div class="profile__upload">
                <img class="image-box" src="{{ asset('storage/' . session('profile.image_path', 'user_img/default.png')) }}" alt="プロフィール画像">
            </div>
            <div class="profile__button">
                <label class="custom-button" for="imageUpload">画像を選択する</label>
                <input class="file-input" type="file" name="image" id="imageUpload" accept="image/*" onchange="this.form.submit()">
            </div>
        </div>
    </form>
    <form action="/mypage/profile" method="post">
        @csrf
        <div class="form__group">
            <div class="form__group--title">
                <span class="form__label--item">ユーザー名</span>
            </div>
            <div class="form__group--content">
                <input type="text" name="name" value="{{ $userName ?? $user->name }}">
            </div>
        </div>
        <div class="form__group">
            <div class="form__group--title">
                <span class="form__label--item">郵便番号</span>
            </div>
            <div class="form__group--content">
                <input type="text" name="postcode" value="{{ old('postcode', $profile->postcode ?? '') }}">
            </div>
        </div>
        <div class="form__group">
            <div class="form__group--title">
                <span class="form__label--item">住所</span>
            </div>
            <div class="form__group--content">
                <input type="text" name="address" value="{{ old('address', $profile->address ?? '') }}">
            </div>
        </div>
        <div class="form__group">
            <div class="form__group--title">
                <span class="form__label--item">建物名</span>
            </div>
            <div class="form__group--content">
                <input type="text" name="building" value="{{ old('building', $profile->building ?? '') }}">
            </div>
        </div>
        <div class="form__button">
            <button class="form__button--submit" type="submit">更新する</button>
        </div>
    </form>
</div>

@endsection