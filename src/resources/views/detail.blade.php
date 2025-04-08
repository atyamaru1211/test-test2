@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}" />
@endsection

@section('content')
<div class="contents">
    <form action="/update" method="post">
        @method('patch')
        @csrf
        <div class="top-contents">
            <div class="left-content">
                <p><span class="span-item">商品一覧＞</span>{{$product->name}}</p>
                <img class="product-img" src="{{ asset($product->image) }}" alt="商品画像">
            </div>
            <div class="right-content">
                <label class="name-label">商品名</label>
                <input class="input" type="text" name="product_name" placeholder="{{ $product->name }}">
                @error('product_name')
                    <p class="error-message">{{ $message }}</p>
                @enderror

                <label class="price-label">値段</label>
                <input class="input" type="text" name="product_price" placeholder="{{ $product->price }}">
                @error('product_price')
                    <p class="error-message">{{ $message }}</p>
                @enderror
                <label class="season-label">季節</label>
                <div class="season-checkboxes">
                    @foreach ($seasons as $season)
                    <div class="season-checkbox">
                        <label for="season">
                            <input type="checkbox" name="seasons[]" value="{{ $season->id }}" {{ in_array($season->id, $product->season_ids)? 'checked' : '' }}>
                            {{$season->name}}
                            @if (in_array($season->id, $product->season_ids))
                                <img class="checkmark" src="{{ asset('images/check.png') }}" alt="チェックマーク">
                            @else
                                <img class="checkmark" src="{{ asset('images/check.png') }}" alt="チェックマーク" style="opacity: 0;">
                            @endif
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="under-content">
            <input class="image" type="file" name="product_image" id="product_image">
            <label class="description-label">商品説明</label>
            <textarea class="description-textarea" name="product_description">{{$product->description}}</textarea>
            <div class="buttons">
                <a class="back-button" href="/products">戻る</a>
                <button class="submit-button" type="submit">変更を保存</button>
                <div class="trash-can-content">
                    <a href="/products/{{$product->id}}/delete">
                        <img class="img-trash-can" src="{{ asset('/images/TiTrash.png') }}" alt="ゴミ箱の画像">
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection