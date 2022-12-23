<?php 
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BaseModel extends Model
{

    public static function boot()
    {
        parent::boot();

        static::creating(function($model)
       {
             $userid = (!Auth::guest()) ? Auth::user()->id : null ;
             //$model->created_by = $userid;
             //$model->updated_by = $userid;
        });

        static::updating(function($model)
        {
            $userid = (!Auth::guest()) ? Auth::user()->id : null ;
            //$model->updated_by = $userid;
            $model->updated_at = date('Y-m-d H:i:s');;
        });
    }
}

?>