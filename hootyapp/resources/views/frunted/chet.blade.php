@extends('layouts.appFrunted') @section('title', 'Dashboard')
@section('content')
<div class="stage" id="stage">
    <div class="block block-inverse block-fill-height app-header"
        style="background-image: url({{asset('frontTheme/assets/img/startup-1.jpg') }});">
        @include('frunted.layouts.header')
        <h2 class="text-center">Reply</h2>
        <div class="container reply_email_box">
            <form action="{{URL::route('send')}}" method="post">
                {{ csrf_field() }}
                <div class="chet">
                    <div class="chet_box">
                        <div class="receive">
                            <div class="receive_img" ata-toggle="tooltip"
                                title="{!! $message->first_name!!} {!!$message->last_name !!}">
                                @if(empty($message->image))
                                <span>{!! strtoupper(substr($message->first_name,0,1)) !!}{!!
                                    strtoupper(substr($message->last_name,0,1)) !!}</span>
                                @else
                                <img src="{{$message->image}}" width="30px">
                                @endif
                            </div>
                            <div class="receive_msg">{!! $message->text !!}</div>
                        </div>
                        @if(!empty($chet))
                        @foreach($chet as $value)
                        @if($value->receiver_id == $member_id)
                        <div class="receive">
                            <div class="receive_img" ata-toggle="tooltip"
                                title="{!! $value->user_fname!!} {!!$value->user_lname !!}">
                                @if(empty($value->user_image))
                                <span>{!! strtoupper(substr($value->user_fname,0,1)) !!}{!!
                                    strtoupper(substr($value->user_lname,0,1)) !!}</span>
                                @else
                                <img src="{{$value->user_image}}" width="30px">
                                @endif
                            </div>
                            <div class="receive_msg">{!! $value->message !!}</div>
                        </div>
                        @else
                        <div class="send">
                            <div class="send_img" ata-toggle="tooltip"
                                title="{!! $value->j_fname!!} {!!$value->j_lname !!}">
                                <span>{!! strtoupper(substr($value->j_fname,0,1)) !!}{!!
                                    strtoupper(substr($value->j_lname,0,1)) !!}</span>
                            </div>
                            <div class="send_msg">{!! $value->message !!}</div>
                        </div>
                        @endif
                        @endforeach
                        @endif
                    </div>
                </div>
                <br>
                <div>
                    <textarea name="message" id="message"></textarea>
                </div>
                <br>
                <input type="hidden" name="myiid" value="{{$member_id}}">
                <input type="hidden" name="groupid" value="{{$group_id}}">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-default">Reply</button>
                </div>
                <input type="hidden" name="mmiid" value="{{$message_id}}">
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'message', {
      extraPlugins: 'image2',
    });
</script>
@endsection