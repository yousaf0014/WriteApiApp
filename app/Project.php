<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends BaseModel
{    
    use SoftDeletes;
    protected $fillable = [
        'title', 'details','url','user_id','pic','deleted_at'
    ];

    public function keywords(){
        return $this->hasMany('\App\Keyword');
    }
    
    public function categories(){
        return $this->hasMany('\App\Category');
    }

    public function articals(){
        return $this->hasMany('\App\Artical');
    }
}
