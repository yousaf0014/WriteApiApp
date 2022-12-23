<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends BaseModel
{    
    use SoftDeletes; 
    protected $fillable = [
        'category','user_id','project_id'
    ];

    public function project(){
        return $this->belongsTo('\App\Project');
    }

    public function articals()
    {
    	return $this->belongsToMany('\App\Artical','artical_categories');
    }
}
