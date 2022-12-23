<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends BaseModel
{    
    use SoftDeletes;
    protected $fillable = [
        'title', 'details','deleted_at'
    ];
}
