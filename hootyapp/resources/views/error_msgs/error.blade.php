@extends('layouts.appUser') @section('title', 'Dashboard') 
@section('content')


<main class="main">
           
            <section id="sectionGraph" class="pt-3  h-75 d-flex align-items-center">
                <div class="container ">
                    <div class="row mx-md-12 w-100">
                        <div class="col-lg-12 ">
                            <div class="card ">
                                <div class="card-body">
                                <div class="mr-auto text-center">
                                    <h4 class="pl-0">No reports found.</h4>
                                    <p class="text-muted">We have no new reports to show you .</p>
                                    <div class="">
                                    <a href="{{URL::route('searchJournalists')}}" class="btn btn-primary text-white d-block">Go to Search</a>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </section>
           
        </main>
        
            


        @endsection 