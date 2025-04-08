@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('content')
<div class="all-contents">
    <!--左側のツール-->
    <div class="left-contents">
        <h1>商品一覧</h1>
        <form action="/products/search" method="post">
        @csrf
            <!--検索欄-->
            <input class="keyword" type="text" name="keyword" placeholder="商品名で検索"/>
            <button class="submit-button" type="submit">検索</button>
            <!--並べ替え-->
            <label class="select-label">価格順で表示</label>
            <select class="select" name="sort" id="sort">
                <option value="">価格で並べ替え</option>
                <option value="high_price">高い順に表示</option>
                <option value="low_price">低い順に表示</option>
            </select>
        </form>
        @if(@isset($sort)&& $sort !="")<!--isset：変数の存在とnullチェックを同時に行ってくれる。$sortって箱(変数)があって、かつ空じゃないときにif内を実行。$sort != ""：箱に何かしらの値がはいっているかどうかの確認。-->
            <div class="sort_contents">
                <p class="searched_data">{{$sort}}</p>
                <div class="close-content">
                    <a href="/products">
                        <p class="close-icone"></p>
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!--右側-->
    <div class="right-contents">
        <p class="message">{{session('message')}}</p>
        <!--追加ボタン-->
        <a class="add-button" href="/products/register"><span>+</span>商品を追加</a>
        <!--商品リスト-->
        <div class="product-contents">
            @foreach ($products as $product)
            <div class="product-content">
                <a class="product-link" href="/products/{{$product->id}}"></a>
                <img class="product-img" src="{{ asset($product->image) }}" alt="商品画像">
                <div class="product-detail">
                    <p>{{$product->name}}</p>
                    <p>{{$product->price}}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="pagination">
            {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection