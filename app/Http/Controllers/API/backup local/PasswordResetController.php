<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\User;
use App\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;

class PasswordResetController extends BaseController 
{
    /**
     * Create token password reset
     *
     * @param  [string] email
     * @return [string] message
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
             'email' => 'required|string|email',
             'mobile_key'=> ["required" , "max:44","min:44"]
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $str = $request->mobile_key;
        $const = "yYgIvy8fK127X9GpSlepkuJmy7c7f7rB7p7Tn08lGzo0";
        if(strcmp($str, $const) !== 0 ){
            return $this->sendError('Validation Error.', array('mobile_key'=>'The selected mobile key is invalid.'));
        }

        $user = User::where('email', $request->email)->first(); 
        if(!$user){
            return $this->sendError('User Not found',['error'=>'User Not found'] );
        }

        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => Str::random(8)
             ]
        );
        if ($user && $passwordReset){
            $user->notify(
                new PasswordResetRequest($passwordReset->token)
            ); 
        }
        return response()->json([
            'message' => 'We have emailed your password reset code!'
        ]);
    }    

    function __userfields($user){
        $userArr['id'] = $user->id;
        $userArr['first_name'] = $user->first_name; 
        $userArr['last_name'] = $user->last_name; 
        $userArr['email'] = $user->email; 
        $userArr['pic'] = $user->pic; 
        $userArr['is_paid'] = $user->is_paid;
        $userArr['trial_period'] = $user->trial_period;
        $userArr['verified'] = !empty($user->email_verified_at) ? ture:false;
        return $userArr;
    }

    /**
    
     * Find token password reset
     *
     * @param  [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */
    public function find(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'mobile_key'=> ["required" , "max:44","min:44"],
            'email' => 'required|string|email',
            'token' => 'required|min:8|max:8'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $str = $request->mobile_key;
        $const = "yYgIvy8fK127X9GpSlepkuJmy7c7f7rB7p7Tn08lGzo0";
        if(strcmp($str, $const) !== 0 ){
            return $this->sendError('Validation Error.', array('mobile_key'=>'The selected mobile key is invalid.'));
        }
        $passwordReset = PasswordReset::where('token', $request->token)->where('email',$request->email)->first();
        if (!$passwordReset){
            return $this->sendError('Invalid Token',[ 'message' => 'This password reset token is invalid.'] );
        }
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return $this->sendError('Invalid Token',[ 'message' => 'This password reset token is invalid.'] );
        }
        $user = User::where('email',$passwordReset->email)->first();
        $success = $this->__userfields($user);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        return $this->sendResponse($success, 'User Found');

    }     /**
     * Reset password
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [string] token
     * @return [string] message
     * @return [json] user object
     */
    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $user = Auth::user();
        $user->notify(new PasswordResetSuccess());
        $user->password = bcrypt($request->password);
        $success['message'] = 'Password updated successfully.';
        return $this->sendResponse($success, 200);
    }
}