@extends('layouts.leo')
@section('content')
@include('sections.settings')
@include('layouts.message')
<table align="center" width="20%">
  <tr>
    <td style="padding-right: 10px">
      <input type="text" id="Search" class="form-control" onkeyup="myFunction()" placeholder="Type in Suburb Name.." title="Type in a suburb name" style="width:300px;">
    </td>
  </tr>
</table>
<br>
<div class="row">
@foreach($suburbs as $cat)
<div class="col-lg-3 col-md-6 col-sm-12 target">
    <div class="widget">
        <div class="widget-body">
            <div class="d-flex justify-content-between align-items-center">
                <div class="state">
                    <h6>{{$cat->name}}</h6>
                    <h2>{{$cat->postcode}}</h2>
                </div>
                <div class="icon">
                    <input type="checkbox" class="js-switch change-unit-status" data-category-id="{{ $cat->id }}" {{($cat->status=='AC')?'checked':''}} />
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

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

        var url = '{{route('changeSuburbStatus', ':id')}}';
        url = url.replace(':id', id);
        $.easyAjax({
            url: url,
            type: "POST",
            data: { 'id': id, 'status': moduleStatus, '_method': 'POST', '_token': '{{ csrf_token() }}' }
        })
    });    
   
function myFunction() {
  var input = document.getElementById("Search");
  var filter = input.value.toLowerCase();
  var nodes = document.getElementsByClassName('target');

  for (i = 0; i < nodes.length; i++) {
    if (nodes[i].innerText.toLowerCase().includes(filter)) {
      nodes[i].style.display = "block";
    } else {
      nodes[i].style.display = "none";
    }
  }
}
</script>
@endpush