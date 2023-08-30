@extends('backend.layouts.master')
@section('title', __('adm.affiliate'))
@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4 mx-2">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header">
      {{ __('adm.affiliate') }}
    </div>
    <div class="card-body">

      <div class="affiliate-info mb-3 border bg-light rounded px-2 pt-3 pb-0">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <input type="text" class="form-control" id="affiliateLink" value="{{ $affiliateLink }}">
            </div>
          </div>
          <div class="col-md-2">
            <button class="btn btn-sm btn-success" id="copyAffiliate"><i class="fa fa-clone" aria-hidden="true"></i> {{ __('adm.copy') }}</button>
          </div>
          <div class="col-md-2">
            <span class="mr-3">Mã QR</span>
            {{ Helper::QrCodeReferrer(auth()->user()->id, 40) }}
          </div>
        </div>
      </div>

      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="listview-tab" data-toggle="tab" href="#listview" role="tab" aria-controls="listview" aria-selected="true">Liên kết trực tiếp</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="treeview-tab" data-toggle="tab" href="#treeview" role="tab" aria-controls="treeview" aria-selected="false">Sponsor Treeview</a>
        </li>
      </ul>

      <div class="tab-content pt-3" id="myTabContent">
        <div class="tab-pane fade show active" id="listview" role="tabpanel" aria-labelledby="listview-tab">
          <div class="table-responsive">
            @if(count($users)>0)
            <table class="table table-sm" id="post-category-dataTable" width="100%" cellspacing="0">
              <thead class="thead-primary">
                <tr>
                  <th>{{ __('adm.email') }}</th>
                  <th>{{ __('adm.name') }}</th>
                  <th>{{ __('adm.phone') }}</th>
                  <th>{{ __('adm.created_at') }}</th>
                  <th>{{ __('adm.referrer_link') }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach($users as $data)   
                  <tr>
                    <td>{{$data->email}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->phone}}</td>
                    <td>{{$data->created_at}}</td>
                    <td>{{$data->parentReferrer->email}}</td>
                  </tr>  
                @endforeach
              </tbody>
            </table>
            @else
              <p class="text-center">{{ __('adm.no_result_found') }}</p>
            @endif
          </div>  
        </div>
        <div class="tab-pane fade show" id="treeview" role="tabpanel" aria-labelledby="treeview-tab">
          <ul id="affiliateTree">
            @if(count($users)>0)
              @foreach($users as $user)
                @include('backend.affiliate.includes.loop-tree', ['user' => $user])
              @endforeach
            @endif
          </ul>
        </div>
      </div>
    </div>
</div>
@endsection

@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
    .tree, .tree ul {
        margin:0;
        padding:0;
        list-style:none
    }
    .tree ul {
        margin-left:1em;
        position:relative
    }
    .tree ul ul {
        margin-left:.5em
    }
    .tree ul:before {
        content:"";
        display:block;
        width:0;
        position:absolute;
        top:0;
        bottom:0;
        left:0;
        border-left:1px solid
    }
    .tree li {
        margin:0;
        padding:0 1em;
        line-height:2em;
        color:#369;
        font-weight:500;
        position:relative
    }
    .tree > li {
      border-radius: 4px;
      border: 1px solid #369;
      margin-bottom: 5px;
    }
    .tree ul li:before {
        content:"";
        display:block;
        width:10px;
        height:0;
        border-top:1px solid;
        margin-top:-1px;
        position:absolute;
        top:1em;
        left:0
    }
    .tree ul li:last-child:before {
        background:#fff;
        height:auto;
        top:1em;
        bottom:0
    }
    .indicator {
        margin-right:5px;
    }
    .tree li a {
        text-decoration: none;
        color:#369;
    }
    .tree li button, .tree li button:active, .tree li button:focus {
        text-decoration: none;
        color:#369;
        border:none;
        background:transparent;
        margin:0px 0px 0px 0px;
        padding:0px 0px 0px 0px;
        outline: 0;
    }
  </style>
@endpush

@push('scripts')

  <!-- Page level plugins -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

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

      $('#copyAffiliate').click(function() {
        var link = $('#affiliateLink').val();
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(link).select();
        document.execCommand("copy");
        $temp.remove();

        swal("", '{{ __("adm.copy_success") }}', "success");

      })

      $.fn.extend({
        treed: function (o) {
          
          var openedClass = 'fa fa-minus-circle';
          var closedClass = 'fa fa-plus-circle';
          
          if (typeof o != 'undefined'){
            if (typeof o.openedClass != 'undefined'){
            openedClass = o.openedClass;
            }
            if (typeof o.closedClass != 'undefined'){
            closedClass = o.closedClass;
            }
          };
          
          //initialize each of the top levels
          var tree = $(this);
          tree.addClass("tree");
          tree.find('li').has("ul").each(function () {
              var branch = $(this); //li with children ul
              branch.prepend("<i class='indicator " + closedClass + "'></i>");
              branch.addClass('branch');
              branch.on('click', function (e) {
                  if (this == e.target) {
                      var icon = $(this).children('i:first');
                      icon.toggleClass(openedClass + " " + closedClass);
                      $(this).children().children().toggle();
                  }
              })
              branch.children().children().toggle();
          });

          //fire event from the dynamically added icon
          tree.find('.branch .indicator').each(function(){
            $(this).on('click', function () {
                $(this).closest('li').click();
            });
          });
          //fire event to open branch if the li contains an anchor instead of text
          tree.find('.branch>a').each(function () {
              $(this).on('click', function (e) {
                  $(this).closest('li').click();
                  e.preventDefault();
              });
          });
          //fire event to open branch if the li contains a button instead of text
          tree.find('.branch>button').each(function () {
              $(this).on('click', function (e) {
                  $(this).closest('li').click();
                  e.preventDefault();
              });
          });
        }
      });

      $('#affiliateTree').treed();
  </script>
@endpush