@extends('layouts.app')

@section('title')
<title>ログイン</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login">
    <div class="form__header">
        <h2>ログイン</h2>
    </div>

    <form class="form__content">
        <div class="form__group">
            <div class="form__group--title">
                <span class="form__label--item">メールアドレス</span>
            </div>
            <div class="form__group--content">
                <input type="email" name="email" value="">
            </div>
            <div class="form__group--error">

            </div>
        </div>
        <div class="form__group">
            <div class="form__group--title">
                <span class="form__label--item">パスワード</span>
            </div>
            <div class="form__group--content">
                <input type="password" name="password">
            </div>
            <div class="form__group--error">

            </div>
        </div>

        <div class="form__button">
            <button class="form__button--submit" type="submit">ログインする</button>
        </div>
    </form>
    <div class="register__link">
        <a href="" class="register__button">会員登録はこちら</a>
    </div>
</div>
@endsection