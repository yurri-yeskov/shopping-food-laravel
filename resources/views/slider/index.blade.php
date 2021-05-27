@extends('layouts.leo')
@section('content')
@include('sections.settings')
@include('layouts.message')
<div class="row layout-wrap" id="layout-wrap">
@foreach($sliders as $slider)
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="profile-pic mb-20">
                    <img src="{{URL::asset('uploads/sliders/'.$slider->image)}}"  class="img-thumbnail rounded">
                    <h6 class="mt-10 mb-0">{{$slider->name}}</h6>
                </div>
            </div>
            <div class="p-4 border-top">
                <div class="row text-center">
                    <div class="col-4 border-right">
                        <a href="{{route('slider.edit',$slider->id)}}" class="var-modal link d-flex align-items-center justify-content-center"><i class="ik ik-edit f-20 mr-5"></i>Edit</a>
                    </div>
                    <div class="col-4 border-right">
                        <a href="#" class="link d-flex align-items-center justify-content-center delete" data-slide-id="{{$slider->id}}"><i class="ik ik-trash f-20 mr-5"></i>Delete</a>
                    </div>
                    <div class="col-4">
                        <input type="checkbox" class="js-switch change-slider-status" data-slider-id="{{ $slider->id }}" {{($slider->status=='AC')?'checked':''}} />
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <div class="col-md-3">
        <a href="{{route('slider.create')}}" class="var-modal">
            <div class="widget social-widget">
                <div class="widget-body">
                    <div class="icon"><i class="ik ik-plus-circle text-success"></i></div>
                    <div class="content">
                        <h5 class="mt-10 mb-0">Add New Slider</h5>
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

      $(function() {
            $('body').on('click', '.delete', function(){
                var id = $(this).data('slide-id');
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover the deleted slider!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel please!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, function(isConfirm){
                    if (isConfirm) {
                        var url   = "{{ route('slider.destroy',':id') }}";
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
   

$('.change-slider-status').change(function () {
        var id = $(this).data('slider-id');

        if($(this).is(':checked'))
            var moduleStatus = 'AC';
        else
            var moduleStatus = 'IN';

        var url = '{{route('changeSliderStatus', ':id')}}';
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

</script>
@endpush