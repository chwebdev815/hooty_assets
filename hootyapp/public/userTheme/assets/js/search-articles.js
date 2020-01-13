var page = 1;
var totalArticlePages;
var searchValues = {};
var isLoading = false;
var reachedEnd = true;
var currentCount = 0;
var totalCount = 0;
var selectedAll = false;
var selected = true;
var dataArray;
var selectedJournalistIds;
var listName;
// window.onscroll = function() { myFunction() };
// // var header = document.getElementById("myHeader");
// // var sticky = header.offsetTop;

// function myFunction() {
//     if (window.pageYOffset > sticky) {
//         header.classList.add("sticky");
//     } else {
//         header.classList.remove("sticky");
//     }
// }

$(document).ready(function() {
  $("#outlets").multiselect({
    includeSelectAllOption: true,
    nonSelectedText: "All Outlets",
    selectAllValue: "select-all-value"
  });
  $("#articleInput").focus();
  $("#search-actions").sticky({ topSpacing: 55 });

  $("#list_tags").selectize({
    create: true,
    createOnBlur: true,
    sortField: "text",
    maxItems: 1,
    delimiter: ",",
    persist: false,
    create: function(input) {
      return {
        value: input,
        text: input
      };
    },
    onChange: function(value) {
      listName = value;
    }
  });
});

function findArticle(articleId) {
  $.ajax({
    type: "GET",
    url: api_url + "/v1/get-article/" + articleId,
    success: function(data) {
      console.log(data);
    }
  });
}

function searchArticles(currentPage = 1, paginate) {
  isLoading = true;
  if (!paginate) {
    page = 1;
    currentCount = 0;
    totalCount = 0;
    selectedAll = false;
    reachedEnd = false;
    selected = true;
    totalArticlePages = 1;
    selectAllArticlesOnPage(true);
    $("body").addClass("pace-done");
    $(".no-results").addClass("d-none");
    $(".data-articles").html("");
    $(".search-actions").addClass("d-none");
    $(".selectedCount").html("");
    $("#articles .loader").removeClass("d-none");
  } else {
    $("#articles .pagination-loader").removeClass("d-none");
  }
  console.log("API URL", api_url + "/v1/search-news", currentPage);
  $.ajax({
    type: "POST",
    url: api_url + "/v1/search-news",
    data: {
      text: $("input#articleInput").val(),
      genre: $("select#genre").val(),
      outlets: $("select#outlets").val(),
      page: currentPage
    },
    success: function(data) {
      console.log("DATA", data);
      $("#articles .loader").addClass("d-none");
      isLoading = false;
      $("#searchQueryPhrase").val($("input#articleInput").val());
      $("#searchQueryOutlets").val($("select#outlets").val());
      $("#btnSendToAll").prop("disabled", false);
      $(".why-disabled").addClass("d-none");
      handleArticlesData(data);
    },
    error: function() {
      isLoading = false;
      $("#articles .loader").addClass("d-none");
    }
  });
}

function handleArticlesData(data) {
  var searchTerm = $("input#articleInput").val();
  var display = `${data.count} results of "${searchTerm}" is found`;
  dataArray = data.docs;
  totalCount = data.count;
  currentCount = page * dataArray.length > data.count ? data.count : page * dataArray.length;
  totalArticlePages = data.pages;
  isLoading = false;
  setTimeout(function() {
    $("#articles .loader").addClass("d-none");
    $("#articles .pagination-loader").addClass("d-none");
  }, 0);

  currentCount = page * dataArray.length > data.count ? data.count : page * dataArray.length;
  totalCount = data.count;
  if (currentCount >= totalCount) {
    reachedEnd = true;
  }

  if (dataArray.length > 0) {
    $("#buttonToshowAlerts").removeClass("d-none");
    $("#selectAllArticles").removeClass("d-none");
    $(".search-actions").removeClass("d-none");
    $(".no-results").addClass("d-none");
  } else {
    $("#buttonToshowAlerts").addClass("d-none");
    $("#selectAllArticles").addClass("d-none");
    $(".no-results").removeClass("d-none");
  }

  $("#keyAndCount")
    .find(".totalResults")
    .html(display);

  for (let i = 0; i < dataArray.length; i++) {
    let template = $("#articleCards").html();
    let element = $(template);
    // $(element).find('input[name="sub_news[]"]').val(dataArray[i]._id);
    $(element)
      .find(".articleSelector")
      .attr("value", dataArray[i]._id);
    $(element)
      .find(".singleArticle")
      .attr("value", dataArray[i]._id);

    $(element)
      .find(".articleImage")
      .attr("src", dataArray[i].image);
    $(element)
      .find(".tttt")
      .attr("data-url", dataArray[i].url);
    $(element)
      .find("h5")
      .html(dataArray[i].title);
    $(element)
      .find(".articleContent")
      .html(dataArray[i].content);
    $(element)
      .find(".articleAuthor")
      .html(dataArray[i].author_name);
    $(element)
      .find(".articleOutlet")
      .html(dataArray[i].source_name);
    $(element)
      .find(".articleGenre")
      .html(dataArray[i].genre);
    $(element)
      .find(".date span")
      .html($.timeago(dataArray[i].date));
    $(".data-articles").append($(element));

    if (selectedAll) {
      $(element)
        .find(".articleSelector")
        .attr("checked", true);
    }
  }
}

$(window).scroll(function() {
  if ($(window).scrollTop() + $(window).height() > $(document).height() - 200) {
    if (!isLoading && !reachedEnd) {
      page = page + 1;
      searchArticles(page, true);
    }
  }
});

$(".search-articles").click(function() {
  $(".data-articles").html("");
  $(".no-results").addClass("d-none");
  page = 1;
  searchArticles();
});

