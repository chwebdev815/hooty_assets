@extends('layouts.appUser') 
@section('title', 'Dashboard') 
@section('content')

<main class="main wait-for-load">
    <form action="{!! URL::route('send_list_pitch') !!}" method="post">
        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
        <section class="pt-3">
            <div class="container">
                <div class="row mx-md-2">
                    <div class="col-md-12">
                        <h3 class="mt-1 text-dark float-left">Lists</h3>

                        <a href="{{URL::route('searchJournalists')}}" style="float: right;" class="ml-3 btn btn-primary text-light"><i class="fa fa-search"></i> Find Journalists</a>

                        <button type="submit" id="sendPitchButton" style="float: right;" class="btn btn-primary d-none text-light"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send Pitch</button>
                    </div>
                </div>
            </div>
        </section>

        <section class="pt-3">
            <div class="container">
                <div class="row mx-md-2">
                    <div class="col-md-12">

                        <table id="listPageTable" class="display responsive nowrap" style="width:100%">
                            <thead>
                                <tr>

                                    <th><input type="checkbox" class="checkAll" onchange="selectingAllCheckBox()"></th>
                                    <th>Name</th>
                                    <th>NO OF RECIPIENTS</th>
                                    <th width="10%">ACTIONS</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($lists)) @foreach($lists as $value)
                                <tr>
                                    <td><input type="checkbox" class="listTableCheckbox" name="lists[]" onchange="sendPitchButtonToggle()"
                                            value='{{$value->name}}'></td>
                                    <td>{{$value->name}}</td>
                                    <td>{{$value->count}}</td>
                                    <td><a class="deleteJ text-danger" data-id="{{$value->id}}" href="#">Delete</a> &nbsp;&nbsp;
                                        <a href="{{URL::route('individualList',['id' => $value->id])}}" class="mr-3">View &gt;</a>
                                    </td>
                                </tr>
                                @endforeach @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </form>
</main>

<script type="text/javascript" charset="utf8" src="{{asset('assets/js/sweet_alert.js')}}"></script>

<script type="text/javascript" charset="utf8" src="{{asset('assets/js/list.js')}}"></script>

<script>
    function sendPitchButtonToggle() {
        var sendPitchButton = [];
        $.each($('input[name="lists[]"]:checked'), function() {
            sendPitchButton.push($(this).val());
         });
         
         console.log(sendPitchButton.length);
         if(sendPitchButton.length > 0){
             $('#sendPitchButton').removeClass('d-none');
         }else{
            $('#sendPitchButton').addClass('d-none');
         }
       }

       function selectingAllCheckBox() {

        
            var isChecked = $(".checkAll").is(":checked");
            if (isChecked) {
                // alert("CheckBox checked.");
                $('.listTableCheckbox').attr('checked',true);
                $('#sendPitchButton').removeClass('d-none');
            } else {
                // alert("CheckBox not checked.");
                $('.listTableCheckbox').attr('checked',false);
                $('#sendPitchButton').addClass('d-none');
            }
    
        }

</script>
@endsection