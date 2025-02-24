@extends('layouts.app')

@section('title')
<title>会員登録</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register">
    <div class="form__header">
        <h2>会員登録</h2>
    </div>

    <form class="form__content">
        <div class="form__group">
            <div class="form__group--title">
                <span class="form__label--item">ユーザー名</span>
            </div>
            <div class="form__group--content">
                <input type="text" name="name" value="">
            </div>
            <div class="form__group--error">

            </div>
        </div>
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
        <div class="form__group">
            <div class="form__group--title">
                <span class="form__label--item">確認用パスワード</span>
            </div>
            <div class="form__group--content">
                <input type="password" name="password">
            </div>
            <div class="form__group--error">

            </div>
        </div>

        <div class="form__button">
            <button class="form__button--submit" type="submit">登録する</button>
        </div>
    </form>
    <div class="login__link">
        <a href="" class="login__button">ログインはこちら</a>
    </div>
</div>
@endsection