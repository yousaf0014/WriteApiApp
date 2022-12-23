<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Events\Verified;
use Validator;
use App\User;
use App\UserSession;
use App\Notification;
use App\UserPlan;
use App\Plan;
use Illuminate\Validation\Rule;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use DB;

class UserController extends BaseController 
{
    use VerifiesEmails;
    

    public function apiBasePath(){
        $path = '/home/turboanchor/domains/writemeai.turboanchor.com/public_html/uploads';
        return response()->json(['success' => array('path'=>$path)], 200);
    }
    public function sendPasswordRestEmail(Request $request)
    {
        $rules = array(
            'security'=> ["required" , "max:44","min:44"],
            'email' => 'required|email'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {            
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $str = $request->security;
        $const = "yYg)Oy8fK127X9GpSlepkuJmy7c7f7rB7p7Tn08lGzo0";
        if(strcmp($str, $const) !== 0 ){
            return $this->sendError('Validation Error.', array('security'=>'The selected mobile key is invalid.'));
        }

        $user = User::where('email', '=', $request->email)->first();//Check if the user exists
        if (empty($user->id)) {
            return $this->sendError('Validation Error.', array('Email'=>'Email does not exist'));
        }


        DB::table('password_resets')->where('email',$request->email)->delete();
        //Create Password Reset Token
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => Str::random(60)
        ]);//Get the token just created above
        $tokenData = DB::table('password_resets')
            ->where('email', $request->email)->first();


        $user->sendResetEmail($tokenData->token);
        $success['message'] =  'please check your email';
        return $this->sendResponse($success, 200);
        
    }

