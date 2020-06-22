<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;
    
    protected $primaryKey = 'article_id';
    
    protected $fillable = ['category_id', 'post_date', 'title', 'body'];
    
    protected $dates = ['post_date', 'created_at', 'updated_at', 'deleted_at'];
    
    public function category()
    {
        return $this->hasOne('App\Category', 'category_id', 'category_id');
    }
    
    public function getArticleList(int $num_per_page = 10, array $condition = [])
    {
        $category_id = array_get($condition, 'category_id');
        $year  = array_get($condition, 'year');
        $month = array_get($condition, 'month');
        
        $query = $this->with('category')->orderBy('article_id', 'desc');
        
        if ($category_id) {
            $query->where('category_id', $category_id);
        }
        
        if ($year) {
            if ($month) {
                $start_date = Carbon::createFromDate($year, $month, 1);
                $end_date   = Carbon::createFromDate($year, $month, 1)->addMonth();
            } else {
                $start_date = Carbon::createFromDate($year, 1, 1);
                $end_date   = Carbon::createFromDate($year, 1, 1)->addYear();
            }
            $query->where('post_date', '>=', $start_date->format('Y-m-d'))
                  ->where('post_date', '<',  $end_date->format('Y-m-d'));
        }
        
        return $query->paginate($num_per_page);
    }
    
    public function getMonthList()
    {
        $month_list = $this->selectRaw('substring(post_date, 1, 7) AS year_and_month')
            ->groupBy('year_and_month')
            ->orderBy('year_and_month', 'desc')
            ->get();

        foreach ($month_list as $value) {
            list($year, $month) = explode('-', $value->year_and_month);
            $value->year  = $year;
            $value->month = (int)$month;
            $value->year_month = sprintf("%04d年%02d月", $year, $month);
        }
        
        return $month_list;
    }
    
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
