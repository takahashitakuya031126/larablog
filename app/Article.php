<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;
    
    protected $primaryKey = 'article_id';
    
    protected $fillable = ['post_date', 'title', 'body'];
    
    protected $dates = ['post_date', 'created_at', 'updated_at', 'deleted_at'];
    
    public function getArticleList(int $num_per_page = 10, array $condition = [])
    {
        $year  = array_get($condition, 'year');
        $month = array_get($condition, 'month');
        
        $query = $this->orderBy('article_id', 'desc');
        
        if ($year) {
            if ($month) {
                $start_date = Carbon::createFromDate($year, $month, 1);
                $end_date   = Carbon::createFromDate($year, $month, 1)->addMonth();     // 1ヶ月後
            } else {
                $start_date = Carbon::createFromDate($year, 1, 1);
                $end_date   = Carbon::createFromDate($year, 1, 1)->addYear();           // 1年後
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
