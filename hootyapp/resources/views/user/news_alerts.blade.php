@extends('layouts.appUser')
@section('title', 'Dashboard')
@section('content')
<main class="main">
    <section id="newsAlert" class="pt-3 activeStage ">
        <div class="container">
            <div class="row mx-md-2">
                <h3 class="text-dark pl-3">News Jacking</h3>
            </div>

            <div class="row mx-md-2 mt-3 h-100">

                <div class="col-md-12 h-100">
                    <ul class="nav  nav-tabs">
                        <li class="nav-item ">
                            <a class="nav-link" data-toggle="tab" i href="#journalists">Journalists</a>
                        </li>
                        <li class="nav-item" id="sijo">
                            <a class="nav-link active" data-toggle="tab" href="#subscribed_alerts"
                                id="example1">Subscribed
                                Alerts</a>
                        </li>
                    </ul>

                    <div class="tab-content  mt-2 mb-2 h-100">
                        <div id="journalists" class="container tab-pane p-0 h-100">
                            <!-- <div class="input-group py-2 d-none" id="news_alert_search">
                                        <input type="text" class="form-control p-2" placeholder="Search for Journalists">
                                        <div class="input-group-append" >
                                            <button class="btn searchBtn bg-primary px-md-4" type="button"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div> -->
                            <div class="row h-100">
                                <div
                                    class="col-md-12 text-center h-100 d-flex align-items-center justify-content-center ">
                                    <h5 class="p-5">Coming soon!</h5>
                                </div>
                            </div>


                        </div>
                        <div id="subscribed_alerts" class="container tab-pane active p-0 h-100">
                            <input type="hidden" value="{{ csrf_token() }}" id="token">
                            <table id="example" class="display responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>PHRASE</th>
                                        <th>OUTLETS</th>
                                        <th>STARTED ON</th>
                                        <th>LAST ALERT</th>
                                        <th>ACTIONS</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($news_alerts)) @foreach($news_alerts as $value)
                                    <tr>
                                        <td>{{$value->search_phrases}}</td>

                                        @if(empty($value->outlets) || ($value->outlets) == "null")
                                        <td> All Outlets</td>
                                        @else
                                        <td>{{ ucwords(join(", " , (array)json_decode($value->outlets))) }}</td>
                                        @endif
                                        <td>{{ date('F, d, Y', strtotime($value->created_at)) }} </td>
                                        <td>{{ date('F, d, Y', strtotime($value->updated_at)) }}</td>
                                        <td><a class="unsubscribeA" data-id="{{$value->id}}" href="#">Unsubscribe
                                                &gt;</a></td>
                                    </tr>
                                    @endforeach @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<div class="modal" id="iframeViewModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">News Alerts</h5>
                <button class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item newsDisplayFrame" src="" allowfullscreen></iframe>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var journalistNumber = <?php echo $journalists?>;

var app_url = "<?php echo \Config::get('app.url') ?>";

</script>
<script type="text/javascript" charset="utf8" src="{{asset('assets/js/sweet_alert.js')}}"></script>


<script type="text/javascript" charset="utf8" src="{{asset('assets/js/news_alert.js')}}"></script>
@endsection