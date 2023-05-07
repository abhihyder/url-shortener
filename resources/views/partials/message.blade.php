@if(session()->has('message'))
<div class="row">
    <div class="col-12">
        <div class="alert alert-danger mt-1 alert-validation-msg" role="alert">
            <div class="alert-body">
                <i data-feather="info" class="mr-50 align-middle"></i>
                <span>{{session()->get('message')}}</span>
            </div>
        </div>
    </div>
</div>
@endif