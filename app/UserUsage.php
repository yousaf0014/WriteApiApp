<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class UserUsage extends BaseModel
{
  	
  	protected $table = 'user_usage';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tab', 'artical','plan_id','user_plan_id','plan_name'
    ];

    public function user(){
        return $this->belongsTo('\App\User');
    }
}
