@extends('layouts.appUser') 
@section('content')

<h1>Formatting keywords..</h1>




<script>
    function formatKeywords(){
        jQuery.ajax({
            method:'GET',
            url:'/format-keywords',
            success: function(data){
                if(data && data.count > 0){
                    console.log('###JOURNALISTS LEFT',data.count);
                    formatKeywords();
                }
            },
            error: function(error){
                console.log('###ERR',error)
            }
        })
    }
    formatKeywords()

</script>
@endsection