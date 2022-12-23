<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;
use DB;
use App\User;
use App\UserSession;
use App\Project;
use App\Keyword;
use App\Artical;
use App\Category;
use App\Notification;
use App\UserPlan;
use App\UserUsage;
use App\Plan;

class UserDataController extends BaseController 
{
    public function getProjects(Request $request){
        $projects = Project::where('user_id',Auth::user()->id)->get();
        return response()->json(['success' => array('projects'=>$projects)], 200);   
    }
    public function saveProject(Request $request){
        $validator = Validator::make($request->all(),[
            'title'=> "required",
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $user = Auth::user();
        $projectObj = new Project;
        $projectObj->user_id = $user->id;
        $projectObj->title = !empty($request->title) ? $request->title:'';
        $projectObj->details = !empty($request->details) ? $request->details:'';
        $projectObj->url = !empty($request->url) ? $request->url:'';
        $projectObj->pic = !empty($request->pic)? $request->pic:null; 
        $projectObj->save();
        $projects = Project::where('user_id',Auth::user()->id)->get();

        $keywords = !empty($request->keywords) ? $request->keywords:array();
        foreach($keywords as $keyword){
            $keywordObj = new Keyword;
            $keywordObj->user_id = $user->id;
            $keywordObj->keyword = $keyword;
            $projectObj->keywords()->save($keywordObj);
        }

        $categories = !empty($request->categories) ? $request->categories:array();
        foreach($categories as $cate){
            $categoryObj = new Category;
            $categoryObj->user_id = $user->id;
            $categoryObj->title = $cate;
            $projectObj->categories()->save($categoryObj);
        }

        return response()->json(['success' => array('message'=>'Project saved successfully','projects'=>$projects)], 200);
    }

    public function updateProject(Request $request,Project $project){
        $user = Auth::user();
        $validator = Validator::make($request->all(),[
            'title'=> "required",
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $project->title = !empty($request->title) ? $request->title:'';
        $project->details = !empty($request->details) ? $request->details:'';
        $project->url = $request->url;
        //$project->pic = !empty($request->pic)? $request->pic:null;
        $project->save();

        //$project->keywords()->delete();
        //$project->categories()->delete();

        $keywords = !empty($request->keywords) ? $request->keywords:array();
        foreach($keywords as $keyword){
            $keywordObj = new Keyword;
            $keywordObj->user_id = $user->id;
            $keywordObj->keyword = $keyword;
            $project->keywords()->save($keywordObj);
        }

        $categories = !empty($request->categories) ? $request->categories:array();
        foreach($categories as $cate){
            $categoryObj = new Category;
            $categoryObj->user_id = $user->id;
            $categoryObj->title = $cate;
            $project->categories()->save($categoryObj);
        }
        
        $projects = Project::where('user_id',Auth::user()->id)->get();
        return response()->json(['success' => array('message'=>'Project updated successfully','projects'=>$projects)], 200);
    }

    public function deleteProject(Request $request,Project $project){
        $user = Auth::user();
        if($user->id != $project->user_id){
            return response()->json(['error' => array('message'=>'Not Allowed to delete this project')], 200);   
        }
        $project->delete();
        $aritcal = Artical::where('id',$user->last_artical_id)->first();
        if(!empty($aritcal->id) && $aritcal->project_id  == $project->id){
            $user->last_artical_id = null;
            $user->save();
        }
        $projects = Project::where('user_id',Auth::user()->id)->get();
        return response()->json(['success' => array('message'=>'Scuccessfully deleted','projects'=>$projects)], 200);   
    }
    public function getProject(Request $request,Project $project){
        return response()->json(['success' => array('project'=>$project)], 200);   
    }




    ///////Project End ////////

    /// keyword section start here //////

    public function getkeywords(Request $request,Project $project){
        $keywords = $project->keywords()->get();
        return response()->json(['success' => array('keywords'=>$keywords)], 200);   
    }
    public function saveKeywords(Request $request,Project $project){
        $user = Auth::user();
        $keywords = array();
        if(!is_array($request->keyword)){
            $keywords[] = $request->keyword;
        }else{
            $keywords = $request->keyword;
        }
        foreach($keywords as $keyword){
            $keywordObj = new Keyword;
            $keywordObj->user_id = $user->id;
            $keywordObj->keyword = $keyword;
            $project->keywords()->save($keywordObj);
        }
        $keywords = $project->keywords()->get();
        return response()->json(['success' => array('message'=>'Keyword saved successfully','keywrod'=>$keywords)], 200);
    }

    public function updateKeyword(Request $request,Project $project,Keyword $keyword){
        $user = Auth::user();
        $validator = Validator::make($request->all(),[
            'keyword'=> "required",
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $keyword->keyword = $request->keyword;
        $keyword->save();
        $keywords = $project->keywords()->get();
        return response()->json(['success' => array('message'=>'Keyword updated successfully','keywords'=>$keywords)], 200);
    }

    public function deleteKeyword(Request $request,Project $project,Keyword $keyword){        
        $keyword->articals()->detach();
        $project->keywords()->where('id',$keyword->id)->delete();
        $keywords = $project->keywords()->get();
        return response()->json(['success' => array('message'=>'Scuccessfully deleted','keywords'=>$keywords)], 200);   
    }
    public function getKeyword(Request $request,Keyword $keyword){
        return response()->json(['success' => array('keyword'=>$keyword)], 200);   
    }


     ///////kEYWORD End ////////


    /// Categories section start here //////

    public function getCategories(Request $request,Project $project){
        $categories = $project->categories()->get();
        return response()->json(['success' => array('categories'=>$categories)], 200);   
    }

    public function savecategories(Request $request,Project $project){
        $user = Auth::user();
        $categories = array();
        if(!is_array($request->categories)){
            $categroies[] = $request->categories;
        }else{
            $categories = $request->categories;
        }
        foreach($categories as $cate){
            $categoryObj = new Category;
            $categoryObj->user_id = $user->id;
            $categoryObj->title = $cate;
            $project->categories()->save($categoryObj);
        }
        $categories = $project->categories()->get();
        return response()->json(['success' => array('message'=>'Category saved successfully','categories'=>$categories)], 200);
    }

    public function updateCategory(Request $request,Project $project,Category $category){
        $user = Auth::user();
        $validator = Validator::make($request->all(),[
            'category'=> "required",
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $category->keyword = $request->category;
        $category->save();
        $categories = $project->categories()->get();
        return response()->json(['success' => array('message'=>'Category updated successfully','categories'=>$categories)], 200);
    }

    public function deleteCategory(Request $request,Project $project,Category $category){
        $category->articals()->detach();
        $project->categories()->where('id',$category->id)->delete();
        $categories = $project->categories()->get();
        return response()->json(['success' => array('message'=>'Scuccessfully deleted','categories'=>$categories)], 200);   
    }
    public function getCategory(Request $request,Category $category){
        return response()->json(['success' => array('category'=>$category)], 200);   
    }


    ///////kEYWORD End ////////


    /// Articals start here//////
   

    public function getArticals(Request $request,Project $project){
        $articals = $project->articals()->with('categories')->get();
        $latest = $project->articals()->orderByDesc('updated_at')->limit(5)->with('categories')->get();
        return response()->json(['success' => array('latest'=>$latest,'all'=>$articals)], 200);   
    }
    public function newartical(Request $request,Project $project, Artical $artical){
        $user = Auth::user();
        $validator = Validator::make($request->all(),[
            'text'=>'required',
            'temp'=> "required",
            'size' =>"required|int",
            'k' =>'required|int',
            'n' => 'required|int'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $allowed = $this->__getAllowed();
        if($allowed == false){
            return response()->json(['error' => array('text'=>'You do not have credit for articals')], 200);
        }
        //$artical = new Artical;
        $artical->user_id = $user->id;
        //$artical->title = !empty($request->title) ? $request->title:'';
        $artical->reference_text = $request->text;
        $artical->coherence = !empty($request->temp) ? $request->temp:7;
        $artical->creativity = !empty($request->k) ? $request->k:5;
        $artical->size =  $request->size;
        $artical->copies = !empty($request->n) ? $request->n:1;
        $artical->pending = 1;
        $articalOb = $project->articals()->save($artical);
        $user->last_artical_id = $articalOb->id;
        $user->save();

        /*$user = Auth::user();
        $userUsage = new UserUsage;
        $userPlanObj = new UserPlan;
        $userPlanObj = $userPlanObj->where('user_id', $user->id)->where('used',0)->where('expired',0)->select('user_id','debit_tabs','debit_articals',DB::raw('sum(credit_tabs) - sum(debit_tabs) as tabs_total'),DB::raw('sum(credit_articals) - sum(debit_articals) as articals_total'),'id','plan_id');
      
        $userUsage->artical = 1;
        $userPlanObj = $userPlanObj->having('articals_total','>',0);
        $plans = $userPlanObj->first();
        $plans->debit_articals = !empty($plans->debit_articals) ? $plans->debit_articals + 1:1;
        //$plans->save();

        $planDetails = Plan::where('id',$plans->plan_id)->first();
        $userUsage->user_plan_id = $plans->id;
        $userUsage->plan_id = $plans->plan_id;
        $userUsage->plan_name = $planDetails->name;
        $user->usage()->save($userUsage); */

        return response()->json(['success' => array('message'=>'Artical request saved successfully')], 200);
    }
    public function saveArtical(Request $request,Project $project){
        $user = Auth::user();
        $validator = Validator::make($request->all(),[
            'title'=>'required',
            'artical'=> "required"
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $articalObj = new Artical;
        $articalObj->user_id = $user->id;
        $articalObj->title = $request->title;
        $articalObj->artical = $request->artical;
        $articalObj->coherence = !empty($request->coherence) ? $request->coherence:7;
        $articalObj->creativity = !empty($request->creativity) ? $request->creativity:5;
        $articalObj->copies = !empty($request->copies) ? $request->copies:5;
        $articalOb = $project->articals()->save($articalObj);
        $user->last_artical_id = $articalOb->id;
        $user->save(); 
        foreach($request->categories as $category){
            $categoryObj = Category::where('id',$category)->first();
            $articalOb->categories()->attach($categoryObj->id);
        }

        $articals = $articalOb; //$project->articals()->get();
        return response()->json(['success' => array('message'=>'Artical saved successfully','articals'=>$articals)], 200);
    }

    public function updateArtical(Request $request,Project $project,Artical $artical){
        $user = Auth::user();
        $validator = Validator::make($request->all(),[
            'title'=>'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $artical->artical = !empty($request->artical) ? $request->artical:'';
        $artical->title = $request->title;
        $artical->coherence = !empty($request->coherence) ? $request->coherence:7;
        $artical->creativity = !empty($request->creativity) ? $request->creativity:5;
        $artical->copies = !empty($request->copies) ? $request->copies:5;
        $artical->save();
        $user->last_artical_id = $artical->id;
        $user->save();
        $articals = $project->articals()->get();
        return response()->json(['success' => array('message'=>'Artical updated successfully','articals'=>$articals)], 200);
    }

    public function deleteArtical(Request $request,Project $project,Artical $artical){
        $user = Auth::user();
        if($user->id != $artical->user_id){
            return $this->sendError('Access denied.',array('data'=>'Access denied.'));
        }    
        $project->articals()->where('id',$artical->id)->delete();
        
        if($user->last_artical_id == $artical->id){
            $user->last_artical_id = null;
            $user->save();
        }
        $articals = $project->articals()->get();
        return response()->json(['success' => array('message'=>'Scuccessfully deleted','articals'=>$articals)], 200);   
    }
    public function getArtical(Request $request,Artical $artical){
        $keywords = $artical->keywords()->get();
        $categories = $artical->categories()->get();
        return response()->json(['success' => array('artical'=>$artical),'keywords'=>$keywords,'categories'=>$categories], 200);   
    }

    public function articalKeywords(Request $request,Artical $artical)
    {
        $artical->keywords()->detach();
        foreach($request->keywords as $keyword){
            $keywordObj = keyword::where('id',$keyword)->first();
            $artical->keywords()->attach($keywordObj->id);
        }
        return response()->json(['success' => array('sucess'=>'successfull attached')], 200);   
    }

    public function articalCategories(Request $request,Artical $artical)
    {
        $artical->categories()->detach();
        foreach($request->categories as $category){
            $categoryObj = Category::where('id',$category)->first();
            $artical->categories()->attach($categoryObj->id);
        }
        return response()->json(['success' => array('sucess'=>'successfull attached')], 200);   
    }

    public function projectFile(Request $request,Project $project){ $file =
        $request->file('pic'); $destinationPath = 'uploads';
        $file->store($destinationPath, ['disk' => 'public']); 
        $project->pic =  $file->hashName(); 
        $project->save(); //$data['pic'] = $file->hashName();
        return response()->json(['success' =>
            array('filename'=>$file->hashName())], 200);   
        
    }

    public function apiFilePath(Request $request){
        //$path = \Storage::disk('public')->url('uploads/');
        $path = url('/').'/public/storage/uploads/';
        //$data['pic'] = $file->hashName();
        return response()->json(['success' => array('path'=>$path)], 200);
    }

    public function savedownloads(Request $request){
        //downloadArticals
        $validator = Validator::make($request->all(),[
            'artical_id'=>'required',
            'type'=> "required",
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $user = Auth::user();
        $downloads = $user->downloadArticals()->attach($request->artical_id, ['type' => $request->type,'created_at'=>date('y-m-d h:i:s')]);
        return response()->json(['success' => array('sucess'=>'successfull stored')], 200);   
    }

    public function userdownloads(Request $request){
        $user = Auth::user();
        $downloads = $user->downloadArticals()->with('categories')->orderByDesc('created_at')->paginate(20);
        return response()->json(['success' => array('downloads'=>$downloads)], 200);   
    }

    public function lastestCategories(Request $request)
    {
        $user = Auth::user();
        $categories = Category::where('user_id',$user->id)->select(DB::raw('distinct(title) as title'),'id')->groupBy('title')->orderByDesc('id')->limit(10)->get();
        return response()->json(['data' => array('categories'=>$categories)], 200);   
    }

    public function getCurrentArtical(Request $request){
        $lastArticalId = Auth::user()->last_artical_id;
        return response()->json(['data' => array('artical_id'=>$lastArticalId)], 200);   
    }

    public function getNotifications(Request $request){
        $notifications = Notification::where('user_id',Auth::user()->id)->get();
        return response()->json(['success' => array('notifications'=>$notifications)], 200);   
    }

    public function deleteNotification(Request $request,Notification $notification){
        $notification->delete();   
        $notifications = Notification::where('user_id',Auth::user()->id)->get();
        return response()->json(['success' => array('notifications'=>$notifications)], 200);   
    }

    ///// this api need to be updated when finilized the plan //////
    public function balance(Request $request){
        $user = Auth::user();
        $userUsage = new UserUsage;
        $userPlanObj = new UserPlan;
        $userPlanObj = $userPlanObj->where('user_id', $user->id)->where('used',0)->where('expired',0)->select('user_id','debit_tabs','debit_articals',DB::raw('sum(credit_tabs) - sum(debit_tabs) as tabs_total'),DB::raw('sum(credit_articals) - sum(debit_articals) as articals_total'),'id');
      
        if(!empty($request->tabs)){
            $userUsage->tab = 1;
            $userPlanObj = $userPlanObj->having('tabs_total','>',0);
        }else if(!empty($request->articals)){
            $userUsage->artical = 1;
            $userPlanObj = $userPlanObj->having('articals_total','>',0);
        }
        $user->usage()->save($userUsage);
        $plans = $userPlanObj->first();
        if(!empty($request->tabs)){
            $plans->debit_tabs = $plans->debit_tabs - 1;
        }else if(!empty($request->articals)){
            $plans->debit_articals = $plans->debit_articals - 1;
        }
        $plans->save();
    }

    public function getUsage(Request $request)
    {
        $user = Auth::user();
        $userPlanObj = new UserPlan;
        $date = date('Y-m-d 00:00:00',strtotime('-30 days'));
        $userPlanObj->where('purchased_at','<',$date)->where('user_id', $user->id)->update(array('expired'=>1));
        
        $balance = UserPlan::where('user_id', $user->id)->where('used',0)->where('expired',0)
            ->select(DB::raw('sum(credit_tabs) - sum(debit_tabs) as tabs_total'),DB::raw('sum(credit_articals) - sum(debit_articals) as articals_total'),'user_id')
        ->groupBy('user_id')->first();
        $data['articals_total'] = $data['tabs_total'] = 0;
        if(!empty($balance->tabs_total)){
            $data['tabs_total'] = $balance->tabs_total;
        }
        if(!empty($balance->articals_total)){
            $data['articals_total'] = $balance->articals_total;
        }
        $data['tabs'] = $data['tabs_total'] > 0 ? true:false;
        $data['articals'] =  $data['articals_total'] > 0 ? true:false;
        return response()->json(['success' => array('usage'=>$data)], 200);   
    }

    private function __getAllowed($type = 'artical'){
        $user = Auth::user();
        $userPlanObj = new UserPlan;
        $date = date('Y-m-d 00:00:00',strtotime('-30 days'));
        $userPlanObj->where('purchased_at','<',$date)->where('user_id', $user->id)->update(array('expired'=>1));
        
        $balance = UserPlan::where('user_id', $user->id)->where('used',0)->where('expired',0)
            ->select(DB::raw('sum(credit_tabs) - sum(debit_tabs) as tabs_total'),DB::raw('sum(credit_articals) - sum(debit_articals) as articals_total'),'user_id')
        ->groupBy('user_id')->first();
        if($type == 'tab' && $balance->tabs_total < 1){
            return false;
        }else if($type == 'artical' && $balance->articals_total < 1){
            return false;
        }

        $userUsage = new UserUsage;
        $userPlanObj = new UserPlan;
        $userPlanObj = $userPlanObj->where('user_id', $user->id)->where('used',0)->where('expired',0)->select('user_id','debit_tabs','debit_articals',DB::raw('sum(credit_tabs) - sum(debit_tabs) as tabs_total'),DB::raw('sum(credit_articals) - sum(debit_articals) as articals_total'),'id','plan_id');
      
        if($type == 'tab'){
            $userUsage->tab = 1;
            $userPlanObj = $userPlanObj->having('tabs_total','>',0);
        }else{
            $userUsage->artical = 1;
            $userPlanObj = $userPlanObj->having('articals_total','>',0);
        }
        $plans = $userPlanObj->first();

        if($type == 'tab'){
            $plans->debit_tabs = !empty($plans->debit_tabs) ? $plans->debit_tabs + 1:1;
        }else{
            $plans->debit_articals = !empty($plans->debit_articals) ? $plans->debit_articals + 1:1;
        }
        $plans->save();

        $planDetails = Plan::where('id',$plans->plan_id)->first();

        $userUsage->user_plan_id = $plans->id;
        $userUsage->plan_id = $plans->plan_id;
        $userUsage->plan_name = $planDetails->name;
        $user->usage()->save($userUsage);
        return true;
    }
    
    public function aiUsage(Request $request)
    {
        //$type = !empty($request->tab)? 'tab':'artical';
        $tabs = $this->__getAllowed('tab');
        return response()->json(['success' => array('usage'=>$tabs)], 200);
    }

    ///// this api need to be updated when finilized the plan //////
    public function updateUsage1(Request $request)
    {
        if(empty($request->tabs) && empty($request->articals)){
            return response()->json(['error' => array('message'=>'artical or tab usage update not mentioned')], 200); 
        }
        $user = Auth::user();
        $userUsage = new UserUsage;
        $userPlanObj = new UserPlan;
        $userPlanObj = $userPlanObj->where('user_id', $user->id)->where('used',0)->where('expired',0)->select('user_id','debit_tabs','debit_articals',DB::raw('sum(credit_tabs) - sum(debit_tabs) as tabs_total'),DB::raw('sum(credit_articals) - sum(debit_articals) as articals_total'),'id','plan_id');
      
        if(!empty($request->tabs)){
            $userUsage->tab = 1;
            $userPlanObj = $userPlanObj->having('tabs_total','>',0);
        }else if(!empty($request->articals)){
            $userUsage->artical = 1;
            $userPlanObj = $userPlanObj->having('articals_total','>',0);
        }
        $plans = $userPlanObj->first();

        if(!empty($request->tabs)){
            $plans->debit_tabs = !empty($plans->debit_tabs) ? $plans->debit_tabs + 1:1;
        }else if(!empty($request->articals)){
            $plans->debit_articals = !empty($plans->debit_articals) ? $plans->debit_articals + 1:1;
        }
        $plans->save();

        $planDetails = Plan::where('id',$plans->plan_id)->first();

        $userUsage->user_plan_id = $plans->id;
        $userUsage->plan_id = $plans->plan_id;
        $userUsage->plan_name = $planDetails->name;
        $user->usage()->save($userUsage);

        //////////////// return data start from here ///////////////////
        $user = Auth::user();
        $balance = UserPlan::where('user_id', $user->id)->where('used',0)->where('expired',0)
            ->select(DB::raw('sum(credit_tabs) - sum(debit_tabs) as tabs_total'),DB::raw('sum(credit_articals) - sum(debit_articals) as articals_total'),'user_id')
        ->groupBy('user_id')->first();
        $data['articals_total'] = $data['tabs_total'] = 0;
        if(!empty($balance->tabs_total)){
            $data['tabs_total'] = $balance->tabs_total;
        }
        if(!empty($balance->articals_total)){
            $data['articals_total'] = $balance->articals_total;
        }
        $data['tabs'] = $data['tabs_total'] > 0 ? true:false;
        $data['articals'] =  $data['articals_total'] > 0 ? true:false;
        return response()->json(['success' => array('usage'=>$data)], 200);   
    }

    public function updateUsage(Request $request)
    {
        $user = Auth::user();
        $balance = UserPlan::where('user_id', $user->id)->where('used',0)->where('expired',0)
            ->select(DB::raw('sum(credit_tabs) - sum(debit_tabs) as tabs_total'),DB::raw('sum(credit_articals) - sum(debit_articals) as articals_total'),'user_id')
        ->groupBy('user_id')->first();
        $data['articals_total'] = $data['tabs_total'] = 0;
        if(!empty($balance->tabs_total)){
            $data['tabs_total'] = $balance->tabs_total;
        }
        if(!empty($balance->articals_total)){
            $data['articals_total'] = $balance->articals_total;
        }
        $data['tabs'] = $data['tabs_total'] > 0 ? true:false;
        $data['articals'] =  $data['articals_total'] > 0 ? true:false;
        return response()->json(['success' => array('usage'=>$data)], 200);   
    }

    public function getUsageLog(){
        $user = Auth::user();
        $balance = UserPlan::where('user_id', $user->id)->where('used',0)->where('expired',0)
            ->select(DB::raw('sum(credit_tabs) - sum(debit_tabs) as tabs_total'),DB::raw('sum(credit_articals) - sum(debit_articals) as articals_total'),DB::raw('sum(credit_tabs)as month_tabs'),'user_id',DB::raw('sum(credit_articals) as month_articals'))
        ->groupBy('user_id')->first();
        $data['monthLimitTab'] = $data['monthLimitArtical'] = $data['articals_remaining'] = $data['tabs_remaining'] = 0;
        if(!empty($balance->tabs_total)){
            $data['tabs_remaining'] = $balance->tabs_total;
        }
        if(!empty($balance->articals_total)){
            $data['articals_remaining'] = $balance->articals_total;
        }
        if(!empty($balance->month_tabs)){
            $data['monthLimitTab'] = $balance->month_tabs;
        }
        if(!empty($balance->month_articals)){
            $data['monthLimitArtical'] = $balance->month_articals;
        }
        $usage = UserUsage::orderByDesc('id')->select(DB::raw('DATE(created_at) as date'),'plan_name',DB::raw('sum(tab) as tab'),DB::raw('sum(artical) as artical'))->where('user_id',$user->id)->groupBy('date')->groupBy('plan_name')->paginate(200);
        $data['usage'] = $usage; 
        return response()->json(['success' => array('usage_history'=>$data)], 200);   
    }

    public function getpayments(Request $request){
        $newData['_format'] = 'json';
        $returnData = sendApiRequest('GET','api/users',$newData);
        $usersData = json_decode($returnData,true);
        //echo '<pre>';
        return response()->json(['success' => array('usage'=>$usersData)], 200);   
    }

}