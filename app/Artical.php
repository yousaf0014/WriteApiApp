<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Artical extends BaseModel
{
    use SoftDeletes;     
    protected $fillable = [
        'artical','user_id','project_id','title','coherence','creativity','copies','is_processing','pending','size','reference_text','type','sample_paragraph','line1','line2','line3','line4','line5'
    ];

    public function project(){
        return $this->belongsTo('\App\Project');
    }


    public function keywords(){
        return $this->belongsToMany('\App\Keyword','artical_keywords');
    }

    public function categories(){
        return $this->belongsToMany('\App\Category','artical_categories');
    }
}