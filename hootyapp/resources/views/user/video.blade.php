<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">



<link type="text/css" rel="stylesheet" href="{{URL::asset('assets/css/dropzone.css')}}" />
<link href="https://vjs.zencdn.net/7.3.0/video-js.css" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
    crossorigin="anonymous">

<style>
    body {
        background: #000;
    }

    .video-js {
        max-width: 100%;
        margin: auto;
    }

    .vjs-big-play-button {
        display: none;
    }

    .modal-full {
        max-width: 100% !important;
    }
</style>

<main class="main">
    <section id="videoActivitySection" class="pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-8 offset-md-2 text-center">
                    <a href="/">
                            <img  height="100px" src="{{asset('assets/img/logo.png')}}" alt="Hooty">
                        </a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-8 offset-md-2 offset-0 pt-5 text-center">
                    <video id="my-video" autoplay class="video-js vjs-fluid" controls preload="auto" height="500" data-setup={}>
                                <source src="{{$video_path}}" type='video/mp4'>
                                <p class="vjs-no-js">
                                To view this video please enable JavaScript, and consider upgrading to a web browser that
                                <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                                </p>
                        </video>
                </div>
            </div>
        </div>
    </section>
</main>

<script src="https://vjs.zencdn.net/7.3.0/video.js"></script>
<script>
    videojs('my-video', {autoplay: true, fluid:true});

</script>