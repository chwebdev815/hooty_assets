@extends('layouts.appUser') @section('title', 'Dashboard') @section('content')
<link rel="stylesheet" href="{{asset('assets/css/selectize.default.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/bootstrap-multiselect.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('assets/css/loader.css')}}" type="text/css">
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
<!-- <script>
function sijo() {
	var that = $('.newsDisplayFrame');
	console.log("that",that);
	console.log("thattttttt",that.contentWindow.document);
   try{
        that.contentDocument;
   }
   catch(err){
        console.log("errorr",err);
   }
}
</script> -->
<main class="main">
	<section id="searchWidget" class="pt-3">
		<div class="container">
			<div class="row mx-md-2">
				<div class="col-md-12">
					<div id="articles" class="p-0">
						<section id="sectionDownCard" class=" mt-2 pt-3">
							<div class="card d-none noresults">
								<p>
									<h3 class="text-center">No Results, Try again</h3>
								</p>
							</div>
							<div>
								<div class="row">
									<div class="col-md-12">
										<form action="{!! URL::route('subscribe_news_journalist') !!}" method="post">
											<div class="row mb-3">
												<div class="col-md d-none" id="buttonToshowAlerts">
													<span id="keyAndCount">
														<span class="totalResults font-weight-bold ml-0"></span>
													</span>
													<input type="hidden" value="{{ csrf_token() }}" name="_token"
														id="token"> </div>
												<div class="col-md"> <button class="btn btn-primary float-right d-none"
														type="submit" id="btnSendToAll"><i class="fa  fa-paper-plane"
															aria-hidden="true"></i> Send to All</button> </div>
											</div>
											<!-- HANDLE BAR TRAIL  -->
											<div class="text-center d-none loader">
												<div class="lds-default">
													<div></div>
													<div></div>
													<div></div>
													<div></div>
													<div></div>
													<div></div>
													<div></div>
													<div></div>
													<div></div>
													<div></div>
													<div></div>
													<div></div>
												</div>
											</div>

											<div class="data-articles">

											</div>
										</form>
									</div>
								</div>
							</div>
						</section>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>

<script id="articleCards" type="text/x-handlebars-template">
	<div class="card">
	<div class="text-right pr-3 pt-3 "> <span class="badge badge-pill badge-secondary p-2 mt-1 articleGenre"></span></div>
	<div class="card-body pt-0">
		<label class="checkboks_blue float-left">
			<input class="selectedArticles" type="checkbox" name="sub_news[]" onchange="sendAllButtonToggle()"> <span class="checkmark_blue"></span> </label>
		<div class="media "> <img class="articleImage d-flex mr-3 align-self-start rounded" src="">
			<div class="media-body">
			<a data-toggle="modal" class="iframeModal2 tttt" data-url="" data-target="#iframeViewModal" href="#"><h5></h5></a>
				<p class="articleContent"></p>
				<h6 class="align-middle"></h6></h6>
			</div>
		</div>
		<p>
		 <span class="font-weight-bold">Author:</span><span class="articleAuthor"></span>
		 <span class="font-weight-bold pl-4">Outlet:</span>
		 <span class="articleOutlet"></span>
		 <span class="date pl-4"><i class="fa fa-clock-o"></i> <span></span></span>
		
		<form action="{!! URL::route('subscribe_news_journalist') !!}" method="post">
		<input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
			<input class="singleArticle" type="hidden" name="sub_news">
			<button class="btn btn-primary float-right" > <img src="{{asset('assets/images/sendToAll.svg')}}" class="svg sendToAll"> Send Message </button>
			</form>
		</p>
	</div>
</div>
</script>



<div class="modal" id="iframeViewModal" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">News</h5>
				<button class="close" data-dismiss="modal">×</button>
			</div>
			<div class="modal-body">
				<div class="embed-responsive embed-responsive-16by9">
					<iframe class="embed-responsive-item newsDisplayFrame" src="" allowfullscreen></iframe>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	var phrases;
	var outlets;
	var genre
	@if(!empty($data))
		 phrases = "<?php echo $data->search_phrases?>";
		 outlets = "<?php echo json_decode($data->outlets)?>";
	@endif
	var api_url = "<?php echo \Config::get('app.api_url') ?>";
</script>

<script type="text/javascript" charset="utf8" src="{{asset('assets/js/jquery.timeago.js')}}"></script>
<script src="{{asset('userTheme/assets/js/subscribed_news.js') }}"></script> @endsection