$("#selectAllArticles").click(e => {
  e.preventDefault();
  selected = !selected;
  selectAllArticlesOnPage(selected);
});

$("body").on("click", "#selectAllArticlesOnResult", function(e) {
  selectedAll = true;
  selectAllArticlesOnPage(false);
  selectAllArticlesOnResult();
});

function selectAllArticlesOnPage(selected) {
  if (selected) {
    selectedAll = false;
    $("#btnSendToAll").prop("disabled", false);
    $(".why-disabled").addClass("d-none");
    $(".articleSelector").prop("checked", false);
    $("#btnSendToAll").addClass("d-none");
    $("#btnCreateList").addClass("d-none");
    $(".selectedCount").html("");
    $("#selectAllArticles").html('<i class="fa  fa-check mr-1" aria-hidden="true"></i>Select All');
    onSelectArticle();
  } else {
    $(".articleSelector").prop("checked", true);
    $("#selectAllArticles").html('<i class="fa  fa-times mr-1" aria-hidden="true"></i>Deselect All');
    $("#btnSendToAll").removeClass("d-none");
    $("#btnCreateList").removeClass("d-none");
    $("#selectedAllResults").prop("checked", false);
    selected = false;
    onSelectArticle();
  }
}

function selectAllArticlesOnResult() {
  $("#allSearchResult").prop("checked", true);
  $("#journalistName").val(searchValues.name);
  $("#outlet").val(searchValues.outlet);
  $("#keyword").val(searchValues.keyword);
  $(".selectedCount").html("<span>Selected <strong>" + totalCount + "</strong> articles</span>");
  $("#selectedAllResults").prop("checked", true);
  if (totalCount > 10) {
    $("#btnSendToAll").prop("disabled", true);
    $(".why-disabled").removeClass("d-none");
  }
}

function getJournalistId(articleId) {
  let index = dataArray.findIndex(function(article) {
    return article._id == articleId;
  });

  if (index > -1) {
    return dataArray[index].author_hooty_id;
  }
}

function onSelectArticle() {
  let journalistIds = [];
  // console.log($(this).val());
  $(".articleSelector:checked").each(function() {
    let journalistId = getJournalistId($(this).val());
    journalistIds.push(journalistId);
    selectedJournalistIds = journalistIds;
  });

  let selectedArticleCount = $(".articleSelector:checked").length;
  let unSelectedArticleCount = $(".articleSelector:not(:checked)").length;
  if (selectedArticleCount > 0) {
    if (selectedAll) {
      selectedArticleCount = totalCount - unSelectedArticleCount;
    }
    $(".selectedCount").html("<span>Selected <strong>" + selectedArticleCount + "</strong> articles</span>");
    if (selectedArticleCount < totalCount) {
      $(".selectedCount").append('<Button type="button" class="ml-3 btn btn-sm  btn-outline-primary" id="selectAllArticlesOnResult"> Select all <strong>' + totalCount + "</strong> articles </Button>");
    }
    $("#btnSendToAll").removeClass("d-none");
    $("#btnCreateList").removeClass("d-none");
  } else {
    $(".selectedCount").html("");
    $("#btnSendToAll").addClass("d-none");
    $("#btnCreateList").addClass("d-none");
  }
}

$("body").on("click", ".unsubscribeA", function(e) {
  e.preventDefault();
  var token = $("#token").val();
  var searchTerm = $("input#articleInput").val();
  var data = {
    search: searchTerm,
    outlets: $("select#outlets").val(),
    _token: token
  };
  swal({
    title: "Are you sure?",
    text: "Are you sure you want to subscribe?!",
    icon: "assets/img/happyFace.png",
    buttons: true,
    dangerMode: true
  }).then(subscribe => {
    if (subscribe) {
      console.log("Ajax running");
      $.ajax({
        type: "POST",
        url: app_url + "/subscribe-news-alerts",
        data: data,
        success: function(data) {
          window.location.href = "/news-jacking";
        },
        error: function(jqXHR, exception) {
          console.log(jqXHR, exception);
        }
      });
    }
  });
});

$("#createList").click(function() {
  $(this).html("Creating list...");
  $(this).prop("disabled", true);
  console.log("XXXX", $("#searchQueryPhrase").val(), $("#searchQueryOutlets").val());
  $.ajax({
    url: app_url + "/group/save",
    type: "POST",
    data: {
      _token: $("#token").val(),
      name: listName,
      groups: selectedJournalistIds,
      allSearchResultArticles: selectedAll && selectedJournalistIds.length < totalCount ? true : false,
      searchQueryPhrase: $("#searchQueryPhrase").val(),
      searchQueryOutlets: $("#searchQueryOutlets").val(),
      isAjaxCall: true
    },
    success: function(data) {
      console.log(data);
      $("#createlistModal").modal("hide");
      if (toastr) {
        toastr.success("List successfully created!");
      }
      $("#search-actions").append(
        '<div class="col-md-12 mt-2"><div class="alert alert-success"><strong>Success!</strong> New list "' +
          listName +
          '" has been created. Click <a href="/individual-list?id=' +
          data.groupId +
          '">here to view</a>. <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" style="font-size:20px">×</span></button></div></div>'
      );
      $(this).html("Create list");
      $(this).prop("disabled", false);
    },
    error: function(err) {
      console.log(err);
    }
  });
});

function sendAllButtonToggle() {
  var subscribeNewsAlerts = [];
  $.each($('input[name="sub_news[]"]:checked'), function() {
    subscribeNewsAlerts.push($(this).val());
  });
  if (subscribeNewsAlerts.length > 0) {
    $("#btnSendToAll").removeClass("d-none");
    $("#btnCreateList").removeClass("d-none");
  } else {
    $("#btnSendToAll").addClass("d-none");
    $("#btnCreateList").addClass("d-none");
  }
}
