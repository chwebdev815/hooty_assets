@extends('layouts.appUser') @section('title', 'Video')
@section('content')


  <link href="{{asset('assets/css/video-js.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/css/videojs.record.css')}}" rel="stylesheet">

    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{URL::asset('assets/css/dropzone.css')}}" />

    <style>
    .video-js{
        max-width : 100% !important;
    }
    .modal-full {
        max-width: 100% !important;
    }

    </style>

<main class="main wait-for-load">
    <section id="videoActivitySection" class="pt-3">
        <div class="container">
            <div class="row m-md-2">
                <div class="col-sm-12 pt-5">
                    <h3 class="text-dark d-inline-block my-2 m-md-2">Videos</h3>
                    <div class="float-md-right">
                    <a class="btn btn-primary text-white my-2 m-md-2" data-toggle="modal" data-target="#uploadVideoModal">UPLOAD</a>
                    <a class="btn btn-primary text-white my-2 m-md-2" data-toggle="modal" data-target="#webCamPopup">RECORD</a>
                    <a class="btn btn-dark text-white my-2 m-md-2" data-toggle="modal" data-target="#editPopup">LAUNCH EDITOR</a>
                    </div>
                </div>
                <div class="col-sm-12 pt-3">
                    <table id="dashDtable" class="display responsive nowrap" style="width:100%;">
                        <thead>
                            <tr>
                                <th width="10%"></th>
                                <th  class="py-3">TITLE</th>
                                <th>CREATED ON</th>
                                <th>ACTIONS</th>
                                <!-- <th>REPLIED</th> -->
                            </tr>
                        </thead>
                        <tbody>
                        @if(!empty($videos))
                                @foreach($videos as $value)
                            <tr>
                                <td>
                                    <div class="text-center">
                                        <img src="https://via.placeholder.com/150">
                                    </div>
                                </td>
                                <td>{{$value->name}}</td>
                                <td>{{date('F, d, Y', strtotime($value->created_at))}}</td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#videoView" class="mr-3" type="link">View &gt;</a>
                                    <a class="deleteJ" data-id="{{$value->id}}" href="#">Delete &gt;</a>
                                </td>
                            </tr>
                            @endforeach
                           @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>

<input type="hidden" value="{{ csrf_token() }}" name="_token" id="token"> </div>
<!-- WebCamModal -->
<div class="modal fade" id="webCamPopup" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header card-header">
        <h5 class="modal-title" id="exampleModalLabel">Record Video</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <video id="myVideo" class="video-js vjs-default-skin"></video>

      </div>
      <div id="webCamDropzone">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="videoSaveBtn">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- EDIT MODAL -->
<div class="modal fade p-0 m-0" id="editPopup" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-full p-0 m-0 h-100" role="document">
    <div class="modal-content h-100">
      <div class="modal-header card-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Video</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="videoSaveBtn">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- VIEW BUTTON MODAL -->
<div class="modal fade" id="videoView" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header card-header">
        <h5 class="modal-title" id="exampleModalLabel">Record Video</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="videoSaveBtn">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal UPLOAD -->
<div class="modal fade" id="uploadVideoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload Video</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center p-0 dropzone">
                <form action="https://hooty.s3.amazonaws.com/" id="s3dropzone">
                    <div class="fallback">
                        <input name="file" type="file" multiple />
                    </div>
                    <span id="upload-area" style="display: block; pointer-events:none;" class="pb-5">
                        <div class="upload-info pt-5">
                            <i id="dropzoneFA"></i>
                            <i id="dropzoneFA1" class="fa fa-cloud-upload fa-5x"></i>
                            <h3 id="dropzoneFA2" class="pt-3">DRAG &amp; DROP<br>OR<br>CLICK HERE TO UPLOAD THE VIDEO</h3>
                        </div>
                    </span>
                </form>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
var api_url = "<?php echo \Config::get('app.api_url') ?>";
var aws_upload_url = "/ajax/request-s3-file-signature";
</script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="{{asset('assets/js/video/video.min.js')}}"></script>
<script src="{{asset('assets/js/video/RecordRTC.js')}}"></script>
<script src="{{asset('assets/js/video/adapter.js')}}"></script>
<script src="{{asset('assets/js/video/videojs.record.js')}}"></script>
<script type="text/javascript" charset="utf8" src="{{asset('assets/js/sweet_alert.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/5.0.7/highcharts.js"></script>
<!-- <script src="{{asset('assets/js/index.js')}}"></script> -->
<script src="{{asset('assets/js/video.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.js"></script>

@endsection