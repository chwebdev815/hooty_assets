@extends('layouts.appUser') 
@section('title', 'Dashboard') 
@section('content')
<main class="main wait-for-load">
    <section id="sectionHead" class="pt-3">
        <div class="container">
            <div class="row mx-md-2">
                <div class="col-md-12">
                    <h3 class="text-dark mb-0">{{!empty($group->name)? $group->name: "Untitled"}}</h3>
                </div>
            </div>
        </div>
    </section>
    <section id="sectionTable" class="pt-3">
        <div class="container">
            <div class="row mx-md-2">
                <div class="col-md-12">
                    <table id="example" class="display responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>NAME</th>
                                <th>OUTLETS</th>
                                <th>KEYWORDS</th>
                                <th>ACTION</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($listMembers)) @foreach($listMembers as $value)
                            <tr>
                                <td>{{$value->First_name}}</td>
                                <td>{{$value->Domain_name}}</td>
                                <td>{{$value->Outlet_Topic}}</td>
                                <td><a class="deleteJ text-danger" data-id="{{$value->id}}" href="#">Delete</a></td>
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

<script type="text/javascript" charset="utf8" src="{{asset('assets/js/individual_list.js')}}"></script>
@endsection