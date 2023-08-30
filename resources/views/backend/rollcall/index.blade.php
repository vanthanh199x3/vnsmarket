@extends('backend.layouts.master')
@section('title', __('adm.rollcall'))

@section('main-content')
<div class="card mx-2">
  <h5 class="card-header">{{ __('adm.rollcall') }}</h5>
  <div class="card-body">
    <div class="form-group">
        <button class="btn btn-success btnRollCall"><i class="fa fa-check" aria-hidden="true"></i> {{ __('adm.today') }}</button>
    </div>
    <div class="form-group row">
        <div class="col-md-3">
            <div class="card balance shadow h-100 py-2">
                <div class="card-body">
                    <a class="text-light">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">{{ __('adm.total_rollcall') }}</div>
                                <div class="h5 mb-0 font-weight-bold totalRollCall">{{ $total ?? 0 }}</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>


</style>
@endpush

@push('scripts')
<script>

    $('.btnRollCall').click(function() {
        $.ajax({
            url: "{{ route('rollcall.add') }}",
            type:"GET",
            dataType: 'json',
            success:function(res){
                swal("", res.message, "success");
                if(res.status) {
                    let total = $('.totalRollCall').text();
                    total = parseInt(total) + 1;
                    $('.totalRollCall').text(total);
                }
            }
        });
    });

</script>
@endpush
