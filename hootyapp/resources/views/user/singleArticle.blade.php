@extends('layouts.appUser')
@section('title', 'Dashboard')
@section('content')
<link rel="stylesheet" href="{{asset('assets/css/selectize.default.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/bootstrap-multiselect.css')}}" type="text/css">
<!-- <link rel="stylesheet" href="{{asset('assets/css/loader.css')}}" type="text/css"> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.12/handlebars.js"></script>
<style>
	/*STYLE FOR ARTICLE>CARD>AUTHOR*/

	span.font-weight-bold {
		margin-left: 30px;
	}

	/*END*/

	#sectionTable {
		display: none;
	}
</style>

<main class="main">
	<section id="searchWidget" class="pt-3">
		<div class="container">
			<div class="row mx-md-2">
				<div class="col-md-12">
					<div id="articles" class="p-0">
						<section id="sectionDownCard" class=" mt-2 pt-3">
							<div class="float-right">
								<form class="d-inline-block float-right"
									action="{!! URL::route('subscribe_news_journalist') !!}" method="post">
									<input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
									<input value="{{$articleId}}" class="singleArticle" type="hidden" name="sub_news">
									<button class="btn btn-primary float-right"> <img
											src="{{asset('assets/images/sendToAll.svg')}}" class="svg sendToAll">
										Contact Journalist </button>
								</form>
							</div>
							<h4 class="article-title">Loading..</h4>

							<iframe width="100%" height="500" class="embed-responsive-item newsDisplayFrame" src=""
								allowfullscreen>
							</iframe>
						</section>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>



<script type="text/javascript">
	var api_url = "<?php echo \Config::get('app.api_url') ?>";

</script>
<script>
	$.ajax({
		url:api_url + "/v1/get-article/{{$articleId}}",
		success:function(article){
				var url = article.url;
				url = url.replace("http://", "https://");
				$('.article-title').html(article.title)
				$.ajax({
						type: "POST",
						url: "/check-url-good-for-iframe",
						data: {
								url: url
						},
						success: function(result) {
								console.log('DDATA', result);
								if (!result.success) {
										var win = window.open(url, 'newsWindow', 'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=600,height=600');
								} else {
										$('.newsDisplayFrame').attr('src', url);
								}
						},
						error: function() {

						}
				});
		}
	})

</script>
@endsection