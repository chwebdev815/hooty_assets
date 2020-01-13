@extends('layouts.appUser')
@section('title', 'Dashboard')
@section('content')
<link rel="stylesheet" href="{{asset('assets/css/summernote-bs4.css')}}">
<main class="main" style="overflow: hidden; margin-bottom: -26px;">
    <!-- CODE START HERE-->
    <div class="row m-0">
        <div class="col-md-2 p-0" id="list-tab-hide">
            <div class="h-10" id="list-tab" role="tablist"
                style="max-width=25%; border-bottom: 1px #f5f5f5 solid!important;">
                <h5 class="text-dark h5 border-1 px-0 pl-2 m-0" style="height:60px; line-height:3">Campaigns</h5>
                <!-- <div style="border-top:1px solid #00000010; margin-bottom: -5px; margin-top: 5px;"> -->
                <!-- <input class="form-control border-0 rounded-0 px-0 mx-0 p-2" type="text" style="max-width=25%;" placeholder=" Search"> -->
                <!-- </div>     -->
            </div>
            <div class="list-group h-100 bg-white mb-5" style="overflow-y: scroll; max-height: calc(100vh - 135px);"
                role="tablist">
                <!--DISCOVER PARENT-->
                @if(!empty($messages)) @foreach($messages as $key=>$value)
                <a class="list-group-item list-group-item-action border-1 @if(!empty($campaignId == $value->id)) active @endif"
                    href="{{URL::route('message_show_chatrooms',['campaignId' => $value->id])}}">{!! $value->title !!}
                    <i style="position:absolute;right:5px; top:15px; color:#ccc" class="fa fa-chevron-right"></i>
                </a> @endforeach @endif
                <!--END-->
            </div>
        </div>
        <div id="messageSection" class="col-md-10 d-sm-down-none p-0" style="height: calc(100vh - 54px);">
            <div class="tab-content" id="nav-tabContent">
                <!--DISCOVER CHILD-->
                <div class="tab-pane fade show active" id="list-home" role="tabpanel">
                    <form action="{{URL::route('chetMail')}}" id="chat-mail" method="post">
                        {{ csrf_field() }} @if(!empty((array) $chat_room))
                        <input type="hidden" name="text" value="{{ $campaignId }}" id="message_id">
                        <input type="hidden" name="last_new_id" value="{{$chat_room->member_id}}" id="journalists_id">
                        @endif
                        <div id="frame" class="row mx-0">
                            <div id="sidePanelInbox" class="col-md-3 px-0 py-md-0">
                                <div id="contacts">
                                    @if(!empty($chat_rooms) && sizeof($chat_rooms) > 0 )
                                    <ul class="list-unstyled">

                                        @foreach($chat_rooms as $key=>$value)
                                        <li class="contact p-2 @if(!empty($groupId == $value->roomid)) active @endif"
                                            style="position:relative">
                                            <a href="{{URL::route('message_show',['campaignId' => $campaignId, 'groupId'=>$value->roomid])}}"
                                                class="text-dark">
                                                <div class="meta">
                                                    <p class="preview name font-weight-bold">{{ $value->First_name }}
                                                    </p>
                                                    <p class="preview">
                                                        {{ str_replace("&nbsp;", " ", strip_tags(str_limit($message->text, $limit = 80, $end = '...'))) }}
                                                    </p>
                                                </div>
                                                <i style="position:absolute;right:5px; top:50%; margin-top:-5px; color:#ccc"
                                                    class="fa fa-chevron-right"></i>
                                            </a>
                                        </li>
                                        @endforeach

                                    </ul>
                                    @else

                                    <ul class="list-unstyled">
                                        <li class="contact active" style="position:relative">
                                            <a href="{{URL::route('message_show',['campaignId' => $campaignId, 'groupId'=>0])}}"
                                                class="text-dark">
                                                <div class="meta">
                                                    <p class="preview name font-weight-bold">
                                                        {{ auth()->guard('web')->user()->first_name }}</p>
                                                    <p class="preview">
                                                        {{ str_replace("&nbsp;", " ",strip_tags(str_limit($message->text, $limit = 80, $end = '...')) )}}
                                                    </p>
                                                </div>
                                                <i style="position:absolute;right:5px; top:50%; margin-top:-5px; color:#ccc"
                                                    class="fa fa-chevron-right"></i>
                                            </a>
                                        </li>
                                    </ul>

                                    @endif
                                </div>
                            </div>
                            <div class="content col-md-9" id="messageBox">
                                <span href=""
                                    class="input-group-addon messageBoxBack backButton p-3 text-muted d-md-none"><i
                                        class="fa fa-angle-left fa-2x"></i></span> @if(!empty((array) $journalist))
                                <div class="contact-profile pl-5 pl-md-2">
                                    <img class="rounded-circle" src="/assets/img/user.png" alt="">
                                    <p>{{$journalist->First_name}} {{$journalist->Last_name}} </p>
                                    <div class="social-media p-2">
                                        @if(!empty($journalist->Twitter_handle))
                                        <a href="{{$journalist->Twitter_handle}}"><i class="fa fa-lg fa-twitter"
                                                aria-hidden="true"></i> </a> @endif @if(!empty($journalist->YouTube))
                                        <a href="{{$journalist->YouTube}}"><i class="fa fa-lg fa-youtube"
                                                aria-hidden="true"></i> </a> @endif @if(!empty($journalist->Facebook))
                                        <a href="{{$journalist->Facebook}}"><i class="fa fa-lg fa-facebook"
                                                aria-hidden="true"></i> </a> @endif

                                    </div>
                                </div>
                                @else
                                <div class="contact-profile pl-5 pl-md-2">
                                    @if(empty(auth()->guard('web')->user()->image))
                                    <img class="img-avatar" src="{{asset('assets/img/avatars/6.jpg')}}"> @else
                                    <img src="{{auth()->guard('web')->user()->image}}" alt="user-image"
                                        class="rounded-circle img-avatar"> @endif
                                    <p>{{auth()->guard('web')->user()->first_name}}
                                        {{auth()->guard('web')->user()->last_name}}</p>
                                </div>
                                @endif
                                <div class="messages">
                                    <ul>
                                        <li class="replies">
                                            @if(empty(auth()->guard('web')->user()->image))
                                            <img src="{{asset('user.png') }}" alt="user-image" class="rounded-circle">
                                            @else
                                            <img src="{{auth()->guard('web')->user()->image}}" alt="user-image"
                                                class="rounded-circle"> @endif
                                            <div>
                                                <span>
                                                    {!! $message->text !!}
                                                </span>
                                            </div>
                                            <br>
                                            <div class="messageSendStyle"><time class="timeago"
                                                    datetime="{{ $value->created_at }}Z">{{ $value->created_at }}Z</time>
                                            </div>
                                        </li>
                                        @if(!empty($chat_messages)) @foreach($chat_messages as $key=>$value)
                                        @if($value->receiver_id == auth()->guard('web')->user()->id)
                                        <li class="sent"> <img class="rounded-circle" src="/assets/img/user.png" alt="">
                                            <div>
                                                <span>
                                                    {!! $value->message !!}
                                                </span>
                                            </div>
                                            <br>
                                            <div class="messageReceiveStyle"><time class="timeago"
                                                    datetime="{{ $value->created_at }}Z">{{ $value->created_at }}Z</time>
                                            </div>
                                        </li>
                                        @else
                                        <li class="replies">
                                            @if(empty(auth()->guard('web')->user()->image))
                                            <img src="{{asset('user.png') }}" alt="user-image" class="rounded-circle">
                                            @else
                                            <img src="{{auth()->guard('web')->user()->image }}" alt="user-image"
                                                class="rounded-circle"> @endif
                                            <div>
                                                <span>
                                                    {!! $value->message !!}
                                                </span>
                                            </div>
                                            <br>
                                            <div class="messageSendStyle"><time class="timeago"
                                                    datetime="{{ $value->created_at }}Z">{{ $value->created_at }}Z</time>
                                            </div>
                                        </li>
                                        @endif @endforeach @endif
                                    </ul>
                                </div>
                                @if(!empty((array) $journalist))
                                <div class="message-input px-md-down-2">
                                    <div>
                                        <textarea name="message" class="message-box" id="summernote"> </textarea>
                                    </div>
                                </div>
                                @endif

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="{{asset('assets/js/selectize.js')}}"></script>
<script src="{{asset('assets/js/summernote-bs4.js')}}"></script>
<script src="{{asset('assets/js/inbox.js')}}"></script>
<script src="{{asset('assets/js/jquery.timeago.js')}}"></script>
<script>
    jQuery(document).ready(function() {
     jQuery("time.timeago").timeago();
    });
        // $(document).ready(function(){
        //     $('.format-date').each(function(){
        //         console.log(jQuery.timeago($(this).html()));

        //         console.log($(this).html());
        // //         
        //         $(this).html(jQuery.format.prettyDate($(this).html()))
        //     });  
        // //        
        //         });

</script>
@endsection