@extends('layouts.appUser') @section('title', 'Dashboard')
@section('content')

   <link rel="stylesheet" href="{{asset('assets/css/selectize.default.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-multiselect.css')}}" type="text/css">
<style>
#sectionTable{
    display:none;
}
</style>

  <main class="main">
            <section id="searchWidget" class="pt-3">
                <div class="container">
                    <div class="row mx-md-2">
                        <div class="col-md-12">
                            <ul class="nav  nav-tabs">
                                <li class="nav-item ">
                                    <a class="nav-link active" data-toggle="tab" href="#home">Journalist</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#menu1">Articles</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="home" class="container tab-pane active p-0">

                                    <div class="bg-primary p-4" id="Wraping input and form">
                                        <div class="input-group">
                                            <input type="text" id="search" class="form-control p-2" placeholder="Type name of journalist,outlet or keyword to search">
                                            <div class="input-group-append">
                                                <button id="searchTableButton" class="btn searchBtn px-md-4" type="button"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                        <div class=" mt-2 align-middle">
                                            <label class="checkboks "><span>Name</span>
                                 <input type="checkbox" checked="checked">
                                 <span class="checkmark"></span>
                                </label>
                                            <label class="checkboks">Outlets
                                 <input type="checkbox">
                                 <span class="checkmark"></span>
                                 </label>
                                            <label class="checkboks">Keywords
                                 <input type="checkbox">
                                 <span class="checkmark"></span>
                                 </label>
                                        </div>

                                    </div>
                                    

                                    <section>
                                   
                                        <div>
                                            <div class="row my-3">
                                                <div class="col-md-6 text-left">
                                                    <p class="mt-2">Found <strong> <span class="journalist-count"> </span> Journalists</strong></p>
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <button class="btn btn-primary" data-toggle="modal" data-target="#createlistModal">
                                                        <i class="fa fa-pencil-square-o"></i>  Create List
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-md-12">
                                            <form action="{!! URL::route('group_store') !!}" method="post">
                        {{ csrf_field() }}
                        <table   class="table table-striped dt-responsive nowrap table-fixed-header">
                        <thead id="myHeader">
                            <tr>
                                <th>
                                    <button type="button" class="btn btn-outline-secondary btn-sm">
                                        <div class="custom-control custom-checkbox" style="min-height: 1rem;">
                                            <input type="checkbox" class="custom-control-input" id="allselect">
                                            <label class="custom-control-label select_box_margin" for="allselect"></label>
                                            Select All
                                        </div>
                                    </button>
                                </th>
                                <th colspan="2">
                                    <button type="button" class="btn btn-outline-secondary btn-sm count_btn">
                                        
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm count_selected_btn">
                                        <sam class="total_record">0</sam> - <sam class="view_record">Record Selected</sam>
                                    </button>
                                </th>
                                <th colspan="1" class="myth">
                                    <div class="text-right ">
                                        <a href="javascript: void(0);" class="btn btn-primary ml-2" data-toggle="modal" data-target="#addGroup">+ Add List</a>
                                    </div>
                                </th>
                            </tr>
                            <tr class="select_all_record_label">
                                <th colspan="1"></th>
                                <th colspan="2">
                                    <button type="button" class="btn btn-outline-primary btn-rounded all_row_seleced">
                                        
                                    </button>
                                    <button type="button" class="btn btn-outline-success btn-rounded all_row_remove_seleced live_search">
                                        
                                    </button>
                                </th>

                            </tr>
                            <tr>
                                <th width="15%">Select</th>
                                <th width="30%">Name</th>
                                <th width="20%">Outlet</th>
                                <th>Keywords</th>
                            </tr>
                        </thead>
                        <tbody class="list_data" id="list_data">

                        </tbody>
                    </table>
                    <div class="modal fade" id="createlistModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
                </div>
               
                    <div class="modal-body">
                        <p class="text-muted">Choose from existing list or type a new name to create a list</p>
                        <div class="my-2">
                            <div class="header mb-1 text-muted">
                                Lists Name
                            </div>
                        
                            <div class="sandbox w-80">
                                <div class="input-group">
                                    <select name="name" id="list_tags">
                                        @if(!empty($data))
                                            @foreach($data as $value)
                                                <option value="{!! $value->name !!}" style="background:red">{{$value->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                        <div class="modal-footer" style="border:none !important;">
                            <button type="submit" class="btn btn-primary" >Save changes</button>
                        </div>
                    </div>
               
            </div>
        </div>
    </div>

                </form>
                                                </div>              

                                            </div>  
                                        </div>
                                    </section>

                                    
                                </div>


                                <div id="menu1" class="tab-pane fade p-0">
                                    <div class="bg-primary p-4">
                                        <div class="input-group">
                                            <input type="text" class="form-control p-2" value="Music at work">
                                            <div class="input-group-append btn-group">
                                                <select class="btn dropdown-toggle articleButton" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="example-getting-started" multiple="multiple">
                                                        <option value="tech">Tech</option>
                                                        <option value="health">Health</option>
                                                        <option value="politics">Politics</option>
                                                    </select>

                                                <button class="btn searchBtn px-md-4" type="button"><i class="fa fa-search"></i></button>

                                            </div>
                                        </div>
                                    </div>

                                    <section id="sectionDownCard" class=" mt-2 pt-3">
                                        <div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row mb-3">
                                                        <div class="col-md">
                                                            <p>2 results found for "Music at Work" <span class="text-primary pl-2 font-weight-bold">Subscribe for alerts<i class="fa fa-lg fa-exclamation-circle card-link text-secondary ml-1" data-toggle="tooltip" data-placement="right" title="Latest News alerts based on search query will be mailed to you"></i>
                                                                </span></p>
                                                        </div>

                                                        <div class="col-md">
                                                            <a class="btn btn-primary float-right" id="btnSendToAll" href="{{URL::route('individualCompose')}}"><i class="fa  fa-paper-plane" aria-hidden="true"></i>  Send to All</a>

                                                        </div>
                                                    </div>


                                                    <div class="card">
                                                        <div class="text-right pr-3 pt-3 ">
                                                            <span class="badge badge-pill badge-secondary p-2 mt-1">Music</span></div>
                                                        <div class="card-body pt-0">
                                                            <label class="checkboks_blue float-left">
                                                                        <input type="checkbox" checked="checked">
                                                                        <span class="checkmark_blue"></span>
                                                                            </label>
                                                            <div class="media">
                                                                <img class="d-flex mr-3 align-self-start rounded" src="{{asset('assets/images/1.jpg')}}">
                                                                <div class="media-body">
                                                                    <h5>Top aligned media</h5>
                                                                    <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc
                                                                        ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
                                                                </div>
                                                            </div>
                                                            <p><span class="font-weight-bold">Author:</span><span> Kristien Hunt</span><span class="font-weight-bold pl-4">Outlet:</span><span> Entreprenuer</span>
                                                                <a class="btn btn-primary float-right" href="{{URL::route('individualCompose')}}"> <img src="{{asset('assets/images/sendToAll.svg')}}" class="svg sendToAll"> Send Message
                                                                </a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="card">
                                                        <div class="text-right pr-3 pt-3">
                                                            <span class="badge badge-pill badge-secondary  p-2 mt-1">Success Stories</span> </div>
                                                        <div class="card-body pt-0">
                                                            <label class="checkboks_blue float-left">
                                                                        <input type="checkbox" checked="checked">
                                                                        <span class="checkmark_blue"></span>
                                                                            </label>
                                                            <div class="media">
                                                                <img class="d-flex mr-3 align-self-start rounded" src="{{asset('assets/images/2.jpg')}}">
                                                                <div class="media-body">
                                                                    <h5>Top aligned media</h5>
                                                                    <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc
                                                                        ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
                                                                </div>
                                                            </div>
                                                            <p><span class="font-weight-bold">Author:</span><span> Andrew Medal</span><span class="font-weight-bold pl-4">Outlet:</span><span> Forbes magazine</span>
                                                                <a class="btn btn-primary btnRelative float-right" href="{{URL::route('individualCompose')}}"><img src="{{asset('assets/images/sendToAll.svg')}}" class="svg sendToAll"> Send Message</a>
                                                            </p>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


        </main>
        <!-- <div class="modal fade" id="createlistModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
                </div>
                <form action="{!! URL::route('group_store') !!}" method="post">
                        {{ csrf_field() }}
                    <div class="modal-body">
                        <p class="text-muted">Choose from existing list or type a new name to create a list</p>
                        <div class="my-2">
                            <div class="header mb-1 text-muted">
                                Lists Name
                            </div>
                        
                            <div class="sandbox w-80">
                                <div class="input-group">
                                    <select name="name" id="list_tags">
                                        @if(!empty($data))
                                            @foreach($data as $value)
                                                <option value="{{!! $value->id !!}}" style="background:red">{{$value->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                        <div class="modal-footer" style="border:none !important;">
                            <button type="submit" class="btn btn-primary" >Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div> -->
    </div>




<script type="text/javascript">
    var url = "<?php echo route('contact_index')?>";
    $(document).ready(function() {
     $(document).keypress(function(e) {
        console.log("hello");
        if(e.which == 13) {
            var page = 1;
            $(".list_data").html('');
            $("#selected").val(0);
            $(".select_all_record_label").hide();
            $('#allselect').prop('checked', false);
            $(".count_selected_btn").html('<sam class="total_record">0</sam> - <sam class="view_record">Selected</sam>');
            var name = $("#search").val();

            var data = {
                'search' : name,
                'page' : page,
                'type' : 'all'
            }
            $.ajax({
                dataType: 'json',
                url: url+ '/',   
                data: data
            }).done(function(data){
                console.log(data);
                $(".search_deta_box").attr('style',"display: block;");

                var rows = '';
                $.each( data.journalist, function( key, value ) {
                    rows = rows + '<tr>';
                    rows = rows + '<td width="15%"><div class="custom-control custom-checkbox"><input type="checkbox" value="'+value.id+'" name="groups[]" class="custom-control-input select_all" id="checkmeout_'+value.id+'"><label class="custom-control-label select_box_margin" for="checkmeout_'+value.id+'"></label></div></td>';
                    rows = rows + '<td width="30%">'+value.First_name+' '+value.Last_name+'</td>';
                    rows = rows + '<td width="20%">'+value.Domain_name+'</td>';
                    rows = rows + '<td></td>';
                    rows = rows + '</tr>';
                });


                $(".list_data").html(rows);
                $(".count_btn   ").html('<sam class="total_record">'+data.journalist.length+'</sam> - <sam class="view_record">'+data.journalist_count+'</sam>');
                var t_page = $("#t_record").val(data.journalist_count);
                var no_record = $("#no_record").val(data.journalist.length);
            });
        }
    });
});
</script>


<script src="{{asset('userTheme/assets/js/search.js') }}"></script>
@endsection