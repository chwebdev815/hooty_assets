@extends('admin.layouts.app') 
@section('title', 'Dashboard') 
@section('content')

<div id="main">


    <!-- //breadcrumb-->

    <div id="content">

        <div class="row">

            <div class="col-lg-12">

            </div>
            <!-- //content > row > col-lg-12 -->

        </div>
        <!-- //content > row-->

    </div>
    <!-- //content-->

    <footer id="site-footer">
        <section>&copy; Copyright 2014, By </section>
    </footer>

</div>

<!-- //main-->
<script type="text/javascript">
    var JournaList_delete = "<?php echo route('JournaList_delete')?>";

</script>
@endsection
 
@section('footer_script')