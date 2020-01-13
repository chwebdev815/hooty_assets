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
					<h3 class="text-dark mb-4">Find Journalists</h3>
					<div class="row">
						<div class="col-md-12">
							<div class="alert alert-info">
								<i class="fa fa-info-circle"></i> &nbsp;We collect our journalist's contacts from the
								public web, and sometimes these
								journalists can be individuals, organizations, blogs or websites. For example, Quora may
								come up as a journalist.
							</div>
						</div>
					</div>
					<div id="journalist" class="container p-0">
						<div class="bg-primary p-4">
							<div class="row">
								<div class="col-md-4">
									<label>BY NAME</label>
									<input type="text" id="searchJournalist" class="form-control p-2 search"
										placeholder="Type name of journalist to search">
								</div>
								<div class="col-md-4">
									<label>BY MEDIA OUTLET</label>
									<input type="text" id="searchOutlet" class="form-control p-2 search"
										placeholder="Type name of outlet to search">
								</div>
								<div class="col-md-4">
									<label>BY KEYWORDS</label>
									<input type="text" id="searchKeyword" class="form-control p-2 search"
										placeholder="Type name of keyword to search">
								</div>
							</div>
							<div class="row mt-4">
								<div class="col-md-12">
									<button class="btn btn-default w-100 search-journalists">
										Search
									</button>
								</div>
							</div>
						</div>
						<div id="quick-search" class="pt-2">
							<span class="d-block">
								<div>
									<h5 class="text-dark m-3 text-center" style="text-transform:uppercase"><b>Or, for a
											Quick Search Choose From The List
											Below:</b></h5>
								</div>
							</span>
							<div style="background-color:#DFE2E4; padding-bottom:20px;">


								<ul class="d-inline-block text-center" style="overflow-x:auto;">
									<li class="list-inline-item mr-3"><a class="outlet-search" data-outlet="Forbes"
											href><img style="max-height:75px;"
												src="{{asset('assets/images/news_logos/forbes.png')}}" /></a></li>
									<li class="list-inline-item mr-3"><a class="outlet-search"
											data-outlet="The Huffington Post" href><img style="max-height:75px;"
												src="{{asset('assets/images/news_logos/huffpost.png')}}" /></a></li>
									<li class="list-inline-item mr-3"><a class="outlet-search" data-outlet="Inc."
											href><img style="max-height:75px;"
												src="{{asset('assets/images/news_logos/inc.png')}}" /></a></li>
									<li class="list-inline-item mr-3"><a class="outlet-search" data-outlet="Thrillist"
											href><img style="max-height:75px;"
												src="{{asset('assets/images/news_logos/thrillist.png')}}" /></a></li>
									<li class="list-inline-item mr-3"><a class="outlet-search"
											data-outlet="The Next Web" href><img style="max-height:75px;"
												src="{{asset('assets/images/news_logos/tnw.png')}}" /></a></li>
									<li class="list-inline-item mr-3"><a class="outlet-search" data-outlet="CNBC"
											href><img style="max-height:75px;"
												src="{{asset('assets/images/news_logos/cnbc.png')}}" /></a></li>
									<li class="list-inline-item mr-3"><a class="outlet-search" data-outlet="Mashable"
											href><img style="max-height:75px;"
												src="{{asset('assets/images/news_logos/mashable.png')}}" /></a></li>
									<li class="list-inline-item mr-3"><a class="outlet-search" data-outlet="Techcrunch"
											href><img style="max-height:75px;"
												src="{{asset('assets/images/news_logos/techcrunch.png')}}" /></a></li>
									<li class="list-inline-item mr-3"><a class="outlet-search"
											data-outlet="Business Insider" href><img style="max-height:70px;"
												src="{{asset('assets/images/news_logos/business_insider.png')}}" /></a>
									</li>
									<li class="list-inline-item mr-3"><a class="outlet-search"
											data-outlet="The Wall Street Journal" href><img style="max-height:70px;"
												src="{{asset('assets/images/news_logos/wallstreet_journal.png')}}" /></a>
									</li>
									<li class="list-inline-item mr-3"><a class="outlet-search" data-outlet="VentureBeat"
											href><img style="max-height:70px;"
												src="{{asset('assets/images/news_logos/venture_beat.png')}}" /></a></li>

								</ul>
								<button type="button" class="btn btn-primary btn-sm d-block m-auto" data-toggle="modal"
									data-target="#journalistsModal">
									View More
								</button>
							</div>


							<div class="modal journalists-modal" id="journalistsModal">
								<div class="modal-dialog " style="max-width:100%">
									<div class="modal-content">

										<div class="modal-header">
											<h4 class="modal-title"> Choose From The List Below</h4>
											<button type="button" class="close" data-dismiss="modal">&times;</button>
										</div>

										<div class="modal-body">

											<ul class="text-center" style="overflow-x:auto">
												<li class="list-inline-item mr-3" style="min-height:40px"><a
														class="outlet-search" data-outlet="Engadget" href><img
															style="max-height:75px"
															src="{{asset('assets/images/news_logos/engadget.png')}}" /></a>
												</li>
												<li class="list-inline-item mr-3" style="min-height:40px"><a
														class="outlet-search" data-outlet="Fortune" href><img
															style="max-height:75px"
															src="{{asset('assets/images/news_logos/fortune.png')}}" /></a>
												</li>
												<li class="list-inline-item mr-3" style="min-height:40px"><a
														class="outlet-search" data-outlet="Hacker News" href><img
															style="max-height:75px"
															src="{{asset('assets/images/news_logos/hackernews.png')}}" /></a>
												</li>
												<li class="list-inline-item mr-3" style="min-height:40px"><a
														class="outlet-search" data-outlet="Bloomberg" href><img
															style="max-height:75px"
															src="{{asset('assets/images/news_logos/bloomberg.png')}}" /></a>
												</li>
												<li class="list-inline-item mr-3" style="min-height:40px"><a
														class="outlet-search" data-outlet="The New York Times" href><img
															style="max-height:75px"
															src="{{asset('assets/images/news_logos/tnyt.png')}}" /></a>
												</li>
												<li class="list-inline-item mr-3" style="min-height:40px"><a
														class="outlet-search" data-outlet="Recode" href><img
															style="max-height:75px"
															src="{{asset('assets/images/news_logos/recode.png')}}" /></a>
												</li>
												<li class="list-inline-item mr-3" style="min-height:40px"><a
														class="outlet-search" data-outlet="Reuters" href><img
															style="max-height:75px"
															src="{{asset('assets/images/news_logos/reuters.png')}}" /></a>
												</li>
												<li class="list-inline-item mr-3" style="min-height:40px"><a
														class="outlet-search" data-outlet="Usa Today" href><img
															style="max-height:75px"
															src="{{asset('assets/images/news_logos/usa_today.png')}}" /></a>
												</li>
												<li class="list-inline-item mr-3" style="min-height:40px"><a
														class="outlet-search" data-outlet="Vice News" href><img
															style="max-height:75px"
															src="{{asset('assets/images/news_logos/vice_news.png')}}" /></a>
												</li>
												<li class="list-inline-item mr-3" style="min-height:40px"><a
														class="outlet-search" data-outlet="Wired" href><img
															style="max-height:75px"
															src="{{asset('assets/images/news_logos/wired.png')}}" /></a>
												</li>
												<li class="list-inline-item mr-3" style="min-height:40px"><a
														class="outlet-search" data-outlet="The Verge" href><img
															style="max-height:75px"
															src="{{asset('assets/images/news_logos/the_verge.png')}}" /></a>
												</li>
											</ul>
										</div>



									</div>
								</div>
							</div>

						</div>
						<section class="mt-2 pt-3">
							<div>

								<div class="row">
									<div class="col-md-12">
										<form action="{!! URL::route('group_store') !!}" method="post">
											{{ csrf_field() }}
											<input type="checkbox" style="display:none;" name="allSearchResult"
												id="allSearchResult">
											<input type="hidden" name="journalistName" id="journalistName">
											<input type="hidden" name="outlet" id="outlet">
											<input type="hidden" name="keyword" id="keyword">
											<div class="row mb-3 search-actions d-none" id="search-actions">
												<div class="col-md-8 text-left">
													<button class="btn btn-primary" id="selectAllJournalists"><i
															class="fa  fa-check mr-1" aria-hidden="true"></i>Select
														All</button>
													<button class="btn btn-primary d-none" type="button"
														data-toggle="modal" data-target="#createlistModal"
														id="btnAddToList"><i class="fa  fa-plus" aria-hidden="true"></i>
														Add to Mailing List</button>
													<span class="ml-3 d-inline selectedCount"></span>
												</div>
												<div class="col-md-4 text-right" id="buttonToshowAlerts">
													<span id="keyAndCount ml-2">
														Showing <span class="pageResults font-weight-bold ml-0"></span>
														of <span class="totalResults font-weight-bold ml-0"></span>
														journalists
													</span>
													<input type="hidden" value="{{ csrf_token() }}" name="_token"
														id="token">
												</div>
											</div>
											<!-- HANDLE BAR TRAIL  -->

											<div class="modal fade" id="createlistModal" tabindex="-1" role="dialog"
												aria-labelledby="exampleModalLabel" aria-hidden="true">
												<div class="modal-dialog modal-lg" role="document">
													<div class="modal-content">
														<div class="modal-header card-header">
															<h5 class="modal-title" id="exampleModalLabel">Create List
															</h5>
															<button type="button" class="close" data-dismiss="modal"
																aria-label="Close"> <span
																	aria-hidden="true">&times;</span> </button>
														</div>
														<div class="modal-body" style="padding:15px;">
															<div class="my-2">
																<div class="header mb-1 text-muted"> Lists Name </div>
																<div class="sandbox w-80">
																	<div class="input-group">
																		<select name="name" id="list_tags">

																			<option value="">Choose from list or type a
																				new name to create a list</option>

																			@if(!empty($data)) @foreach($data as $value)
																			<option value="{!! $value->name !!}"
																				style="background:red">{{$value->name}}
																			</option>
																			@endforeach @endif

																		</select>
																	</div>
																</div>
															</div>
															<div class="modal-footer" style="border:none !important;">
																<button type="submit"
																	class="btn btn-primary">Create</button>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="card d-none no-results mt-2">
												<p>
													<h3 class="text-center">No Results, Try again</h3>
												</p>
											</div>

											<div class="data-journalists">
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
												<h3>Hooty is finding relevant Journalists for you...</h3>
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
												<h3>Loading more Journalists...</h3>
											</div>
										</form>
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



