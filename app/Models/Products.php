<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Products extends Model
{
    use HasFactory;
    protected $table = 'products';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'category_id',
        'producer_id',
        'description',
        'image',
        'price',
        'star',
        'like_count',
        'sold',
        'sale_off'
    ];

    public function producer()
    {
        return $this->belongsTo(User::class, 'producer_id');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    /* public function search($keyword)
    {
        return $this->where('name', 'like', '%' . $keyword . '%')->get();
    } */

    public function scopeSearch($query)
    {
        if (request('key')) {
            $key = request('key');
            $query = $query->where('name', 'like', '%' . $key . '%');
        }

        return $query;
    }

    public function scopeRecommendedProducts($query, $value)
    {
        return $query->orderBy('star', 'desc')->orderBy('sold', 'desc')->limit($value);
    }

    public function scopeFamousProducts($query)
    {
        return $query->where('star', '>=', 4)->orderBy('sold', 'desc')->take(10)->get('id')->pluck('id')->toArray();
    }

    public function likes()
    {
        return $this->hasMany(Likes::class);
    }

    public function stars()
    {
        return $this->hasMany(Star::class);
    }

    public function scopeUpdateStar($query)
    {
        return $query->update([
            'star' => DB::raw('IFNULL((SELECT AVG(star_number) FROM stars WHERE stars.product_id = products.id), 0)')
        ]);
    }

    public function scopeUpdateSold($query)
    {
        return $query->update(['sold' => DB::raw('IFNULL((SELECT SUM(quantity) FROM orders WHERE orders.product_id = products.id), 0)')]);
    }

    public function scopeUpdateLike($query)
    {
        return $query->update(['like_count' => DB::raw('IFNULL((SELECT COUNT(product_id) FROM likes WHERE likes.product_id = products.id ), 0)')]);
    }
}
