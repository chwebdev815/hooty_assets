<!DOCTYPE >
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title') | {{config('constants.SITE_NAME')}}</title>
        <link rel="stylesheet" href="https://opensource.keycdn.com/fontawesome/4.6.3/font-awesome.min.css" integrity="sha384-Wrgq82RsEean5tP3NK3zWAemiNEXofJsTwTyHmNb/iL3dP/sZJ4+7sOld1uqYJtE" crossorigin="anonymous">
        <link type='text/css' href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" />
        <link type='text/css' href="{{ asset('css/pricing.css')}}" rel="stylesheet" />
        <link type='text/css' href="{{ asset('fonts/awesome/css/font-awesome.min.css')}}" rel="stylesheet" />
        <link type='text/css' href='https://fonts.googleapis.com/css?family=Varela' rel='stylesheet'/>
        <link type='text/css' href="{{ asset('css/owl.carousel.css')}}" rel='stylesheet'/>
        <link type='text/css' href="{{ asset('date/css/datepicker.css')}}" rel='stylesheet' />
        <link type='text/css' href="{{ asset('css/owl.theme.css')}}" rel='stylesheet' />
        <link type='text/css' href="{{ asset('css/style.css') }}" rel="stylesheet" />
        <link type='text/css' href="{{ asset('css/common.css') }}" rel="stylesheet" />
        <link type='text/css' href="{{ asset('css/normalize.css') }}" rel="stylesheet" />
        <link type='text/css' href="{{ asset('css/demo.css') }}" rel="stylesheet" />
        <link type='text/css' href="{{ asset('css/tabs.css') }}" rel="stylesheet" />
        <link type='text/css' href="{{ asset('css/tabstyles.css') }}" rel="stylesheet" />
        <link type="text/css" href="{{ asset('fancybox/jquery.fancybox.css?v=2.1.5')}}" rel="stylesheet"  media="screen" />

        @if( count($campaign) > 0 )
	        <meta property="og:title" content="{{ $campaign->project_name }}">
			<meta property="og:description" content="{{ str_replace("\n"," ",strip_tags($campaign->overview)) }}">
			<meta property="og:image" content="{{ asset('upload/'.$campaign->campaign_image) }}">
			<meta property="og:url" content="{{ Request::url() }}">

			<meta name="twitter:title" content="{{ $campaign->project_name }} ">
			<meta name="twitter:description" content="{{ str_replace("\n"," ",strip_tags($campaign->overview)) }}">
			<meta name="twitter:image" content="{{ asset('upload/'.$campaign->campaign_image) }}">
			<meta name="twitter:card" content="{{ asset('upload/'.$campaign->campaign_image) }}">
		@endif

        <script type="text/javascript">
            var baseurl = "<?php echo URL::to('/') . "/"; ?>";
        </script>
        <!--[if IE 8]>
        <link href="style_ie8.css" rel="stylesheet" type="text/css" />
        <![endif]-->
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="loading-page">
            <img src="{{ asset('demos/image-preload/image.gif') }}" alt="Images-loading">
        </div>


        @include('layouts.navigation')

        @yield('content')
        @include('layouts.footer')
        <script type="text/javascript">
            var Desktop = 5, tabletportrait = 2, mobilelandscape = 1, mobileportrait = 1, resizeTimer = null;
        </script>
        <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/off-canvas.js')}}"></script>
        <script type="text/javascript" src="{{ asset('js/jquery.isotope.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/resize.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/custom-portfolio.js')}}"></script>
        <script type="text/javascript" src="{{ asset('js/owl.carousel.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/jquery.parallax-1.1.3.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/jquery.lightbox_me.js') }}"></script>
        <script type="text/javascript" src="{{ asset('date/js/bootstrap-datepicker.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admin/js/summernote/dist/summernote.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('fancybox/jquery.fancybox.js?v=2.1.5')}}"></script>
        <script type="text/javascript" src="{{ asset('fancybox/jquery.fancybox.pack.js?v=2.1.5')}}"></script>
        <script type="text/javascript" src="{{ asset('js/custom.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/modernizr.custom.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/cbpFWTabs.js') }}"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyA4rex-LOtcQeFSS0ehXS3wczlXf_TysP8&libraries=places"></script>
        

        @yield('footer_script')
        <script type="text/javascript">
            $(document).ready(function () {
                $(".fancybox").fancybox();
            });
        </script>
        <script>
            jQuery(function () {

                var appendthis = ("<div class='modal-overlay js-modal-close'></div>");

                $('a[data-modal-id]').click(function (e) {
                    e.preventDefault();
                    $("body").append(appendthis);
                    $(".modal-overlay").fadeTo(500, 0.7);
                    //$(".js-modalbox").fadeIn(500);
                    var modalBox = $(this).attr('data-modal-id');
                    $('#' + modalBox).fadeIn($(this).data());
                });


                jQuery(".js-modal-close, .modal-overlay").click(function () {
                    $(".modal-box, .modal-overlay").fadeOut(500, function () {
                        $(".modal-overlay").remove();
                    });

                });

                jQuery(window).resize(function () {
                    jQuery(".modal-box").css({
                        top: ($(window).height() - $(".modal-box").outerHeight()) / 2,
                        left: ($(window).width() - $(".modal-box").outerWidth()) / 2
                    });
                });

                jQuery(window).resize();

            });
        </script>
        <script type="text/javascript">
            $(function () {
                $("#dp3").datepicker();
                $("#dp4").datepicker();
            });
        </script>
        <script>
            function check_registertype()
            {

                var ngo = document.register_form.register_as.value;

                if (ngo == 5)
                {

                    $('#ngo_user').show();

                } else
                {
                    $('#ngo_user').hide();
                    $('#rest_users').show();
                }

            }
        </script>
        <script>
            (function () {

                [].slice.call(document.querySelectorAll('.tabs')).forEach(function (el) {
                    new CBPFWTabs(el);
                });

            })();
        </script>
    </body>
</html>