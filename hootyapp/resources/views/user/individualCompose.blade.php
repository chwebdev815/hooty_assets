@extends('layouts.appUser') 
@section('title', 'Dashboard') 
@section('content')

<link rel="stylesheet" href="{{asset('assets/css/selectize.default.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/summernote-bs4.css')}}">


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
        <form action="{{URL::route('sendMail')}}" id="send_individual_compose" method="post">
            {{ csrf_field() }}
            <input type="checkbox" name="draft" id="draft" class="d-none">
            <input type="hidden" name="messageId" value="@if(!empty($campaign->id)) {{$campaign->id}} @endif">
            <input type="checkbox" name="articleJournalist" id="articleJournalist" checked class="d-none">
            <div class="container">
                <div class="row mx-md-2">
                    <div class="col-md-12">
                        <div class="" id="card_central">
                            <p>Based on <span class="font-weight-bold">{{sizeof($sendingNews)}} News Articles</span> <a class="pl-2 text-primary font-weight-bold"
                                    data-toggle="modal" data-target="#composeModal">
                                        View &gt;
                                </a></p>

                            <div class="my-2">
                                <div class="header mb-1">
                                    To
                                </div>
                                <div class="sandbox">
                                    <div class="d-none float-right" id="to_ErrorMsg" style="color:red;">Please write a message</div>

                                    <div class="input-group">
                                        <select type="text" id="list-tags" name="groups[]" multiple>
                                         @if(!empty($sendingNews))
                                         @foreach($sendingNews as $value)  
                                        <option selected value="{{$value->author_id}}">{{$value->author_name}}</option>
                                        @endforeach
                                        @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="d-none float-right mt-2" id="subjectErrorMsg" style="color:red;">Please select a subject</div>

                                    <label class="mt-3">Subject</label>

                                    <input data-validation="required" value="@if(!empty($campaign->title)) {{$campaign->title}} @endif" type="subject" name="title"
                                        class="form-control w-100" placeholder="Subject">
                                </div>

                                <div class="mt-3 w-100">
                                    <div class="d-none float-right" id="summer_note_ErrorMsg" style="color:red;">Please write a message</div>

                                    <label for="message">Message</label>

                                    <textarea data-validation="required" name="message" value="@if(!empty($campaign->text)){{$campaign->text}}@endif" id="summernote"></textarea>
                                    <input type="hidden" name="contact_journalist_id" value="{{$contact_journalist_id}}" />
                                </div>
                                <div class="text-right mt-2">
                                    <button type="button" class="btn btn-md btn-primary sendIconMessage" id="saveAsDraftButton">
                                                <i class="fa fa-save"></i> Save as draft</button>
                                    <button type="submit" class="btn btn-md btn-primary" id="sendMessageButton"><img src="{{asset('assets/images/sendToAll.svg')}}" class="svg sendToAll"> Send Message</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</main>

<div class="modal fade" id="composeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <h5 class="modal-title ">News Articles</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
            </div>
            <div class="modal-body">
                <section id="sectionModalCardCompose" class="pt-3">
                    <div class="container">
                        <div class="row mx-md-2">
                            <div class="col-md-12">
                                @if(!empty($sendingNews)) @foreach($sendingNews as $value)
                                <div class="card">
                                    <div class="text-right pr-3 pt-3 ">
                                        <span class="badge badge-pill badge-secondary p-2 mt-1">Music</span></div>
                                    <div class="card-body pt-0">

                                        <div class="media">
                                            <img class="articleImage d-flex mr-3 align-self-start rounded" src="{{$value->image}}">
                                            <div class="media-body">
                                                <h5>{{$value->title}}</h5>
                                                <p>{{$value->content}}</p>
                                            </div>
                                        </div>
                                        <p><span class="font-weight-bold">Author:</span><span>{{$value->author_name}}</span>
                                            <span class="font-weight-bold pl-4">Outlet:</span><span>{{$value->source_name }}</span></p>

                                    </div>
                                </div>
                                @endforeach @endif

                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </div>
    </div>
</div>

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


<script>
    var text = "@if(!empty($campaign->text))<?php echo (html_entity_decode($campaign->text, ENT_QUOTES)); ?>@endif"

</script>
<script src="{{asset('assets/js/jquery.form-validator.js')}}"></script>
<script src="{{asset('assets/js/selectize.js')}}"></script>
<script src="{{asset('assets/js/summernote-bs4.js')}}"></script>
<script src="{{asset('assets/js/individual_compose.js')}}"></script>
@endsection