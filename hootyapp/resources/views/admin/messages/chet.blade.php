@extends('admin.layouts.app') @section('title', 'Dashboard') @section('content')

<div id="main">

    <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li class="active">Message</li>
        <li class="active">Data</li>
    </ol>
    <!-- //breadcrumb-->

    <div id="content">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel chet">
                    <header class="panel-heading">
                        <h2><strong>Message</strong> </h2>
                        <!-- <label class="color">Plugin for <strong>Bootstrap3</strong></label> -->
                    </header>
                    <div class="panel-tools fully color" align="right" data-toolscolor="#6CC3A0">
                        <ul class="tooltip-area">
                            <li><a href="javascript:void(0)" class="btn btn-collapse" title="Collapse"><i
                                        class="fa fa-sort-amount-asc"></i></a></li>
                            <li><a href="javascript:void(0)" class="btn btn-reload" title="Reload"><i
                                        class="fa fa-retweet"></i></a></li>
                            <li><a href="javascript:void(0)" class="btn btn-close" title="Close"><i
                                        class="fa fa-times"></i></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="card_box_border">
                            <form action="{{URL::route('chetMail')}}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="text" value="{{ $message->id }}" id="message_id">
                                <input type="hidden" name="last_new_id" value="{{$journalists_id}}" id="journalists_id">
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
                                            href="{{ URL::route('admin_chets',$message->id.'11@@99'.$value->journalists_id) }}">
                                            <li @if($value->journalists_id == $cfirst->journalists_id)class="active"
                                                @endif>
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
                                                title="{!! $chat_log[0]->first_name !!} {!! $chat_log[0]->last_name !!}">
                                                <a href="{{URL::route('user_profile',$chat_log[0]->id)}}">
                                                    @if(empty($chat_log[0]->image))
                                                    <span>{!! strtoupper(substr($chat_log[0]->first_name,0,1)) !!}{!!
                                                        strtoupper(substr($chat_log[0]->last_name,0,1)) !!}</span>
                                                    @else
                                                    <img src="{{$chat_log[0]->image }}" width="30px">
                                                    @endif
                                                </a>
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
                                                <a href="{{URL::route('user_profile',$value->user_id)}}">
                                                    @if(empty($value->user_image))
                                                    <span>{!! strtoupper(substr($value->user_fname,0,1)) !!}{!!
                                                        strtoupper(substr($value->user_lname,0,1)) !!}</span>
                                                    @else
                                                    <img src="{{$value->user_image }}" width="30px">
                                                    @endif
                                                </a>
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
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
            <!-- //content > row > col-lg-12 -->

        </div>
        <!-- //content > row-->

    </div>
    <!-- //content-->

    <footer id="site-footer">
        <section>&copy; Copyright 2014, By </section>
    </footer>

</div>

<!-- //main-->
<script type="text/javascript">
    var chat_search_name = "<?php echo route('chat_search_name')?>";
</script>
@endsection
@section('footer_script')