<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Plan;
use Auth;

class PlanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {    
        $user = Auth::user();
        if($user->type != 'admin'){
            return back();
        }
        $keyword = '';
        $planObj = new Plan;
        if($request->get('keyword')){
            $keyword = $request->get('keyword');
            $planObj = $planObj->Where('name', 'like', '%'.$keyword.'%');
        }
        $plans = $planObj->paginate(20);
        return view('Plans.index',compact('plans','keyword'));
    }
    
    public function refresh()
    {
        $user = Auth::user();
        if($user->type != 'admin'){
            return back();
        }
        $plansData = sendApiRequest('GET','api/products',array());
        $plans = json_decode($plansData,true);
        unset($plans['_total']);
        foreach($plans as $plan){
            $thisPlans = Plan::where('plan_id',$plan['product_id'])->first();
            if(!empty($thisPlans)){
                $thisPlans->name = $plan['title'];
                $thisPlans->active = $plan['is_disabled'] == 1? 0:1;
                $thisPlans->save();
            }else{
                $newPlan = new Plan;
                $newPlan->plan_id = $plan['product_id'];
                $newPlan->name = $plan['title'];
                $newPlan->active = $plan['is_disabled'] == 1? 0:1;
                $newPlan->save();
            }
        }
        return back();
    }

    public function edit(Plan $plan){ 
        $user = Auth::user();
        if($user->type != 'admin'){
            return back();
        }
        return View('Plans.edit',compact('plan'));
    }

    public function update(Request $request,Plan $plan){
        $user = Auth::user();
        if($user->type != 'admin'){
            return back();
        }
        $rules = array(
            'tab'       => 'required',
            'artical'   =>'required'
        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()->withInput($request->all())->withErrors($validator);
        } 
        
        $plan->tab = $request->tab;
        $plan->artical = $request->artical;
        $plan->save();

        flash('Successfully updated Plan!','success');
        return redirect('/plans');
    }
}
