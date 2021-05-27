@extends('layouts.leo')
@section('content')
@include('sections.settings')
@include('layouts.message')

<div class="row">
@foreach($productunits as $cat)
<div class="col-lg-3 col-md-6 col-sm-12">
    <div class="widget">
        <div class="widget-body">
            <div class="d-flex justify-content-between align-items-center">
                <div class="state">
                    <h6>{{$cat->name}}</h6>
                    <h2>{{$cat->code}}</h2>
                </div>
                <div class="icon">
                    <input type="checkbox" class="js-switch change-unit-status" data-category-id="{{ $cat->id }}" {{($cat->status=='AC')?'checked':''}} />
                </div>
            </div>
            <div class="p-4 border-top">
                <div class="row text-center">
                    <div class="col-6 border-right">
                        <a href="{{route('units.edit',$cat->id)}}" class="var-modal link d-flex align-items-center justify-content-center"><i class="ik ik-edit f-20 mr-5"></i>Edit</a>
                    </div>
                    <div class="col-6">
                        <a href="#" class="delete link d-flex align-items-center justify-content-center"  data-var-id="{{ $cat->id }}"><i class="ik ik-trash f-20 mr-5"></i>Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
<div class="col-lg-3 col-md-6 col-sm-12">
    <a href="{{route('units.create')}}" class="var-modal">
    <div class="widget bg-success">
        <div class="widget-body">
            <div class="d-flex justify-content-between align-items-center">
                <div class="state">
                    <h6>Add New Unit</h6>
                </div>
                <div class="icon">
                    <i class="ik ik-plus-circle"></i>
                </div>
            </div>
        </div>
    </div>
    </a>
</div>
</div>
<div class="modal fade text-center" id="theModal">
  <div class="modal-dialog">
    <div class="modal-content">
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
    var elem = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
    elem.forEach(function(html) {
        var switchery = new Switchery(html, {
            color: '#2ed8b6',
            jackColor: '#fff',
            size: 'small'
        });
    });
    });

    
$('.change-unit-status').change(function () {
        var id = $(this).data('category-id');

        if($(this).is(':checked'))
            var moduleStatus = 'AC';
        else
            var moduleStatus = 'IN';

        var url = '{{route('changeUnitStatus', ':id')}}';
        url = url.replace(':id', id);
        $.easyAjax({
            url: url,
            type: "POST",
            data: { 'id': id, 'status': moduleStatus, '_method': 'POST', '_token': '{{ csrf_token() }}' }
        })
    });    

    $('.var-modal').on('click', function(e){
      e.preventDefault();
      $('#theModal').modal('show').find('.modal-content').load($(this).attr('href'));
    });
        $(function() {
            $('body').on('click', '.delete', function(){
                var id = $(this).data('var-id');
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover the deleted unit!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel please!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, function(isConfirm){
                    if (isConfirm) {
                        var url   = "{{ route('units.destroy',':id') }}";
                        url       = url.replace(':id', id);
                        var token = "{{ csrf_token() }}";
                        $.easyAjax({
                            type: 'POST',
                            url: url,
                            data: {'_token': token, '_method': 'DELETE'},
                            success: function (response) {
                                if (response.status == "success") {
                                        window.location.reload();
                                }
                            }
                        });

                    }
                });
            });
        });
   

</script>
@endpush