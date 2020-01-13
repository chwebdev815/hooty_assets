@extends('layouts.appUser') @section('title', 'Dashboard')
@section('content')
<script src="http://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{URL::route('index')}}">Frontend</a></li>
                        <li class="breadcrumb-item"><a href="{{URL::route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Send Message</li>
                    </ol>
                </div>
                <h4 class="page-title">Send Message</h4>
                @if(!empty($row))
                <div class="text-right">
                    <a href="javascript: void(0);" class="btn btn-primary ml-2 send_mail_btn">+ Send Message</a>
                </div>
                @endif
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        @if(!empty($row))
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{URL::route('sendMail')}}" method="post">
                        {{ csrf_field() }}
                        <div class="mailEditor">
                            <input type="text" name="title" id="title" class="form-control" placeholder="Subject" required="">

                            <span class="my_error">* Please Enter Subject</span>
                            <textarea name="message" id="message" class="message">{!! $row !!}</textarea>
                        </div>
                        <!-- Add Modal -->
                        <div class="modal" id="send_mail">
                            <div class="modal-dialog">
                              <div class="modal-content">
                              
                                <!-- Modal Header -->   
                                <div class="modal-header">
                                  <h4 class="modal-title">Select Group</h4>
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-striped table-bordered contacts-table table">
                                        @if(!empty($group))
                                        <tr>
                                            <th>
                                                <label class="checkbox-control">
                                                    <input class="selectall" name="selectall" type="checkbox">
                                                    <span class="check"><i class="fas fa-check"></i></span>
                                                </label>
                                            </th>
                                            <th>Group Name</th>
                                        </tr>
                                        @foreach($group as $value)
                                            <tr>
                                                <td>
                                                    <label>
                                                        <input class="checkbox" name="groups[]" type="checkbox" value="{{$value->id}}">
                                                        <span class="check"><i class="fas fa-check"></i></span>
                                                    </label>
                                                </td>
                                                <td>{{$value->name}}</td>
                                            </tr>
                                        @endforeach
                                        @else
                                        @endif
                                    </table>  
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-primary">Send Message</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        <!-- End Model -->
                    </form>
                </div>
            </div>
        </div>
        @endif
        @if(empty($row))
        <div class="col-xl-12">
            <div class="alert alert-info">
              <strong><h3>thanks for signing up to start your first campaign, click on the Hooty button below</h3></strong>
            </div>  
        </div>
        <div class="col-xl-12 text-right">
            <img src="{{asset('arrow.png')}}" class="arrow_create_chat_bot">
        </div>
        @endif
    </div>
    <!-- @if(!empty($row))
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3 text-center">Preview</h4>
                    <p>Hi {{ auth()->guard('web')->user()->first_name }}</p>
                    <p class="Preview_data">{!! $row !!}</p>
                    <p>Thanks,</p>
                    <p>{{ auth()->guard('web')->user()->first_name }} {{ auth()->guard('web')->user()->last_name }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif -->

</div>
<script>
    CKEDITOR.replace( 'message', {
      extraPlugins: 'uploadimage,image2',
    });

    /*CKEDITOR.instances.message.on('change', function(e) { 
        var desc = CKEDITOR.instances.message.getData();
        $(".Preview_data").html(desc);
    });*/
</script>
@endsection
