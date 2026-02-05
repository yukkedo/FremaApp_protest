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
            @if($isBuyer && !$showReviewForm)
            <a class="trading__button" href="/trading/{{ $item->id }}?review=1">取引を完了する</a>
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
                        <img src="{{ asset('storage/' . $message->user->profile->image) }}" alt="プロフィール画像" class="user-img--right">
                        @else
                        <div class="default-img--right"></div>
                        @endif
                    </div>
                    <div class="chat__message--area">
                        <div class="chat__message--content">
                            <form action="/trading/{{ $chatRoom->id }}/message/{{ $message->id }}" method="post" class="chat__edit-form">
                                @csrf
                                @method('PUT')

                                <input class="chat__message--text" value="{{ $message->message }}" name="message" type="text">
                                @if($message->image)
                                <div class="chat__message--image">
                                    <img src="{{ asset('storage/' . $message->image) }}" alt="" width="100">
                                </div>
                                @endif
                            </form>
                        </div>

                        <div class="chat__buttons-row">
                            <form action="/trading/{{ $chatRoom->id }}/message/{{ $message->id }}"
                                method="post"
                                class="chat__edit-form">
                                @csrf
                                @method('PUT')
                                <button class="edit" type="submit">編集</button>
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
            </div>
            @else
            <div class="chat__messages--left">
                <div class="chat__message--box">
                    <div class="chat__message--user-left">
                        @if ($message->user->profile && $message->user->profile->image)
                        <img
                            src="{{ asset('storage/' . $message->user->profile->image) }}"
                            alt="プロフィール画像"
                            class="user-img--left">
                        @else
                        <div class="default-img--left"></div>
                        @endif
                        <p class="user-name--left">
                            {{ $message->user->name }}
                        </p>
                    </div>
                    <div class="chat__message--content">
                        @if($message->message)
                        <div class="chat__message--text">
                            {{ $message->message }}
                        </div>
                        @endif

                        @if($message->image)
                        <div class="chat__message--image">
                            <img src="{{ asset('storage/' . $message->image) }}" alt="送信画像" width="100">
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="chat__clear"></div>
            @endif
            @endforeach
        </div>

        <form class="send-form" action="/trading/{{ $chatRoom->id }}/send" method="post" enctype="multipart/form-data">
            @csrf
            @foreach ($errors->all() as $error)
            <div class="error-message">{{ $error }}</div>
            @endforeach
            <div class="message--send">
                <textarea name="message" placeholder="取引メッセージを記入してください" class="send--text"></textarea>

                <label class="send--img" for="chat-img">画像を追加</label>
                <input type="file" name="image" id="chat-img" hidden>
                <button class="send-button" type="submit">
                    <img src="{{ asset('items/send.jpg') }}" alt="送信">
                </button>
            </div>
        </form>
    </div>

    @if ($showReviewForm)
    <div class="modal">
        <form action="/trading/{{ $purchase->id }}/review" method="post">
            @csrf
            <p class="modal__title">取引が完了しました</p>
            <div class="form-rating">
                <p class="rating--content">
                    今回の取引相手はどうでしたか？
                </p>
                <div class="rating-star">
                    @for ($i = 5; $i >= 1; $i--)
                    <input type="radio" class="rating--input" id="star{{ $i }}" name="rating" value="{{ $i }}">
                    <label for="star{{ $i }}" class="rating--label">
                        <img src="/items/Star_empty.png" alt="5 stars">
                    </label>
                    @endfor
                    <!-- <input type="radio" class="rating--input" id="star4" name="rating" value="4">
                    <label for="star4" class="rating--label">
                        <img src="/items/Star_empty.png" alt="4 stars">
                    </label>

                    <input type="radio" class="rating--input" id="star3" name="rating" value="3">
                    <label for="star3" class="rating--label">
                        <img src="/items/Star_empty.png" alt="3 stars">
                    </label>

                    <input type="radio" class="rating--input" id="star2" name="rating" value="2">
                    <label for="star2" class="rating--label">
                        <img src="/items/Star_empty.png" alt="2 stars">
                    </label>

                    <input type="radio" class="rating--input" id="star1" name="rating" value="1">
                    <label for="star1" class="rating--label">
                        <img src="/items/Star_empty.png" alt="1 stars">
                    </label> -->
                </div>
                <div class="form-rating--button">
                    <button type="submit" class="button">送信する</button>
                </div>
            </div>
        </form>
    </div>
    @endif
</div>
@endsection