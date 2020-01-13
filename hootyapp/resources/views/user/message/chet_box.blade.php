@extends('layouts.appUser') @section('title', 'Dashboard')
@section('content')
<style type="text/css">
    .cke_chrome {
        display: grid;
    }

    .tooltip-inner {
        max-width: 270px;
        width: 270px;
    }
</style>
<script src="https://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{URL::route('index')}}">Frontend</a></li>
                        <li class="breadcrumb-item"><a href="{{URL::route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{URL::route('message')}}">Inbox</a></li>
                        <li class="breadcrumb-item active">Chat Box</li>
                    </ol>
                </div>
                <h4 class="page-title">Chat Box</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body chet">
                    <div class="card_box_border">
                        <form action="{{URL::route('chetMail')}}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="text" value="{{ $message->id }}" id="message_id">
                            <input type="hidden" name="last_new_id" value="{{$journalists_id}}" id="journalists_id">
                            <input type="hidden" name="group_id" value="{{$group_id}}" id="group_id">
                            <div class="col-md-3 flot_left">
                                <div class="app-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search..."
                                            id="chat_search_box" style="height: 40px;">
                                        <span class="mdi mdi-magnify" style="line-height: 40px;"></span>
                                    </div>
                                </div>
                                <ul class="chet_list">
                                    @if(!empty($member))
                                    @foreach($member as $value)
                                    <a
                                        href="{{ URL::route('messages_show',$message->id.'231*@m~$!19h~1$S+298'.$value->journalists_id) }}">
                                        <li @if($value->journalists_id == $cfirst->journalists_id)class="active" @endif>
                                            <!-- <img src="{{asset('user.png') }}"> -->
                                            <span>{!! strtoupper(substr($value->first_name,0,1)) !!}{!!
                                                strtoupper(substr($value->last_name,0,1)) !!}</span>
                                            {{ $value->first_name }} {{ $value->last_name }}
                                            @if($value->chat_status != 0)
                                            <div class="unread_count">{{ $value->chat_status }}-new</div>
                                            @endif
                                        </li>
                                    </a>
                                    @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div class="col-md-9 flot_right">
                                <div class="chet_box">
                                    <div class="send">
                                        <div class="send_img" ata-toggle="tooltip"
                                            title="{!! auth()->guard('web')->user()->first_name !!} {!! auth()->guard('web')->user()->last_name !!}">
                                            @if(empty(auth()->guard('web')->user()->image))
                                            <span>{!! strtoupper(substr(auth()->guard('web')->user()->first_name,0,1))
                                                !!}{!! strtoupper(substr(auth()->guard('web')->user()->last_name,0,1))
                                                !!}</span>
                                            @else
                                            <img src="{{auth()->guard('web')->user()->image }}" width="30px">
                                            @endif
                                        </div>
                                        <div class="send_msg" data-toggle="tooltip" title="{!! $string !!}">{!!
                                            $message->text !!}</div>
                                    </div>
                                    @if(!empty($chet))
                                    @foreach($chet as $value)
                                    @if($value->sender_id == $user_id)
                                    <div class="send">
                                        <div class="send_img" ata-toggle="tooltip"
                                            title="{!! $value->user_fname!!} {!!$value->user_lname !!}">
                                            @if(empty($value->user_image))
                                            <span>{!! strtoupper(substr($value->user_fname,0,1)) !!}{!!
                                                strtoupper(substr($value->user_lname,0,1)) !!}</span>
                                            @else
                                            <img src="{{$value->user_image }}" width="30px">
                                            @endif
                                        </div>
                                        <div class="send_msg" data-toggle="tooltip"
                                            title="Delivery-{{$value->Delivery}} Open-{{$value->Open}} Click-{{$value->Click}}">
                                            {!! $value->message !!}</div>
                                    </div>
                                    @else
                                    <div class="receive">
                                        <div class="receive_img" ata-toggle="tooltip"
                                            title="{!! $value->j_fname!!} {!!$value->j_lname !!}">
                                            <span>{!! strtoupper(substr($value->j_fname,0,1)) !!}{!!
                                                strtoupper(substr($value->j_lname,0,1)) !!}</span>
                                        </div>
                                        <div class="receive_msg">{!! $value->message !!}</div>
                                    </div>
                                    @endif
                                    @endforeach
                                    @endif
                                    <br> <br>
                                    <textarea name="message" id="message"
                                        style="width: 100%;display: inline-block;"></textarea>
                                    <button type="submit" class="btn btn-primary flot_right">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>

</div>
<script type="text/javascript">
    var search_name = "<?php echo route('search_name')?>";
</script>
<script>
    CKEDITOR.replace( 'message', {
      extraPlugins: 'uploadimage,image2',
    });
</script>
@endsection