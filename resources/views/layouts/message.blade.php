@if(Session::has('success'))
    <div class="row">
        <div class="col-md-12 text-center">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check"></i>
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <strong>Success! </strong> {{Session::get("success")}}
            </div>
        </div>
    </div>

@elseif(Session::has('error'))
    <div class="row">
        <div class="col-md-12 text-center">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa fa-exclamation-circle"></i>
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <strong>Alert ! </strong> {{Session::get("error")}}
            </div>
        </div>
    </div>
@endif
