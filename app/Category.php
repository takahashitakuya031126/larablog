<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    
    protected $primaryKey = 'category_id';
    protected $fillable = ['name', 'display_order'];
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];
    
    public function articles()
    {
        return $this->hasMany('App\Article', 'category_id', 'category_id');
    }
    
    public function getCategoryList(int $num_per_page = 0, string $order = 'display_order', string $direction = 'asc')
    {
        $query = $this->orderBy($order, $direction);
        if ($num_per_page) {
            return $query->paginate($num_per_page);
        }
        return $query->get();
    }
}
