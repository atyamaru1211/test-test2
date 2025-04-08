<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'image', 'description'];

    public function seasons()
    {
        return $this->belongsToMany(Season::class, 'product_season');
    }

    //季節のチェックボックス表示するために取得する
    public function getSeasonIdsAttribute()
    {
        return $this->seasons->pluck('id')->toArray();
    }

    //検索機能　ローカルスコープ
    public function scopeKeywordSearch($query, $keyword)
    {
        if (!empty($keyword)) {
            $query->where('name', 'like', '%' .$keyword . '%');
        }
    }
}
