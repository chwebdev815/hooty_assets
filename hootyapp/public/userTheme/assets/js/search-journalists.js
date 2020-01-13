var page = 1;
var totalArticlePages;
var searchValues = {};
var isLoading = false;
var reachedEnd = true;
var currentCount = 0;
var totalCount = 0;
var selectedAll = false;
var selected = true;
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
  // $('[data-toggle="tooltip"]').tooltip(); // LIST(SEARCH>CREATELIST)

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
    }
  });
  $("#search-actions").sticky({ topSpacing: 55 });
  $("#searchJournalist").focus();
});

function searchJournalists(currentPage = 1, paginate, clickedOutlet) {
  console.log(arguments);
  var name = $("#searchJournalist").val();
  var outlet = $("#searchOutlet").val();
  var keyword = $("#searchKeyword").val();

  if (clickedOutlet) {
    $("#searchOutlet").val(clickedOutlet);
  }

  if (!(name || outlet || keyword || clickedOutlet)) {
    return;
  }

  if (!paginate) {
    page = 1;
    currentCount = 0;
    totalCount = 0;
    selectedAll = false;
    reachedEnd = false;
    selected = true;
    selectAllJournalistsOnPage(true);
    $("body").addClass("pace-done");
    $(".no-results").addClass("d-none");
    $(".data-journalists").html("");
    $(".search-actions").addClass("d-none");
    $(".selectedCount").html("");
    $("#journalist .loader").removeClass("d-none");
  } else {
    $("#journalist .pagination-loader").removeClass("d-none");
  }

  isLoading = true;

  $("#selected").val(0);
  $(".select_all_record_label").hide();

  page = currentPage;

  searchValues = {
    name: name,
    outlet: clickedOutlet || outlet,
    keyword: keyword,
    strict: !!clickedOutlet
  };

  var data = {
    search: searchValues,
    page: page,
    type: "all"
  };

  $.ajax({
    dataType: "json",
    url: url + "/",
    data: data
  })
    .done(function(data) {
      console.log(data);
      handleJournalistsData(data);
      isLoading = false;
    })
    .fail(function(xhr, status, error) {
      console.log("entered");
      isLoading = false;
      if (error) {
        $("#journalist .loader").addClass("d-none");
      }
    });
}

$(window).scroll(function() {
  if ($(window).scrollTop() + $(window).height() > $(document).height() - 200) {
    if (!isLoading && !reachedEnd) {
      searchJournalists(page + 1, true);
    }
  }
});

$(".outlet-search").on("click", function(e) {
  e.preventDefault();
  let outlet = $(this).data("outlet");
  console.log("CLICKED!!", outlet);
  $("#journalistsModal").modal("hide");
  if (outlet) {
    searchJournalists(1, false, outlet);
  }
});

function addMoreButton() {
  var showChar = 200; // How many characters are shown by default

  var ellipsestext = "...";
  var moretext = "Show more >";
  var lesstext = "Show less";
  $(".more").each(function() {
    var content = $(this).html();

    if (content.length > showChar) {
      var c = content.substr(0, showChar);
      var h = content.substr(showChar, content.length - showChar);
      var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + "</a></span>";
      $(this).html(html);
    }
  });
  $(".morelink").click(function() {
    if ($(this).hasClass("less")) {
      $(this).removeClass("less");
      $(this).html(moretext);
    } else {
      $(this).addClass("less");
      $(this).html(lesstext);
    }

    $(this)
      .parent()
      .prev()
      .toggleClass("d-none");

    $(this)
      .prev()
      .toggleClass("d-inline");

    return false;
  });
}

