<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Article extends Model
{
    protected $primaryKey = 'article_id';
    
    protected $fillable = ['post_date', 'title', 'body'];
    
    protected $dates = ['post_date', 'created_at', 'updated_at', 'deleted_at'];
    
    public function getPostDateTextAttribute()
    {
        return $this->post_date->format('Y/m/d');
    }
    
    public function setPostDateAttribute($value)
    {
        $post_date = new Carbon($value);
        $this->attributes['post_date'] = $post_date->format('Y-m-d');
    }
}