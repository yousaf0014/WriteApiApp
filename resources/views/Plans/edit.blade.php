@extends('layouts.admin.app')
@section('content')

<div class="account-content">
    <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
        <div class="row">
            <div class="col-lg-12 col-12  layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">                                
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>Plan</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">
                        <form action="{{url('plans/update/'.$plan->id)}}" method="post" id="edit">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="formGroupExampleInput">Name</label>
                                {{$plan->name}}
                            </div>
                            <div class="form-group mb-4">
                                <label for="formGroupExampleInput">Tab</label>
                                <input type="text" name="tab" value="{{$plan->tab}}" class="form-control input-sm" />
                            </div>
                            <div class="form-group mb-4">
                                <label for="formGroupExampleInput">Artical</label>
                                <input type="text" name="artical" value="{{$plan->artical}}" class="form-control input-sm" />
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Save</button>

                            <a href="{{ url('plans') }}" class="btn btn-danger btn-icon-split">
                                <span class="icon text-white-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left-circle"><circle cx="12" cy="12" r="10"></circle><polyline points="12 8 8 12 12 16"></polyline><line x1="16" y1="12" x2="8" y2="12"></line></svg>
                                </span>
                                <span class="text">Go Back</span>
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
@endsection
@section('scripts')
    <script type="text/javascript" src="{{asset('js/jquery.form.js?v=1')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.validate.min.js?v=1')}}"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        options = {
                rules: {
                    "name": {required:true},
                    "duration": {required:true,digits:true},
                    "resume":{required:true}
                },
                messages: {
                    "name": "Please enter Name",
                    "Duration": {required:"Please enter duration",digits:"Please enter an integer"},
                    "resume":"Please select"
                }
            };
            
            $('#add_questionnaire').validate( options );
    });
    </script>
@endsection