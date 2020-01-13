@extends('layouts.appUser') 
@section('title', 'Dashboard') 
@section('content')
<link rel="stylesheet" href="{{asset('assets/css/selectize.default.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/summernote-bs4.css')}}">
<style>
    .error {
        border-color: rgb(185, 74, 72);
    }

    .error_position {

        color: red;
        position: absolute !important;
        top: 57px !important;
        right: 15px !important;
    }
</style>
<main class="main wait-for-load">
    <section class="pt-3">
        <div class="container">
            <div class="row mx-md-2">
                <div class="col-md-12">
                    <h3 class="text-dark">Compose</h3>
                </div>
            </div>
        </div>
    </section>
    <section id="composeStructure" class="pt-3">
        <div class="container">
            <div class="row mx-md-2">
                <div class="col-md-12">
                    <form action="{{URL::route('sendMail')}}" id="sendForm" method="post">
                        {{ csrf_field() }}
                        <div class="" id="card_central">
                            <input type="checkbox" name="draft" id="draft" class="d-none">
                            <input type="hidden" name="messageId" value="{{!empty($campaign) ? $campaign->id : ''}}">
                            <label class="_radio">Press Pitch
									<input type="radio" checked="checked" name="type" value="Press pitch"> <span class="_checkmark"></span> </label>
                            <label class="_radio ml-1">Press Release <sup><span class="badge badge-light">Coming soon</span></sup>
                                    <input type="radio" disabled name="type" value="Press release"> <span class="_checkmark"></span> </label>

                            <div class="form-group">
                                <div class="d-none float-right error_position " id="campaign_error_position">Please select a Campaign name</div>

                                <label class="mt-3" for="name">Campaign Name</label> @if(!empty($campaign))
                                <input data-validation="required" type="name" value="@if(!empty($campaign->title)){{trim($campaign->title)}}@endif" name="title"
                                    class="form-control w-100" placeholder="Campaign Name"> @elseif(!empty($title))
                                <input data-validation="required" type="name" value="@if(!empty($title)){{trim($title)}}@endif" name="title" class="form-control w-100"
                                    placeholder="Campaign Name"> @endif
                            </div>
                            <div class="form-group">
                                    <div class="d-none float-right " id="subjectErrorMsg" style="color:red;">Please select a subject</div>
                                    <label class="">Subject</label>
                                    <input data-validation="required" value="" type="subject" name="subject"
                                        class="form-control w-100" placeholder="Subject">
                                </div>
                            <div class="my-2">

                                <div class="sandbox">
                                    <div class="header mb-1"> Lists

                                    </div>

                                    <div class="d-none float-right" id="listErrorMsg" style="color:red;">Please select a list</div>

                                    <div class="form-group">
                                        <select type="text" id="list-tags" name="groups[]" multiple> 
                                            @if(!empty($group))
                                            @foreach($group as $value)
                                             <option {{isset($_GET[str_replace(" ","_",$value->name)]) || (!empty($selectedGroups) && in_array($value->id, $selectedGroups)) ? "selected" : ""}} value="{{$value->id}}"> {{$value->name}}</option>
                                            @endforeach
                                            @else
                                            @endif
                                            </select>
                                    </div>

                                </div>
                                <div class="mt-3 w-100">
                                    <div class="d-none float-right" id="noteErrorMsg" style="color:red;">Please Write a Message</div>
                                    <label for="message">Message</label>
                                    <textarea data-validation="required" name="message" value="{{!empty($campaign) ? $campaign->text : $row }}" id="summernote"
                                        required></textarea>
                                </div>
                                <div class="text-right mt-2">
                                    <button type="button" class="btn btn-md btn-primary sendIconMessage" id="saveAsDraftButton">
                                                <i class="fa fa-save"></i> Save as draft</button>
                                    <button type="submit" class="btn btn-md btn-primary sendIconMessage" id="sendMessageButton">
                                                <img src="{{asset('assets/images/sendToAll.svg')}}" class="svg sendToAll"> Send Message</button>

                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
</main>

<div class="video-modal d-none">
    <div class="tabs">
        <div class="tab-button-outer">
            <ul id="tab-button">
                <li><a href="#tab01">URL</a></li>
                <li><a href="#tab02">Uploaded Videos</a></li>
                <li><a href="#tab03">Composed Videos</a></li>
            </ul>
        </div>
        <div class="tab-select-outer">
            <select id="tab-select">
                    <option value="#tab01">URL</option>
                    <option value="#tab02">Uploaded Videos</option>
                    <option value="#tab03">Composed Videos</option>
                    </select>
        </div>
        <div id="tab01" class="tab-contents">
            <h2>URL</h2>
            <div class="form-group note-form-group row-fluid">
                <label class="note-form-label">Video URL
                            <small class="text-muted"> (YouTube, Instagram, or DailyMotion)</small>
                        </label>
                <input class="note-video-url form-control note-form-control note-input" type="text" />
            </div>
        </div>
        <div id="tab02" class="tab-contents text-center">
            <ul style="list-style:none;" class="row mt-4">
                @foreach(json_decode($uploaded_videos) as $value)
                <li class="col-md-6 video-item" data-image="{{$masher_url}}{{$value->icon}}" data-url="{{$app_url}}/view-video/{{auth()->guard('web')->user()->id}}/{{$value->id}}/default">
                    <div class="card">
                        <img class="img-fluid" src="{{$masher_url}}{{$value->icon}}">
                        <div class="card-body text-left">
                            <span>{{$value->label}}</span>
                            <span class="float-right">{{$value->duration}} seconds</span>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        <div id="tab03" class="tab-contents text-center">
            <ul style="list-style:none;" class="row mt-4">
                @foreach(json_decode($mashed_videos) as $value)
                <?php
                            if(!empty($value->source) ){
                                $url = str_replace("/user-media/","", $value->source); 
                                $url = str_replace(".mp4", "", $url);
                            }
                        ?>
                    @if(!empty($url))
                    <li class="col-md-6 video-item" data-image="{{!empty($value->icon) ? $value->icon : ''}}" data-url="{{$app_url}}/view-video/{{$url}}">
                        <div class="card">
                            <img class="img-fluid" src="{{!empty($value->icon) ? $value->icon : ''}}">
                            <div class="card-body">
                                <span>{{$value->label}}</span> @if(!empty($value->duration))
                                <span class="float-right">{{!empty($value->duration) ? $value->duration : ''}} seconds</span>                                @endif
                            </div>
                        </div>
                    </li>
                    @endif @endforeach
            </ul>
        </div>
    </div>

</div>


<script src="{{asset('assets/js/jquery.form-validator.js')}}"></script>
<script>
    var parser = new DOMParser;
            var encodedStr = '{{!empty($campaign) ? $campaign->text : $row}}';
            var dom = parser.parseFromString(
                    '<!doctype html><body>' + encodedStr,
                    'text/html');
            var text = dom.body.textContent;

</script>
<script src="{{asset('assets/js/selectize.js')}}"></script>

<script src="{{asset('assets/js/summernote-bs4.js')}}"></script>
<script src="{{asset('assets/js/compose.js')}}"></script>
@endsection