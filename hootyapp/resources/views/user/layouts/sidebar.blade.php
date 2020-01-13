<link href="{{asset('userTheme/assets/css/pageWalkthrough/jquery.pagewalkthrough.css') }}" rel="stylesheet"
    type="text/css" />
<style>
    #walkthrough-content {
        display: none;
    }
</style>
<div class="sidebar">
    <nav class="sidebar-nav">
        <li class="nav-item nav-dropdown d-sm-down-show d-lg-none list-unstyled dropdown">
            <a class="nav-link nav-dropdown-toggle text-center" href="#"> <img class="img-avatar mx-auto d-block my-2">
                {{auth()->guard('web')->user()->first_name}}
                @if(empty(auth()->guard('web')->user()->image))

                <img class="img-avatar" src="{{asset('assets/img/avatars/6.jpg')}}">
                @else
                <img src="{{auth()->guard('web')->user()->image}}" alt="user-image" class="rounded-circle img-avatar">
                @endif
            </a>
            <ul class="nav-dropdown-items">
                <li class="nav-item">
                    <a class="nav-link" href="{{URL::route('profile')}}"> <i class="fa fa-user"></i> profile </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-none"
                        onclick="event.preventDefault(); document.getElementById('side-bar-logout-form').submit();"> <i
                            class="fa fa-lock"></i> Log out </a>
                </li>
                <form id="side-bar-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </ul>
        </li>
        <li class="nav-item list-unstyled text-center text-capitalize p-md-3 createPitchButton ">
            <button class="btn btn-primary " data-toggle="modal" data-target="#createCampaignModal"><i
                    class="fa fa-bullhorn" aria-hidden="true"></i> Create Pitch</button>
        </li>
        <ul class="nav">
            <li class="nav-item active">
                <a class="nav-link " href="{{URL::route('index')}}"> <i class="nav-icon fa fa-tachometer"></i>dashboard
                </a>
            </li>
            <li class="nav-item findJournilists">
                <a class="nav-link" href="{{URL::route('searchJournalists')}}"><i class="nav-icon fa fa-search"></i>Find
                    Journalists</a>
            </li>
            <li class="nav-item searchArticles">
                <a class="nav-link" href="{{URL::route('searchArticles')}}"><i class="nav-icon fa fa-search"></i>Search
                    Articles</a>
            </li>
            {{--
            <li class="nav-item ">
                <a class="nav-link" href="{{URL::route('message_create')}}"><i
                class="nav-icon fa fa-pencil"></i>Compose Pitch</a>
            </li> --}}
            <li class="nav-item bg-gray-900">
                <a class="nav-link" href="{{URL::route('list')}}"><i class="ml-4 nav-icon fa fa-list"></i>Journalist
                    Lists</a>
            </li>
            <li class="nav-item campaigns">
                <a class="nav-link" href="{{URL::route('campaigns')}}"><i class="nav-icon fa fa-bullhorn"></i>
                    campaigns</a>
            </li>
            <li class="nav-item bg-gray-900">
                <a class="nav-link" href="{{URL::route('message')}}"><i class="ml-4 nav-icon fa fa-envelope"></i>
                    inbox</a>
            </li>
            <li class="nav-item bg-gray-900">
                <a class="nav-link" href="{{URL::route('reports', ['mobile' => true])}}"><i
                        class="ml-4 nav-icon fa fa-line-chart"></i> reports</a>
            </li>
            {{--
            <li class="nav-item">
                <a class="nav-link" href data-toggle="modal" data-target="#videoComposer"><i class="nav-icon fa fa-video-camera"></i>Video Composer</a>
            </li> --}}
            <li class="nav-item newsJacking">
                <a class="nav-link" href="{{URL::route('news_alerts')}}"><i class="nav-icon fa fa-newspaper-o"></i>News
                    Jacking</a>
            </li>
            {{--
            <li class="nav-item">
                <a class="nav-link" target="_blank" href="https://hooty.zendesk.com"><i class="nav-icon fa fa-question-circle"></i>Support</a>
            </li> --}}
        </ul>
    </nav>
</div>
<div id="walkthrough-content">
    <div id="walkthrough-1">
        <div style="min-height:100px">
        </div>
        <div>
            <h1>Welcome to Hooty</h1>
        </div>
        Let's take you through a quick tour of Hooty's features that will help you to pitch your business to leading
        Journalists from popular news outlets.

        <p>Click "Next" to begin the journey.</p>

    </div>
    <div id="walkthrough-2">
        <div>
            <h1> Create Pitch </h1>
        </div>
        <div class="product-tour_mobile">
            <img src="{{asset('assets/images/sideBarScreenshot/pitch.png')}}" />
        </div>
        <div style="padding-top:20px"> Start your journey by "Creating a pitch" for Journalists</div>
    </div>

    <div id="walkthrough-3">
        <div>
            <h1> Find Journalists </h1>
        </div>
        <div class="product-tour_mobile">
            <img src="{{asset('assets/images/sideBarScreenshot/journalists.png')}}" />
        </div>
        <div style="padding-top:20px"> Find Journalists from various outlets using our Find Journalist feature.</div>
    </div>

    <div id="walkthrough-4">
        <div>
            <h1> Search Articles </h1>
        </div>
        <div class="product-tour_mobile">
            <img src="{{asset('assets/images/sideBarScreenshot/articles.png')}}" />
        </div>
        <div style="padding-top:20px"> Search for articles from Topics of your interest and contact the authors for
            pitching your business
        </div>
    </div>

    <div id="walkthrough-5">
        <div>
            <h1> Campaigns </h1>
        </div>
        <div class="product-tour_mobile">
            <img src="{{asset('assets/images/sideBarScreenshot/campaigns.png')}}" />
        </div>
        <div style="padding-top:20px"> Get an overview of your campaigns and its performance.</div>
    </div>

    <div id="walkthrough-6">
        <div>
            <h1> News Jacking <h1>
        </div>
        <div class="product-tour_mobile">
            <img src="{{asset('assets/images/sideBarScreenshot/news.png')}}" />
        </div>

        <div style="padding-top:20px"> Track your News Jacking subscriptions, and authors you have contacted. </div>

    </div>

</div>
<div id="videoComposer" class="modal fade" role="dialog">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-body" style="height:80%;padding:0px;">
                <div style="position:absolute;right:20px;top:10px;">
                    <button type="button" class="close" data-dismiss="modal" style="font-size:30px;">&times;</button>
                </div>
                <iframe allow="camera; microphone" id="moviemasher" frameborder="0" width="100%" height="100%"
                    src=""></iframe>
            </div>
        </div>
    </div>
</div>




<script>
    var video_url = "{{\Config::get('app.movie_masher_url')}}/angular-moviemasher/app/php/authenticate.php?token={{auth()->guard('web')->user()->id}}";
        $(document).ready(function(){
            $('#videoComposer').on('shown.bs.modal', function () {
                if(!$('#moviemasher').attr('src')){
                     $('#moviemasher').attr('src', video_url)
                }
            })
        })

</script>
<script src="{{asset('assets/js/index.js')}}"></script>
<script src="{{asset('userTheme/assets/js/pageWalkthrough/jquery.pagewalkthrough.js')}}"></script>