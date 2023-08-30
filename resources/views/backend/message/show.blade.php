@extends('backend.layouts.master')
@section('main-content')
<div class="card mx-2">
  <h5 class="card-header">{{ __('adm.message') }}</h5>
  <div class="card-body">
    @if($message)
        @if($message->photo)
        <img src="{{$message->photo}}" class="rounded-circle " style="margin-left:44%;">
        @else 
        <img src="{{asset('backend/img/avatar.png')}}" class="rounded-circle " style="margin-left:44%;">
        @endif
        <div class="py-4">
          <p class="text-uppercase"><b>{{ __('adm.message_from') }}:</b></p>
          <p><b>{{ __('adm.message_name') }}</b> :{{$message->name}}</p>
          <p><b>{{ __('adm.message_email') }}</b> :{{$message->email}}</p>
          <p><b>{{ __('adm.message_phone') }}</b> :{{$message->phone}}</p>
        </div>
        <hr/>
        <h6 class="text-center"><strong>{{ __('adm.message_subject') }} :</strong> {{$message->subject}}</h6>
        <p class="py-5">{{$message->message}}</p>

    @endif

  </div>
</div>
@endsection