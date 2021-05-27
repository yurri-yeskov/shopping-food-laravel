@extends('layouts.leo')
@section('content')
@include('sections.settings')
@include('layouts.message')
<span class=" float-right">
                <a href="{{route('faq.create')}}" class="var-modal btn btn-success float-right btn-xs">New Faq</a>
            </span>
<div class="card">
            <table class="table" id="leo">
        <thead>
            <tr>
                <th style="width:80px;">Action</th>
                <th style="width:250px;">Question</th>
                <th>Answer</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($faqs as $faq)
            <tr>
                <td>
                    <div class="table-actions">
                        <a href="{{route('faq.edit',$faq->id)}}" class="toolTip var-modal" data-toggle="tooltip" data-placement="bottom" title="Edit Faq"><i class="ik ik-edit"></i></a>
                        <a href="#" class="toolTip delete" data-toggle="tooltip" data-placement="bottom" title="Delete" data-faq-id="{{$faq->id}}"><i class="ik ik-trash-2"></i></a>
                    </div>
                </td>
                <td>{{$faq->question}}</td>
                <td>{{$faq->answer}}</td>
                <td><input type="checkbox" class="js-switch change-faq-status" data-faq-id="{{ $faq->id }}" {{($faq->status=='AC')?'checked':''}} /></td>
            </tr>
            @endforeach
        </tbody>
    </table>
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
                var id = $(this).data('faq-id');
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover the deleted faq!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel please!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, function(isConfirm){
                    if (isConfirm) {
                        var url   = "{{ route('faq.destroy',':id') }}";
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
   

$('.change-faq-status').change(function () {
        var id = $(this).data('faq-id');

        if($(this).is(':checked'))
            var moduleStatus = 'AC';
        else
            var moduleStatus = 'IN';

        var url = '{{route('changeFaqStatus', ':id')}}';
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