    public function updatePassword(Request $request){    
        $rules = array(
            'security'=> ["required" , "max:44","min:44"],
            'token' => ['required'],
            'email' => ['required'],
            'password' => ['nullable','string', 'min:8']
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {            
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $str = $request->security;
        $const = "yYg)Oy8fK127X9GpSlepkuJmy7c7f7rB7p7Tn08lGzo0";
        if(strcmp($str, $const) !== 0 ){
            return $this->sendError('Validation Error.', array('security'=>'The selected mobile key is invalid.'));
        }
        $user = User::where('email', '=', $request->email)->first();
        if (empty($user->id)) {
            return $this->sendError('Validation Error.', array('Email'=>'Email does not exist'));
        }

        $userPasswordRest = DB::table('password_resets')->where('email', '=', $request->email)->where('token',$request->token)->first();
        if (empty($userPasswordRest->email)) {
            return $this->sendError('Validation Error.', array('Token'=>'Invalid token provided'));
        }     
        $data = $request->all();                    
        $user->password = bcrypt($request->password);
        $user->save();
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user(); 
            $success = $this->__userfields($user);
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            return $this->sendResponse($success, 'User login successfully.');
        }
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
        
    }

    public function login(Request $request)
    {
        $user2 = User::where('email',$request->email)->withTrashed()->first();
        if(!empty($user2) && !empty($user2->deleted_at)){
            return $this->sendError('Validation Error.', array('email'=>'Your account is locked. Please contact support to get it unlocked.'));
        }

        $validator = Validator::make($request->all(), [
            'security'=> ["required" , "max:44","min:44"],
            'email' => 'required',
            'password' => 'required',            
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $str = $request->security;
        $const = "yYg)Oy8fK127X9GpSlepkuJmy7c7f7rB7p7Tn08lGzo0";
        if(strcmp($str, $const) !== 0 ){
            return $this->sendError('Validation Error.', array('security'=>'The selected mobile key is invalid.'));
        }
        
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user(); 
            $success = $this->__userfields($user);
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            return $this->sendResponse($success, 'User login successfully.');
        }
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    /** 
     * Register api for social
     * 
     * @return \Illuminate\Http\Response 
     */
    public function socailRegister(Request $request)
    {
        $input = $request->all();
        $user2 = User::where('email',$request->email)->withTrashed()->first();
        if(!empty($user2) && !empty($user2->deleted_at)){
            return $this->sendError('Validation Error.', array('email'=>'Your account is locked. Please contact support to get it unlocked.'));
        }

        $user1 = User::where('email',$input['email'])->whereNull('deleted_at')->first();
        if(empty($user1)){
            $validator = Validator::make($request->all(), [
                'first_name' => "required",
                'last_name' => "required",
                'login_type'=> ["required",Rule::in(['google', 'facebook']),],
                'token_for_business' => ['required','unique:users'],
                'profile_pic' => 'nullable',
                'security'=> ["required" , "max:44","min:44"],
                'email' => ['email'],
                'password' =>'nullable'
            ]);

            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());
            }    
        }
        
        $str = $request->security;
        $const = "yYg)Oy8fK127X9GpSlepkuJmy7c7f7rB7p7Tn08lGzo0";
        if(strcmp($str, $const) !== 0 ){
            return $this->sendError('Validation Error.', array('security'=>'The selected mobile key is invalid.'));
        }
        if(empty($user1)){
            $user['token_for_business'] = $input['token_for_business'];
            $user['login_type'] = $input['login_type'];
            $user['email'] = $input['email'];
            $user['first_name'] =  $input['first_name'];
            $user['last_name'] =  $input['last_name'] == 'undefined' ? '':$input['last_name'];
            $input['last_name'] = $input['last_name'] == 'undefined' ? '':$input['last_name'];
            //$user1 = User::create($user);           
            
            $input['password'] = $input['password'];
            $input['type'] = 'user';
            $input['verify_code'] = Str::random(8);
            //$input['email_verified_at'] = date('Y-m-d H:i:s');
            $newData['login'] = $input['password'];
            $newData['pass'] = $input['password'];
            $newData['email'] = $input['email'];
            $newData['name_f'] = $input['first_name'];
            $newData['name_l'] = $input['last_name'] == 'undefined' ? $input['first_name']:$input['last_name'];
            $newData['_format'] = 'json';

            $returnData = sendApiRequest('POST','api/users',$newData);
            $usersData = json_decode($returnData,true);
            if(!empty($usersData[0]['user_id'])){
                $input['amember_id'] = $usersData[0]['user_id'];

                $accessData['user_id'] = $usersData[0]['user_id'];
                $accessData['product_id'] = 2;
                $accessData['begin_date'] = date('Y-m-d');
                $accessData['expire_date'] = date('Y-m-d',strtotime('+1 month'));
                $accessResponse = sendApiRequest('POST','api/access',$accessData);


                //$input['pic'] = $input['profile_pic'];
                $info = pathinfo($input['profile_pic']);
                $contents = @file_get_contents($input['profile_pic']);
                $file = '/tmp/' . $info['basename'];
                file_put_contents($file, $contents);
                $uploaded_file = new UploadedFile($file, $info['basename']);
                $destinationPath = 'uploads';
                $uploaded_file->store($destinationPath, ['disk' => 'public']);
                $input['pic'] = $uploaded_file->hashName();

                $user = User::create($input);
                $user->sendApiEmailVerificationNotification();
                $success = $this->__userfields($user);
                $success['token'] =  $user->createToken('MyApp')->accessToken;
                $success['message'] = 'Signup Successfully';
                return $this->sendResponse($success, 200);
            }else{
                $success['message'] = $usersData['message'];
                return $this->sendResponse($success, 200);
            }
        }
        $success = $this->__userfields($user1);
        $success['token'] =  $user1->createToken('MyApp')->accessToken;
        $success['message'] = 'User login successfully.';
        return $this->sendResponse($success, 200);
        
    }

    function userData(User $user){
        $success = $this->__userfields($user);
        return $this->sendResponse($success, 200);
    }
    
    function __userfields($user){
        $subscription = sendApiRequest('GET','api/check-access/by-email',array('email'=>$user->email)); 
        $subscriptionData = json_decode($subscription,true);    
        $userArr['id'] = $user->id;
        $userArr['first_name'] = $user->first_name; 
        $userArr['last_name'] = $user->last_name; 
        $userArr['email'] = $user->email;
        $userArr['pic'] = $user->pic; 
        $userArr['verified'] = !empty($user->email_verified_at) ? true:false;
        $userArr['login_type'] = $user->login_type;
        if(!empty($subscriptionData['subscriptions'])){
            foreach($subscriptionData['subscriptions'] as $product=>$date){
                $userArr['subscription_expire'][$product] = YMD2MDY($date);
            }
        }
        return $userArr;
    }


	public function registerAppSumo(Request $request)
    {
        $user2 = User::where('email',$request->email)->withTrashed()->first();
        if(!empty($user2) && !empty($user2->deleted_at)){
            return $this->sendError('Validation Error.', array('email'=>'Your account is locked. Please contact support to get it unlocked.'));
        }

        $validator = Validator::make($request->all(), [
            'security'=> ["required" , "max:44","min:44"],
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users|string',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'login' => 'required|unique:users|string|min:6|max:255'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $str = $request->security;
        $const = "yYg)Oy8fK127X9GpSlepkuJmy7c7f7rB7p7Tn08lGzo0";
        if(strcmp($str, $const) !== 0 ){
            return $this->sendError('Validation Error.', array('security'=>'The selected security key is invalid.'));
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['type'] = 'user';
        $input['verify_code'] = Str::random(8);
        $newData['login'] = $input['login'];
        $newData['pass'] = $request->password;
        $newData['email'] = $input['email'];
        $newData['name_f'] = $input['first_name'];
        $newData['name_l'] = $input['last_name'];
        $newData['_format'] = 'json';

        $returnData = sendApiRequest('POST','api/users',$newData);
        $usersData = json_decode($returnData,true);
        if(!empty($usersData[0]['user_id'])){
            $input['amember_id'] = $usersData[0]['user_id'];

            $accessData['user_id'] = $usersData[0]['user_id'];
            $accessData['product_id'] = 13;
            $accessData['begin_date'] = date('Y-m-d');
            $accessData['expire_date'] = date('Y-m-d',strtotime('+1 month'));
            $accessResponse = sendApiRequest('POST','api/access',$accessData);

            $input['pic'] = 'default.png';
            $user = User::create($input);
            $user->sendApiEmailVerificationNotification();
            $success = $this->__userfields($user);
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['message'] = 'Please confirm yourself by clicking on verify user button sent to you on your email';
            return $this->sendResponse($success, 200);
        }else{
            $success['message'] = $usersData['message'];
            return $this->sendResponse($success, 200);
        }
    }

    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request)
    {
        $user2 = User::where('email',$request->email)->withTrashed()->first();
        if(!empty($user2) && !empty($user2->deleted_at)){
            return $this->sendError('Validation Error.', array('email'=>'Your account is locked. Please contact support to get it unlocked.'));
        }

        $validator = Validator::make($request->all(), [
            'security'=> ["required" , "max:44","min:44"],
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users|string',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'login' => 'required|unique:users|string|min:6|max:255'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $str = $request->security;
        $const = "yYg)Oy8fK127X9GpSlepkuJmy7c7f7rB7p7Tn08lGzo0";
        if(strcmp($str, $const) !== 0 ){
            return $this->sendError('Validation Error.', array('security'=>'The selected security key is invalid.'));
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['type'] = 'user';
        $input['verify_code'] = Str::random(8);
        $newData['login'] = $input['login'];
        $newData['pass'] = $request->password;
        $newData['email'] = $input['email'];
        $newData['name_f'] = $input['first_name'];
        $newData['name_l'] = $input['last_name'];
        $newData['_format'] = 'json';

        $returnData = sendApiRequest('POST','api/users',$newData);
        $usersData = json_decode($returnData,true);
        if(!empty($usersData[0]['user_id'])){
            $input['amember_id'] = $usersData[0]['user_id'];

            $accessData['user_id'] = $usersData[0]['user_id'];
            $accessData['product_id'] = 2;
            $accessData['begin_date'] = date('Y-m-d');
            $accessData['expire_date'] = date('Y-m-d',strtotime('+1 month'));
            $accessResponse = sendApiRequest('POST','api/access',$accessData);

            $input['pic'] = 'default.png';
            $user = User::create($input);
            $user->sendApiEmailVerificationNotification();
            $success = $this->__userfields($user);
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['message'] = 'Please confirm yourself by clicking on verify user button sent to you on your email';
            return $this->sendResponse($success, 200);
        }else{
            $success['message'] = $usersData['message'];
            return $this->sendResponse($success, 200);
        }
    }

        /** 
     * Update Email api 
     * 
     * @return \Illuminate\Http\Response 
    **/ 
    public function registerEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users|string'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $user = Auth::user();
        $user->email = $request->email;
        $user->verify_code = Str::random(8);
        $user->sendApiEmailVerificationNotification();
        $success = $this->__userfields($user);
        $success['message'] = 'Please confirm yourself by clicking on verify user button sent to you on your email';
        return $this->sendResponse($success, 200);
    }
    

    /** 
     * pic api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function profile_pic() 
    { 
        $validator = Validator::make($request->all(), [
            'pic' => 'required|image|size:2000',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $user = Auth::user(); 
        $file = $request->file('pic');
        $fileName = $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();
        $path = $file->getRealPath();
        //$file->getSize();
        //$file->getMimeType();
        //Move Uploaded File
        $destinationPath = 'uploads';
        $file->store($destinationPath, ['disk' => 'public']);
        $user->pic = $file->hashName();
        $user->save();
        return response()->json(['success' => $user], 200); 
    }

    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], 200); 
    }


    public function verify(Request $request) {
        $user = Auth::user();
        if($user->verify_code == $request->code){
            $date = date("Y-m-d g:i:s");
            $user->email_verified_at = $date;
            $user->save();

            $planObj = Plan::where('plan_id',2)->first();
            $userPlan = new UserPlan;
            $userPlan->user_id = $user->id;
            $userPlan->plan_id = $planObj->id;
            $userPlan->qty =  1;
            $userPlan->purchased_at = date('Y-m-d H:i:s');
            $userPlan->credit_tabs = $planObj->tab;
            $userPlan->credit_articals = $planObj->artical;
            $userPlan->invoice_payment_id = 1;
            $userPlan->invoice_id = 1;
            $userPlan->save();

            return response()->json(['success' => array('message'=>'Email verified!')], 200);    
        }
        return $this->sendError('Invalid.', ['error'=>'Invalid Code']);       
    }
	

	public function verifyAppSumo(Request $request) {
        $user = Auth::user();
        if($user->verify_code == $request->code){
            $date = date("Y-m-d g:i:s");
            $user->email_verified_at = $date;
            $user->save();

            $planObj = Plan::where('plan_id',13)->first();
            $userPlan = new UserPlan;
            $userPlan->user_id = $user->id;
            $userPlan->plan_id = $planObj->id;
            $userPlan->qty =  1;
            $userPlan->purchased_at = date('Y-m-d H:i:s');
            $userPlan->credit_tabs = $planObj->tab;
            $userPlan->credit_articals = $planObj->artical;
            $userPlan->invoice_payment_id = 1;
            $userPlan->invoice_id = 1;
            $userPlan->save();

            return response()->json(['success' => array('message'=>'Email verified!')], 200);    
        }
        return $this->sendError('Invalid.', ['error'=>'Invalid Code']);       
    }

    public function bio(User $user){
        $userArr['id'] = $user->id;
        $userArr['first_name'] = $user->first_name; 
        $userArr['last_name'] = $user->last_name; 
        $userArr['email'] = $user->email; 
        $userArr['pic'] = $user->pic;
        $userArr['bio'] = $user->bio;
        $followingCount = $user->guideFollower()->groupBy('user_id')->count('user_id');
        $userArr['follow_count'] = $followingCount;
        return response()->json(['success' => $userArr], 200); 
    }

    public function changePassword(Request $request){    
        $rules = array(
            'password' => ['required','string', 'min:8'],
            'c_password' => 'required|same:password',
            'old_password' => ['required','string', 'min:8']
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {            
            return $this->sendError('Validation Error.', $validator->errors());
        }
        
        $user = Auth::user();
        if (!Hash::check($request->old_password, $user->password)){
            return $this->sendError('Validation Error.', array('old_password'=>'Invalid old password'));
        }

        $newData['_method'] = 'PUT';
        $newData['pass'] = $request->password;
        $returnData = sendApiRequest('POST','api/users/'.$user->amember_id,$newData);        
        $user->password = bcrypt($request->password);
        $user->save();


        $success = $this->__userfields($user);
        return $this->sendResponse($success, 'Password changed successfully.');
    }

    public function uploadUserImage(Request $request)
    {
        $user = Auth::user();
        $file = $request->file('pic');
        $destinationPath = 'uploads';
        $file->store($destinationPath, ['disk' => 'public']);
        $user->pic = $file->hashName();
        $user->save();
        $success = $this->__userfields($user);
        return $this->sendResponse($success, 'Pic uploaded successfully.');
    }

    public function payment(Request $request){
        $data['payment'] = $request->payment;
        $data['invoice'] =  $request->invoice;
        $data['items'] = $request->items;
    
        $user = User::where('amember_id',$request->payment['user_id'])->first();
        $notification  = new Notification;
        $notification->title = 'Payment Confirmation';
        $detaials  = '';
        $qty = 1;
        foreach($request->items as $item){
            $qty = $item['qty'] *1;
            $detaials  .= 'You have paid for the package '.$item['item_title']. ', package quantity: '.$item['qty'].', and amount: '.$item['price'];
        }
        $detaials .= ', dated: '.date('M,d Y H:i',strtotime($request->payment['dattm']));
        $notification->details = $detaials;
        $notification->user_id = $user->id;
        $notif = $notification->save();

        $planObj = Plan::where('plan_id',$request->items[0]['plan_id'])->first();
        $userPlan = new UserPlan;
        $userPlan->user_id = $user->id;
        $userPlan->plan_id = $planObj->id;
        $userPlan->qty =  $qty;
        $userPlan->purchased_at = date('Y-m-d H:i:s',strtotime($request->payment['dattm']));
        $userPlan->credit_tabs = $qty*$planObj->tab;
        $userPlan->credit_articals = $qty*$planObj->artical;
        $userPlan->invoice_payment_id = $request->payment['invoice_payment_id'];
        $userPlan->invoice_id = $request->payment['invoice_id'];
        $userPlan->save();
        return response()->json(['success' => 'data successfully received'], 200); 
    }
}