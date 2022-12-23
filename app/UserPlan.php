<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPlan extends BaseModel
{
  
    use SoftDeletes;  

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'plan_id','purchased_at','qty', 'credit_tabs','credit_articals','debit_articals','debit_tabs','used','expired','invoice_payment_id','invoice_id','created_at','updated_at','deleted_at'
    ];
}
