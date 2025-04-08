<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use App\Models\ProductSeason;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    //商品一覧の表示
    public function index()
    {
        $products = Product::Paginate(6); //ページネーション
        return view('index', compact('products'));
    }

    //商品の検索
    public function search(Request $request)
    {
        $keyword = $request->input('keyword'); //検索キーワードを取得
        $products = Product::KeywordSearch($keyword)->get(); //モデルで設定したローカルスコープを使用して検索
        return view('index', compact('products')); //検索結果をindexビューに渡して表示
    }


    //商品の並べ替え
    public function sort(Request $request)
    {
        $query = Product::query(); //クエリビルダのインスタンスを取得（データベースにお願いするための、今すぐに使える状態の道具の実物を取得する）
        $sort = $request->input('sort');

        switch ($sort) {
            case 'high_price': //index.bladeでの、optionのvalueの内容がここに入る
                $query->orderBy('price', 'desc'); //queryに対してorderBy()メソッドを呼び出して,priceカラムを昇順に並べる
                break;
            case 'low_price':
                $query->orderBy('price', 'asc');
                break;
        }

        $qroducts = $query->paginate(6);

        return view('index', compact('products', 'sort'));
    }




    //詳細画面の表示
    public function detail($product_id)
    {
        $product = Product::find($product_id); //指定されたIDのproductを取得
        $seasons = Season::all();
        return view('detail', compact('product', 'seasons')); //上で取得したデータを入れ込む
    }

    //商品の更新
    public function update(Request $request, $product_id)
    {
        $product = Product::find($product_id); //指定されたIDの商品データを取得
        $product->name = $request->input('name'); //リクエストから商品名を取得して表示
        $product->price = $request->input('price');
        if ($request->hasFile('image')) //画像がアップロードされた場合
        {
            $product->image = $request->file('image')->store('public/images');//画像をアップロードして設定
        }
        $product->seasons()->sync($request->input('seasons', []));
        $product->save();
        return redirect('/products');
    }

    //削除
    public function destroy($product_id)
    {
        $product = Product::find($product_id); //指定されたIDの商品データを取得
        $product->delete(); //データベースから削除
        return redirect('/products');
    }



    //商品の登録画面の表示
    public function create()
    {
        return view('/products/register');
    }

    //商品の登録
    public function store(Request $request)
    {
        $product = new Product(); //新しいProductモデルのインスタンスを作成
        $product->name = $request->input('name'); //リクエストから商品名を取得して設定
        $product->price = $request->input('price');
        $product->image = $request->file('image')->store('public/images'); //リクエストから画像をアップロードして設定
        $product->description = $request->input('description');
        $product->save(); //データベースに保存

        return redirect('/products');
    }
}
