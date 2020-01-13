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
					<h3 class="text-dark mb-4">Search Articles</h3>
					<div id="articles" class="p-0">
						<div class="bg-primary p-4">
							<div class="input-group">
								<!-- <form  action="/" id="registerSubmit"> -->
								<input id="articleInput" type="text" class="form-control p-2" placeholder="Search">
								<button class="	 d-sm-block d-md-none  btn search-articles px-md-4" type="button"><i
										class="fa fa-search"></i></button>
								<div class="input-group-append  btn-group">
									<select class="btn dropdown-toggle col-sm articleButton" type="button" data-toggle="dropdown"
										aria-haspopup="true" aria-expanded="false" id="outlets" multiple="multiple">
										<option value="entrepreneur">Entrepreneur</option>
										<option value="forbes">Forbes</option>
										<option value="inc">Inc</option>
										<option value="mashable">Mashable</option>
										<option value="techcrunch">TechCrunch</option>
										<option value="the-wall-street-journal">The Wall Street Journal</option>
										<option value="the-next-web">The Next Web</option>
										<option value="business-insider">Business Insider </option>
										<option value="cnbc">CNBC </option>
										<option value="venture-beat">VentureBeat</option>
									</select>

									<button class="	d-sm-none d-md-block d-none btn search-articles px-md-4" type="button"><i
											class="fa fa-search"></i></button>
								</div>
								<!-- </form> -->
							</div>
						</div>

						<section id="sectionDownCard" class=" mt-2 pt-3">
							<div class="card d-none no-results">
								<p>
									<h3 class="text-center">No Results, Try again</h3>
								</p>
							</div>
							<div>
								<div class="row">
									<div class="col-md-12">
										<form action="{!! URL::route('subscribe_news_journalist') !!}" method="post">
											<input type="checkbox" name="selectedAllResults" class="d-none" id="selectedAllResults">
											<input name="searchQueryPhrase" type="hidden" id="searchQueryPhrase">
											<select name="searchQueryOutlets[]" class="d-none" id="searchQueryOutlets" multiple="multiple">
												<option value="entrepreneur">Entrepreneur</option>
												<option value="forbes">Forbes</option>
												<option value="inc">Inc</option>
												<option value="mashable">Mashable</option>
												<option value="techcrunch">TechCrunch</option>
												<option value="the-wall-street-journal">The Wall Street Journal</option>
												<option value="the-next-web">The Next Web</option>
												<option value="business-insider">Business Insider </option>
												<option value="cnbc">CNBC </option>
												<option value="venture-beat">VentureBeat</option>
											</select>
											<div class="row mb-3 search-actions d-none" id="search-actions">
												<div class="col-md-8 text-left">
													<div>
														<button class="btn btn-primary  d-none" id="selectAllArticles"><i class="fa  fa-check mr-1"
																aria-hidden="true"></i>Select All</button>
														<span class="ml-3 d-inline selectedCount"></span>
													</div>
													<div class="mt-2">
														<button class="btn btn-primary d-none" data-toggle="modal" type="button"
															data-target="#createlistModal" id="btnCreateList"><i class="fa  fa-plus"
																aria-hidden="true"></i> Add to Mailing List</button>
														<button class="btn btn-primary d-none ml-1" type="submit" id="btnSendToAll"><i
																class="fa  fa-paper-plane" aria-hidden="true"></i> Contact Selected
															Journalists</button>&nbsp;
														<span class="d-none why-disabled" data-toggle="tooltip" data-placement="right"
															title="'Contact Selected Journalists' button is disabled as you have selected more than 10 articles. To better organize your contacts, Hooty has a list building feature where you can create a list of selected journalists by clicking 'Add to Mailing List' "><i
																class="fa fa-info-circle"></i> &nbsp;Why is this button disabled?</span>
													</div>
												</div>
												<div class="col-md-4 text-right" id="buttonToshowAlerts">
													<span id="keyAndCount">
														<span class="totalResults font-weight-bold ml-0"></span>
														<a class="text-primary unsubscribeA  font-weight-bold" id="subscribed_news_alerts" href="#">
															Subscribe for alerts<i
																class="fa fa-lg fa-exclamation-circle card-link text-secondary ml-1"
																data-toggle="tooltip" data-placement="right"
																title="Latest News alerts based on search query will be mailed to you"></i>
														</a>
													</span>
													<input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
												</div>
											</div>
											<!-- HANDLE BAR TRAIL  -->

											<div class="data-articles">

											</div>
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
												<h3>Hooty is finding relevant Articles for you...</h3>
											</div>
											<div class="text-center d-none pagination-loader">
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
												<h3>Loading more Articles...</h3>
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

			<input class="journalistSelector" style="display:none" type="checkbox" name="groups[]">

			<label class="checkboks_blue float-left">						
			<input class="articleSelector" type="checkbox" name="sub_news[]" onchange="onSelectArticle()"> <span class="checkmark_blue"></span> </label>
			<div class="media "> <img class="articleImage d-flex mr-3 align-self-start rounded" src="">
				<div class="media-body">
					<a data-toggle="modal" class="iframeModal2 tttt" data-url="" data-target="#iframeViewModal" href="#">
						<h5></h5>
					</a>
					<p class="articleContent"></p>
					<h6 class="align-middle"></h6>
					</h6>
				</div>
			</div>
			<p class="d-inline-block">
				<span class="font-weight-bold">Author: </span>
				<span class="articleAuthor"></span>
				<span class="font-weight-bold pl-4">Outlet: </span>
				<span class="articleOutlet"></span>
				<span class="date pl-4"><i class="fa fa-clock-o"></i> <span></span></span>
			</p>
			<form class="d-inline-block float-right" action="{!! URL::route('subscribe_news_journalist') !!}" method="post">
				<input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
				<input class="singleArticle" type="hidden" name="sub_news">
				<button class="btn btn-primary float-right"> <img src="{{asset('assets/images/sendToAll.svg')}}" class="svg sendToAll"> Contact Journalist </button>
			</form>

		</div>
	</div>
