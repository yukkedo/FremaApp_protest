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
        @if($isSeller && count($sidebarTrades) > 0)
        @foreach($sidebarTrades as $trade)
        <div class="trading-item">
            <a href="/trading/{{$trade->id}}">
                {{ $trade->name }}
            </a>
        </div>
        @endforeach
        @endif
    </div>
    <div class="chat-container">
        <div class="user-data">
            <div class="user__img">
                @if ($otherParty->profile && $otherParty->profile->image)
                <img src="{{ asset('storage/' . $otherParty->profile->image) }}" alt="プロフィール画像">
                @else
                <div class="default-profile"></div>
                @endif
            </div>
            <p class="user__name">
                「{{ $otherParty->name }}」さんとの取引画面
            </p>
            @if($isBuyer)
            <button class="trading__button">取引を完了する</button>
            @endif
        </div>
        <div class="items">
            <img src="{{ asset($item->image) }}" alt="商品画像" width="150px" height="150px">
            <div class="item__data">
                <p class="item--name">
                    {{ $item->name }}
                </p>
                <p class="item--price">
                    ¥ {{ number_format($item->price) }}
                </p>
            </div>
        </div>
        <div class="messages">
            @foreach($messages as $message)
            @if($message->is_right)
            <div class="chat__messages--right">
                <div class="chat__message--box">
                    <div class="chat__message--user-right">
                        <p class="user-name--right">
                            {{ $message->user->name }}
                        </p>
                        @if ($message->user->profile && $message->user->profile->image)
                        <img src="{{ $message->user->profile->image}}" alt="プロフィール画像" class="user-img--right">
                        @else
                        <div class="default-img--right"></div>
                        @endif
                    </div>
                    <div class="chat__message--content">
                        <form action="/trading/{{ $chatRoom->id }}/message/{{ $message->id }}" method="post" class="chat__edit-form">
                            @csrf
                            @method('PUT')
                            <input class="chat__message--text" value="{{ $message->message }}" name="message" type="text">
                            <div class="chat__buttons-row">
                                <button class="edit" type="submit">編集</button>
                            </div>
                        </form>
                        <form action="/trading/{{ $chatRoom->id }}/message/{{ $message->id }}" method="post" class="chat__delete-form">
                            @csrf
                            @method('DELETE')
                            <button class="delete" type="submit">削除</button>
                        </form>
                    </div>
                </div>
            </div>
        
        <div class="chat__clear"></div>
        @else
        <div class="chat__messages--left">
            <div class="chat__message--box">
                <div class="chat__message--user-left">
                    @if ($message->user->profile && $message->user->profile->image)
                    <img src="{{ $message->user->profile->image}}" alt="プロフィール画像" class="user-img--left">
                    @else
                    <div class="default-img--left"></div>
                    @endif
                    <p class="user-name--left">
                        {{ $message->user->name }}
                    </p>
                </div>
                <div class="chat__message--content">
                    <div class="chat__message--text">
                        {{ $message->message }}
                    </div>
                </div>
            </div>
        </div>
        <div class="chat__clear"></div>
        @endif
        @endforeach
    </div>
    <form class="message--send" action="/trading/{{ $chatRoom->id }}/send" method="post" enctype="multipart/form-data">
        @csrf
        <textarea name="message" placeholder="取引メッセージを記入してください" class="send--text"></textarea>

        <input type="file" name="image" id="chat-img" hidden>
        <button class="send--img" type="button">画像を追加</button>
        <button class="send-button" type="submit">
            <img src="{{ asset('items/send.jpg') }}" alt="送信">
        </button>
    </form>
</div>
</div>
@endsection