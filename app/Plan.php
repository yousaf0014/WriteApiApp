<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Plan extends BaseModel
{    
    protected $fillable = [
        'tab','artical', 'plan_id','name','active'
    ];
}
