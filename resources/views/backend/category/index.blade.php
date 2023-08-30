@extends('backend.layouts.master')
@section('title', __('adm.product_category'))
@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4 mx-2">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header">
      {{ __('adm.product_category') }}
      <a href="{{route('category.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> {{ __('adm.add').' '.__('adm.product_category') }}</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($categories)>0)
        <table class="table table-sm" id="banner-dataTable" width="100%" cellspacing="0">
          <thead class="thead-primary">
            <tr>
              <th>{{ __('adm.name') }}</th>
              <th>{{ __('adm.slug') }}</th>
              <th>{{ __('adm.is_parent_category') }}</th>
              <th>{{ __('adm.parent_category') }}</th>
              <th>{{ __('adm.status') }}</th>
              <th>{{ __('adm.action') }}</th>
            </tr>
          </thead>
          <tbody>

            @foreach($categories as $category)
              @include('backend.category.includes.loop', ['category' => $category])
            @endforeach
            
          </tbody>
        </table>
        @else
          <p class="text-center">{{ __('adm.no_result_found') }}</p>
        @endif
      </div>
    </div>
</div>
@endsection

@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      div.dataTables_wrapper div.dataTables_paginate{
          display: none;
      }
  </style>
@endpush

@push('scripts')

  <!-- Page level plugins -->
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  <!-- <script>

      $('#banner-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[3,4,5]
                }
            ]
        } );

        // Sweet alert

        function deleteData(id){

        }
  </script> -->
  <script>
      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
          $('.dltBtn').click(function(e){
            var form=$(this).closest('form');
              var dataID=$(this).data('id');
              // alert(dataID);
              e.preventDefault();
              swal({
                    title: "{{ __('adm.confirm_delete') }}",
                    text: "{{ __('adm.confirm_delete_message') }}",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                       form.submit();
                    } else {
                        //swal("Your data is safe!");
                    }
                });
          })
      })
  </script>
@endpush
