<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Page extends Model
{
    
    protected $fillable = [
        'name','slug','details'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function($model) {
            $slug = str_replace(' ','-',strtolower($model->name));
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $model->slug = $count ? "{$slug}-{$count}" : $slug;
        });
    }

}
