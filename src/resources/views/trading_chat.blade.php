@extends('layouts.app')

@section('title')
<title>取引チャット</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/trading_chat.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="sidebar">
        <p class="sidebar__title">その他の取引</p>
    </div>
    <div class="chat-container">
        <div class="seller-data">
            <div class="seller__img"></div>
            <p class="seller__name">「ユーザー名」さんとの取引画面</p>

            <button class="trading__button">取引を完了する</button>
        </div>
        <div class="items">
            <img src="" alt="商品画像" width="150px" height="150px">
            <div class="item__data">
                <p class="item--name">商品名</p>
                <p class="item--price">商品価格</p>
            </div>
        </div>
        <div class="messages">
            <div class="chat__messages--left">
                <div class="chat__message--box">
                    <div class="chat__message--user">
                        <img src="" alt="" class="user-img">
                        <p class="user-name">ユーザー名</p>
                    </div>
                    <div class="chat__message--content">
                        <div class="chat__message--text">
                            ほうほうこりゃー便利じゃないか
                        </div>
                    </div>
                </div>
            </div>
            <div class="chat__clear"></div>

            <div class="chat__messages--right">
                <div class="chat__message--box">
                    <div class="chat__message--user">
                        <img src="" alt="" class="user-img">
                        <p class="user-name">ユーザー名</p>
                    </div>
                    <div class="chat__message--content">
                        <div class="chat__message--text">
                            うん、まあまあ
                        </div>

                        <div class="chat__message--action">
                            <button class="edit">編集</button>
                            <button class="delete">削除</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="chat__clear"></div>
        </div>
        <div class="message--send">
            <textarea name="" id="" placeholder="取引メッセージを記入してください" class="send--text"></textarea>
            <button class="send--img">画像を追加</button>
            <button class="send-button"><img src="{{ asset('items/send.jpg') }}" alt="送信"></button>
        </div>
    </div>
</div>
@endsection