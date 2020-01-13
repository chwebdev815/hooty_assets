@extends('layouts.appUser') 
@section('title', 'Dashboard') 
@section('content')

<main class="main wait-for-load">
    <section id="sectionHead" class="pt-3">
        <div class="container">
            <div class="row mx-md-2">
                <div class="col-md-12">
                    <h3 class="text-dark">Campaigns</h3>
                </div>
            </div>
        </div>
    </section>
    <section id="sectionTableCampaign" class="pt-3">
        <div class="container">
            <div class="row mx-md-2">
                <div class="col-md-12">
                    <table id="campDtable" class="display responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>CAMPAIGN NAME</th>
                                <th>DATE</th>
                                <th>SENT</th>
                                <th>DELIVERED</th>
                                <th>READ</th>
                                <th>MESSAGES</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($chat_log)) @foreach($chat_log as $value)
                            <tr>
                                @if($value->msg_status == 0)
                                <td>{{$value->title}}</td>
                                @else
                                <td>{{$value->title}}<span class="ml-2 badge badge-primary badge-pill">Draft</span></td>
                                @endif @if(!empty($value->Date))
                                <td>{{ date('F, d, Y', strtotime($value->Date)) }} </td>
                                @else
                                <td>0</td>
                                @endif @if(!empty($value->Send))
                                <td>{{$value->Send}}</td>
                                @else
                                <td>0</td>
                                @endif @if(!empty($value->Delivery))
                                <td>{{$value->Delivery}}</td>
                                @else
                                <td>0</td>
                                @endif @if(!empty($value->Open))
                                <td>{{$value->Open}}</td>
                                @else
                                <td>0</td>
                                @endif @if(!empty($value->MsgsCount))
                                <td><a href="{{URL::route('message_show_chatrooms',['id' => $value->campaign_id])}}">{{$value->MsgsCount}}</a></td>
                                @else
                                <td>0</td>
                                @endif @if($value->msg_status == 0)
                                <td><a class="text-danger deleteJ" href="" data-id="{{$value->campaign_id}}">Delete </a> &nbsp;
                                    <a href="{{URL::route('individualCampaign',['id' => $value->campaign_id])}}">View &gt;</a></td>
                                @else
                                <td>
                                    </a> <a class="text-danger deleteJ" href data-id="{{$value->campaign_id}}">Delete </a> &nbsp;
                                    @if(!empty($value->contact_journalist_id))
                                    <a href="{{URL::route('individualCompose',['id' => $value->contact_journalist_id])}}">View draft &gt;                                   </td>
                                    @else
                                        <a href="{{URL::route('campaign_edit',['id' => $value->campaign_id])}}">View draft &gt;                                   </td>
                                    @endif
                                @endif
                            </tr>
                            @endforeach @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>
<script type="text/javascript" charset="utf8" src="{{asset('assets/js/sweet_alert.js')}}"></script>
<script type="text/javascript" charset="utf8" src="{{asset('assets/js/campaigns.js')}}"></script>
@endsection