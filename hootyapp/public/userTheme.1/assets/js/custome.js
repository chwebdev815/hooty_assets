/* manage data list */
$(".show_email_click_list").click(function() {
  var id = $(this)
    .parent("td")
    .data("id");
  $("body").attr("style", "opacity: 0.2;");
  $.ajax({
    dataType: "json",
    url: url + "/" + id
  }).done(function(data) {
    console.log(data);
    $("body").attr("style", "opacity: 1;");
    var rows = "";
    var colum = "";
    $.each(data, function(key, value) {
      rows = rows + "<tr>";
      rows = rows + "<td>" + value.First_name + " " + value.Last_name + "</td>";
      rows = rows + "<td>" + value.Click + "</td>";
      rows = rows + "</tr>";
    });

    $(".user_click_list").html(rows);
  });
});

jQuery(document).ready(function() {
  $("#chat_search_box").on("input", function(e) {
    var name = $("#chat_search_box").val();
    var message_id = $("#message_id").val();
    var journalists_id = $("#journalists_id").val();
    $.ajax({
      type: "POST",
      url: search_name,
      data: { name: name, message_id: message_id, journalists_id: journalists_id },
      dataType: "json",
      success: function(data) {
        console.log(data);
        var rows = "";
        var colum = "";
        $.each(data, function(key, value) {
          rows = rows + '<a href="' + baseurl + "messages/show/" + value.message_id + "231*@m~$!19h~1$S+298" + value.journalists_id + '"> ';
          rows = rows + "<li>";
          rows = rows + "<span>" + value.first_name.slice(0, 1).toUpperCase() + "" + value.last_name.slice(0, 1).toUpperCase() + "</span>";
          rows = rows + value.first_name + " " + value.last_name;
          if (value.chat_status != 0) {
            rows = rows + '<div class="unread_count">' + value.chat_status + "-new</div>";
          }
          rows = rows + "</li>";
          rows = rows + "</a>";
        });

        $(".chet_list").html(rows);

        if (data == "") {
          $(".chet_list").html("");
        }
      }
    });
  });
});

$.ajaxSetup({
  headers: {
    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
  }
});

$(".menu_icon .dripicons-menu").click(function() {
  $(".left-side-menu").animate({
    width: "80px"
  });
  $(".content-page").attr("style", "margin-left:82px;");
  $(".left-side-menu").attr("style", "padding: 0px 0;");
  $("#myHeader").addClass("full_sticky");
  $(".slimscroll-menu span").hide();
  $(".menu_icon .dripicons-menu").hide();
  $(".full_width_menu_icon").show();
  $(".top_logo").hide();
});

$(".full_width_menu_icon").click(function() {
  $(".left-side-menu").animate({
    width: "250px"
  });
  $(".content-page").attr("style", "margin-left:250px;");
  $(".left-side-menu").attr("style", "padding: 30px 0px;");
  $(".slimscroll-menu span").show();
  $(".menu_icon .dripicons-menu").show();
  $(".full_width_menu_icon").hide();
  $("#myHeader").removeClass("full_sticky");
  $(".top_logo").show();
});

$(document).ready(function() {
  $("#Dashboard_menu").tooltip({ title: "Dashboard", placement: "right" });
  $("#Hooty_menu").tooltip({ title: "Hooty", placement: "right" });
  $("#Search_memu").tooltip({ title: "Search", placement: "right" });
  $("#Compose_menu").tooltip({ title: "Compose", placement: "right" });
  $("#Inbox_menu").tooltip({ title: "Inbox", placement: "right" });
  $("#Chat_menu").tooltip({ title: "Chat", placement: "right" });
});

$(".send_mail_btn").click(function() {
  var text = $("#title").val();
  if (text == "") {
    var text = $("#title").focus();
    $(".my_error").attr("style", "display:block");
  } else {
    $("#send_mail").modal();
  }
});