</script>

<div class="modal fade" id="createlistModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header card-header">
				<h5 class="modal-title" id="exampleModalLabel">Create List</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
						aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body" style="padding:15px;">
				<div class="my-2">
					<div class="header mb-1 text-muted"> Lists Name </div>
					<div class="sandbox w-80">
						<div class="input-group">
							<select name="name" id="list_tags">

								<option value="">Choose from list or type a new name to create a list</option>

								@if(!empty($data)) @foreach($data as $value)
								<option value="{!! $value->name !!}" style="background:red">{{$value->name}}</option>
								@endforeach @endif

							</select>
						</div>
					</div>
				</div>
				<div class="modal-footer" style="border:none !important;">
					<button type="button" id="createList" class="btn btn-primary">Create</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="iframeViewModal" aria-hidden="true" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">News</h5>
				<button class="close" data-dismiss="modal">×</button>
			</div>
			<div class="modal-body">
				<div class="embed-responsive embed-responsive-16by9">
					<div class="text-center loader iframe-loader"
						style=" position: absolute; width:100%; height:100%; top:0; bottom:0;margin: auto;">
						<div class="lds-default" style="display:block!important;margin:auto; margin-top:50px;">
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
					<iframe class="embed-responsive-item newsDisplayFrame" src="" allowfullscreen></iframe>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript" src="{{asset('assets/js/bootstrap-multiselect.js')}}"></script>
<script src="{{asset('assets/js/selectize.js')}}"></script>

<script type="text/javascript">
	var url = "<?php echo route('contact_index') ?>";
var api_url = "<?php echo \Config::get('app.api_url') ?>";
var app_url = "<?php echo \Config::get('app.url') ?>";

</script>
<script type="text/javascript" charset="utf8" src="{{asset('assets/js/sweet_alert.js')}}"></script>
<script type="text/javascript" charset="utf8" src="{{asset('assets/js/jquery.timeago.js')}}"></script>
<script type="text/javascript" charset="utf8" src="{{asset('assets/js/news_alert.js')}}"></script>
<script src="{{asset('userTheme/assets/js/sticky-header.js') }}"></script>
<script src="{{asset('userTheme/assets/js/search-articles.js') }}"></script>
<script>
	$(document).keypress(function(e) {
    if (e.which == 13) {
		searchArticles();
    }
});

</script>
@endsection