@extends('layouts.appUser') @section('title', 'Dashboard') 
@section('content')

   <main class="main wait-for-load">
            <section class="pt-3">
                <div class="container">
                    <div class="row mx-md-2">
                        <h3 class="text-dark d-block-inline ml-3">{{ $campaign->title }} </h3> <span class="m-0 badge badge-pill badge-secondary ml-2 mt-2 pl-1 pt-1 text-center d-block-inline" style="height: 20px">Press Pitch</span> </div>
                </div>
            </section>
            <section id="sectionBoxes" class="pt-3">
                <div class="container">
                    <div class="row mx-md-2">
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h1>{!! $campaign->Send ? $campaign->Send : 0 !!}</h1>
                                    <p class="text-muted mb-0">Send</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h1>{!! $campaign->Delivery ? $campaign->Delivery : 0 !!}</h1>
                                    <p class="text-muted mb-0">Delivered</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h1>{!! $campaign->Open ? $campaign->Open : 0 !!}</h1>
                                    <p class="text-muted mb-0">Opened</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h1>{!! $campaign->Click ? $campaign->Click : 0 !!}</h1>
                                    <p class="text-muted mb-0">Replied</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section id="sectionMessage" class="pt-3">
                <div class="container">
                    <div class="row mx-md-2">
                        <h5 class="text-dark pl-3">Message</h5>
                    </div>
                    <div class="row mx-md-2">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="more">{!! $campaign->text !!} </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section id="sectionTable" class="pt-3">
                <div class="container">
                    <div class="row mx-md-2">
                        <div class="col-md-12">
                            <h5 class="text-dark">Listwise Report</h5>
                        </div>
                        <div class="col-md-12">
                            @if(!empty($listwise_reports && sizeof($listwise_reports) > 0))
                            <table id="listWiseReport" class="display responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>LIST NAME</th>
                                        <th>NO.OF RECIPIENTS</th>
                                        <th>DELIVERED</th>
                                        <th>OPENED</th>
                                        <th>REPLIED</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                        @foreach($listwise_reports as $value)
                                        <tr>
                                            <td>{{$value->name}}</td>
                                            <td>{{round(sqrt($value->TotalMembers))}}</td>
                                            <td>{{$value->Delivery}}</td>
                                            <td>{{$value->Open}}</td>
                                            <td>{{$value->Click}}</td>
                                            <!-- <td>3</td> -->
                                        </tr>
                                        @endforeach
                                    
                                </tbody>
                            </table>
                            @elseif (!empty($journalist_wise_reports && sizeof($journalist_wise_reports) > 0))
                            <table id="listWiseReport" class="display responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>JOURNALIST</th>
                                        <th>DELIVERED</th>
                                        <th>OPENED</th>
                                        <th>REPLIED</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($journalist_wise_reports as $value)
                                    <tr>
                                        <td>{{$value->First_name}}</td>

                                        @if($value->Delivery > 0)
                                        <td><i class="fa fa-check"></i></td>
                                        @else
                                        <td>-</td>
                                        @endif

                                        @if($value->Open > 0)
                                        <td><i class="fa fa-check"></i></td>
                                        @else
                                        <td>-</td>
                                        @endif

                                        @if($value->Click > 0)
                                        <td><i class="fa fa-check"></i></td>
                                        @else
                                        <td>-</td>
                                        @endif
                                        <!-- <td>3</td> -->
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <script type="text/javascript" charset="utf8" src="{{asset('assets/js/individual_campaign.js')}}"></script>

        @endsection 