function handleJournalistsData(data) {
  var dataArray = data.journalist;

  setTimeout(function() {
    $("#journalist .loader").addClass("d-none");
    $("#journalist .pagination-loader").addClass("d-none");
  }, 0);

  currentCount = page * dataArray.length > data.journalist_count ? data.journalist_count : page * dataArray.length;
  totalCount = data.journalist_count;
  if (currentCount >= totalCount) {
    reachedEnd = true;
  }
  if (dataArray.length) {
    $(".totalResults").html(totalCount.toString());

    $(".pageResults").html(currentCount.toString());

    $(".search-actions").removeClass("d-none");
  } else {
    if (totalCount == 0) $(".no-results").removeClass("d-none");
  }

  if (dataArray.length > 0) {
    $("#buttonToshowAlerts").removeClass("d-none");
    $("#selectAll").removeClass("d-none");
    $(".noresults").addClass("d-none");
  } else {
    $("#buttonToshowAlerts").addClass("d-none");
    $("#selectAll").addClass("d-none");
    $(".noresults").removeClass("d-none");
  }

  let sanitizeKeywords = function(keyword) {
    let regex = new RegExp(/@post-id:\d+,/);
    return keyword ? keyword.replace(regex, "") : "";
  };

  for (let i = 0; i < dataArray.length; i++) {
    let value = dataArray[i];
    let template = $("#journalistCards").html();
    let element = $(template);
    let keywords = value.Outlet_Topic === value.Contact_Topic ? sanitizeKeywords(value.Outlet_Topic) : sanitizeKeywords(value.Outlet_Topic) + (!value.Outlet_Topic ? "" : value.Contact_Topic ? ", " : "") + sanitizeKeywords(value.Contact_Topic);

    let journalistImage;

    let socialMediaLinks = [];

    if ((value.Phone_number && value.Phone_number.indexOf("twitter") > -1) || (value.Twitter_handle && value.Twitter_handle.indexOf("twitter") > -1)) {
      let twitterLink = value.Phone_number.indexOf("twitter") > -1 ? value.Phone_number : value.Twitter_handle.indexOf("twitter") > -1 ? value.Twitter_handle : "";
      journalistImage = twitterLink ? twitterLink + "/profile_image?size=bigger" : undefined;
      socialMediaLinks.push('<li class="list-inline-item"><a target="_blank" href="' + twitterLink + '"><i class="fa fa-lg fa-twitter-square"></i></a></li>');
    }

    if (value.LinkedIn_URL) {
      socialMediaLinks.push('<li class="list-inline-item"><a target="_blank" href="' + value.LinkedIn_URL + '"><i class="fa fa-lg fa-linkedin-square"></i></a></li>');
    }

    if (value.Facebook) {
      socialMediaLinks.push('<li class="list-inline-item"><a target="_blank" href="' + value.Facebook + '"><i class="fa fa-lg fa-facebook-square"></i></a></li>');
    }

    keywords = keywords
      ? keywords
          .replace(/null/g, "")
          .replace(/undefined/g, "")
          .replace(/''/g, "")
      : "General Topics";

    if (!keywords || (keywords && !keywords.trim().length)) {
      keywords = "General Topics";
    }
    // $(element).find('input[name="sub_news[]"]').val(dataArray[i]._id);

    $(element)
      .find(".selectedArticles")
      .attr("value", value._id);

    $(element)
      .find(".singleArticle")
      .attr("value", value._id);

    if (journalistImage) {
      $(element)
        .find(".journalistImage")
        .attr("src", journalistImage);
    }

    if (socialMediaLinks.length) {
      let links = '<li class="list-inline-item"><strong>Social:&nbsp;</strong></li>' + socialMediaLinks.join("");
      $(element)
        .find(".social")
        .html(links);
    }

    $(".journalistSelector");

    $(element)
      .find(".journalistSelector")
      .attr("value", value.id);

    if (selectedAll) {
      $(element)
        .find(".journalistSelector")
        .attr("checked", true);
    }

    let journalistName = value.First_name + " " + (value.First_name !== value.Last_name ? value.Last_name : "") + " ";

    journalistName = journalistName.replace(/,/g, journalistName);
    $(element)
      .find(".journalistName")
      .html(journalistName);

    $(element)
      .find(".journalistKeywords")
      .html(keywords);

    $(element)
      .find(".outlet")
      .html(value.Domain_name);
    $(element).addClass("h-" + i);
    $(".data-journalists").append($(element));
  }

  addMoreButton();
}

$(".search-journalists").click(function() {
  searchJournalists();
});

$("#selectAllArticles").click(e => {
  e.preventDefault();
  selected = !selected;
  selectAllArticles(selected);
});

$("#selectAllJournalists").click(e => {
  e.preventDefault();
  selected = !selected;
  selectAllJournalistsOnPage(selected);
});

//3
$("body").on("click", "#selectAllJournalistOnResult", function(e) {
  console.log("WHEN ALL IS SELECTED");
  selectedAll = true;
  selectAllJournalistsOnPage(false);
  selectAllJournalistOnResult();
});

//4id="btnAddToList"
function selectAllJournalistsOnPage(selected) {
  console.log(selected, "selectedselectedselected");
  if (selected) {
    selectedAll = false;
    $(".selectedCount").html("");
    $(".journalistSelector").prop("checked", false);
    $("#selectAllJournalists").html('<i class="fa  fa-check mr-1" aria-hidden="true"></i>Select All');
    $("#allSearchResult").prop("checked", false);
    $("#journalistName").val("");
    $("#outlet").val("");
    $("#keyword").val("");
    onSelectJournalist();
  } else {
    $(".journalistSelector").prop("checked", true);
    $("#selectAllJournalists").html('<i class="fa  fa-times mr-1" aria-hidden="true"></i>Deselect All');
    selected = false;
    onSelectJournalist();
  }
}

//5
function selectAllJournalistOnResult() {
  $("#allSearchResult").prop("checked", true);
  $("#journalistName").val(searchValues.name);
  console.log($("#journalistName").val(searchValues.name), "#journalistName");
  $("#outlet").val(searchValues.outlet);
  $("#keyword").val(searchValues.keyword);
  $(".selectedCount").html("<span>Selected <strong>" + totalCount + "</strong> journalists</span>");
}

//2
function onSelectJournalist() {
  let selectedJournalistCount = $(".journalistSelector:checked").length;
  let unSelectedJournalistCount = $(".journalistSelector:not(:checked)").length;
  console.log({ selectedJournalistCount, selectedAll });

  if (selectedJournalistCount > 0) {
    if (selectedAll) {
      selectedJournalistCount = totalCount - unSelectedJournalistCount;
    }
    $(".selectedCount").html("<span>Selected <strong>" + selectedJournalistCount + "</strong> journalists</span>");
    if (selectedJournalistCount < totalCount) {
      $(".selectedCount").append('<Button type="button" class="ml-3 btn btn-sm  btn-outline-primary" id="selectAllJournalistOnResult"> Select all <strong>' + totalCount + "</strong> journalists </Button>");
    }
    console.log({ selectedJournalistCount, unSelectedJournalistCount, selectedAll });

    $("#btnAddToList").removeClass("d-none");
  } else {
    $(".selectedCount").html("");
    $("#btnAddToList").addClass("d-none");
  }
}

function createListButtonToggle() {
  var createListButton = [];
  console.log("checked", createListButton);
  $.each($('input[name="groups[]"]:checked'), function() {
    createListButton.push($(this).val());
  });

  if (createListButton.length > 0) {
    $("#createListButton").removeClass("d-none");
  } else {
    $("#createListButton").addClass("d-none");
  }
  console.log("checked", createListButton);
}
