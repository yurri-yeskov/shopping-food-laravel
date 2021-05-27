@extends('layouts.leo')
@push('head-script')
@endpush
@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-10">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5>Products ( {{ $totalproducts }} )</h5>
                    <span>You have got {{Count($products)}} products on this page</span>
                </div>
            </div>
        </div>
            <div class="col-lg-2">
                <a href="{{route('product.create')}}" class="float-right var-modal"> <button type="button" class="btn btn-success">New Product</button></a>
            </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @include('layouts.message')
        <div class="col-lg-12 text-center bg-white p-2 border-top  make-me-sticky">@foreach( range('A','Z') as $initial )
        <a href="{{ url('admin/product?initial='.$initial) }}" class="badge badge-{{app('request')->input('initial')== $initial ? 'danger' : 'info' }}" style="font-weight:900;">{{ $initial }}</a>
        @endforeach
                </div>

        <div class="card">
                <table class="table" id="leo">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Variations</th>
                            <th>Category</th>
                            <th>Favorited</th>
                            <th>Featured</th>
                            <th>Quick Grab</th>
                            <th>Offered</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>
                                <div class="table-actions">
                                    <a href="{{route('product.show',$product->id)}}" class="toolTip " data-toggle="tooltip" data-placement="bottom" title="Show Product"><i class="ik ik-eye"></i></a>
                                    <a href="{{route('product.edit',$product->id)}}" class="toolTip var-modal" data-toggle="tooltip" data-placement="bottom" title="Edit Product"><i class="ik ik-edit"></i></a>
                                    <a href="#" class="toolTip delete" data-toggle="tooltip" data-placement="bottom" title="Delete" data-var-id="{{$product->id}}"><i class="ik ik-trash-2"></i></a>

                                </div>
                            </td>
                            <td>
                            <img src="{{$product->productImage}}" class="table-user-thumb">                                
                            </td>
                            <td><a href="{{route('product.show',$product->id)}}"> {!! ucfirst(str_limit($product->name, 20)) !!}</a></td>
                            <td> <span class="badge badge-{{Count($product->variations) == '0' ? 'danger' : 'success' }}">{{ Count($product->variations) }}</span></td>
                            <td><a href="{{route('category.show',$product->category->id)}}"> {{ucfirst($product->category->name)}}</a></td>
                            <td><span class="badge bg-yellow text-white"> {{$product->users->count()}} </span></td>
                            <td><input type="checkbox" class="js-switch change-product-featured-status" data-product-id="{{ $product->id }}" {{($product->is_featured=='1')?'checked':''}} /></td>
                            <td><input type="checkbox" class="js-switch change-quick-grab-status" data-product-id="{{ $product->id }}" {{($product->is_quick_grab=='1')?'checked':''}} /></td>
                            <td><input type="checkbox" class="js-switch change-offered-status" data-product-id="{{ $product->id }}"  {{($product->is_offered=='1')?'checked':''}} /></td>
                            <td><input type="checkbox" class="js-switch change-product-status" data-product-id="{{ $product->id }}" {{($product->status=='AC')?'checked':''}} /></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
            {{$products->links()}}
    </div>
</div>
<div class="modal fade text-center" id="theModal">
  <div class="modal-dialog modal-lg">
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
                var id = $(this).data('var-id');
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover the deleted product!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel please!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, function(isConfirm){
                    if (isConfirm) {
                        var url   = "{{ route('product.destroy',':id') }}";
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
   

    
$('.change-product-status').change(function () {
        var id = $(this).data('product-id');

        if($(this).is(':checked'))
            var moduleStatus = 'AC';
        else
            var moduleStatus = 'IN';

        var url = '{{route('changeProductStatus', ':id')}}';
        url = url.replace(':id', id);
        $.easyAjax({
            url: url,
            type: "POST",
            data: { 'id': id, 'status': moduleStatus, '_method': 'POST', '_token': '{{ csrf_token() }}' }
        })
    });
    
    $('.change-product-featured-status').change(function () {
        var id = $(this).data('product-id');

        if($(this).is(':checked'))
            var moduleStatus = '1';
        else
            var moduleStatus = '0';

        var url = '{{route('changeProductFeaturedStatus', ':id')}}';
        url = url.replace(':id', id);
        $.easyAjax({
            url: url,
            type: "POST",
            data: { 'id': id, 'status': moduleStatus, '_method': 'POST', '_token': '{{ csrf_token() }}' }
        })
    });
    $('.change-quick-grab-status').change(function () {
        var id = $(this).data('product-id');

        if($(this).is(':checked'))
            var moduleStatus = '1';
        else
            var moduleStatus = '0';

        var url = '{{route('changeQuickGrabStatus', ':id')}}';
        url = url.replace(':id', id);
        $.easyAjax({
            url: url,
            type: "POST",
            data: { 'id': id, 'status': moduleStatus, '_method': 'POST', '_token': '{{ csrf_token() }}' }
        })
    });
    $('.change-offered-status').change(function () {
        var id = $(this).data('product-id');

        if($(this).is(':checked'))
            var moduleStatus = '1';
        else
            var moduleStatus = '0';

        var url = '{{route('changeOfferedStatus', ':id')}}';
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