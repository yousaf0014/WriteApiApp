<?php
namespace App;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Notifications\ValidEmail;
use App\Notifications\RestPassword;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name','email', 'password','login','amember_id','type','verify_code','pic','last_artical_id','token_for_business','login_type','deleted_at','api_token'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendApiEmailVerificationNotification()
    {
        $response = $this->notify(new ValidEmail($this)); // my notification
    }

    public function sendResetEmail($token){
        $response = $this->notify(new RestPassword($this,$token)); 
    }

    public function downloadArticals(){
        return $this->belongsToMany('\App\Artical','user_downloads')->withPivot('type')->withPivot('created_at');
    }

    public function usage(){
        return $this->hasMany('\App\UserUsage');
    }
}