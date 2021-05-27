@if(Session::has('failCity'))
	<div class="alert alert-warning">This vehicle was already added in the cities: {{Session::get("failCity")}} </div>
@elseif(Session::has('failCouponCity'))
	<div class="alert alert-warning">This code was already added in the cities: {{Session::get("failCouponCity")}} </div>
@endif
@push('scripts')
<script src="{{URL::asset('/js/toastr/toastr.min.js')}}"></script>
<!-- scripit init-->
<script src="{{URL::asset('/js/toastr/toastr.init.js')}}"></script>

<script type="text/javascript">


	@foreach (['error', 'warning', 'success', 'info'] as $key)
		@if(Session::has($key))
			toastr.{{$key}}('{{ Session::get($key) }}',"Status",{
		        timeOut: 5000,
		        "closeButton": true,
		        "debug": false,
		        "newestOnTop": true,
		        "progressBar": true,
		        "positionClass": "toast-top-right",
		        "preventDuplicates": true,
		        "onclick": null,
		        "showDuration": "300",
		        "hideDuration": "1000",
		        "extendedTimeOut": "1000",
		        "showEasing": "swing",
		        "hideEasing": "linear",
		        "showMethod": "fadeIn",
		        "hideMethod": "fadeOut",
		        "tapToDismiss": false

		    })
		@endif
	@endforeach


</script>
@endpush