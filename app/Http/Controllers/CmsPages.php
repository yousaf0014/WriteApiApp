<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Page;
use Auth;

class CmsPagesController extends Controller
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
        $keyword = '';
        $pageObj = new Page;
        if($request->get('keyword')){
            $keyword = $request->get('keyword');
            $pageObj = $pageObj->Where('name', 'like', '%'.$keyword.'%');
        }
        $pages = $pageObj->paginate(20);
        return view('Pages.index',compact('pages','keyword'));
    }


    public function create(){
        return View('Pages.create');
    }

    
    public function store(Request $request){
        $rules = array(
            'name'       => 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()->withInput($request->all())->withErrors($validator);
        } 
        
        $pageObj = new Page;
        $data = $request->all();
        $pageObj->create($data);
        flash('Successfully Saved.','success');
        return redirect('/pages');
        
    }

    public function show(Page $page){
        return View('Pages.show',compact('page'));   
    }

    public function edit(Page $page){ 
        return View('Pages.edit',compact('page'));
    }

    public function update(Request $request,Page $page){
        $rules = array(
            'name'       => 'required'
        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()->withInput($request->all())->withErrors($validator);
        } 
        
        //$questionnaireObj = new Questionnaire;
        $data = $request->all();
        $page->update($data);

        flash('Successfully updated Page!','success');
        return redirect('/pages');
    
    }

    public function delete(Page $page){
        $page->delete();
        flash('Successfully deleted the Page!','success');
        return redirect('/pages');
    }    
}