<script id="journalistCards" type="text/x-handlebars-template">
	<div class="card">
		<div class="card-body">
			<label class="checkboks_blue float-left">
				<input class="journalistSelector" type="checkbox" name="groups[]" onchange="onSelectJournalist()"> <span class="checkmark_blue"></span>
			</label>

			<div class="media">
				<img alt="" src="/assets/img/user.jpg" width="50px" class="journalistImage d-flex mr-3 align-self-start rounded-circle">
				<div class="media-body">
					<span class="float-right">
						<ul class="list-unstyled list-inline social">
						</ul>
					</span>
					<h5 class="journalistName"></h5>
					<h5><span class="badge badge-pill badge-primary badge-lg outlet"></span></h5>
					<p class="journalistKeywords more mt-3"></p>
				</div>
			</div>
			<form class="d-inline-block float-right" action="{!! URL::route('subscribe_news_journalist') !!}" method="post">
				<input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
				<input class="singleArticle" type="hidden" name="sub_news">

			</form>

		</div>
	</div>
</script>


<script type="text/javascript" src="{{asset('assets/js/bootstrap-multiselect.js')}}"></script>
<script src="{{asset('assets/js/selectize.js')}}"></script>

<script type="text/javascript">
	var url = "<?php echo route('contact_index') ?>";
var api_url = "<?php echo \Config::get('app.api_url') ?>";
var app_url = "<?php echo \Config::get('app.url') ?>";

</script>

<script type="text/javascript" charset="utf8" src="{{asset('assets/js/sweet_alert.js')}}"></script>
<script type="text/javascript" charset="utf8" src="{{asset('assets/js/jquery.timeago.js')}}"></script>
<script src="{{asset('userTheme/assets/js/sticky-header.js') }}"></script>
<script src="{{asset('userTheme/assets/js/search-journalists.js') }}"></script>
<script>
	$(document).keypress(function(e) {
		if (e.which == 13) {
			searchJournalists();
		}
	});

</script>
@endsection