/* global message:true */
(function($) {
  $(document).ready(function() {
    $(".meta").removeClass("d-sm-down-none");
    $("#list-home-list").click(function() {
      console.log($(this).data("link"));
      $($(this).data("link")).removeClass("d-sm-down-none");
      $("#sidePanelInbox").removeClass("d-sm-down-none");
      $("#messageBox").addClass("d-sm-down-none", "mt-0");
      $("#list-tab-hide").addClass("d-sm-down-none");
    });
    $(".contact").click(function() {
      $("#messageBox").removeClass("d-sm-down-none");
      $("#sidePanelInbox").addClass("d-sm-down-none");
      resizeMessages();
    });
    $(".sidePanelBack").click(function() {
      $("#list-tab-hide").removeClass("d-sm-down-none");
      $("#sidePanelInbox").addClass("d-sm-down-none");
    });
    $(".messageBoxBack").click(function() {
      $("#messageSection").removeClass("d-sm-down-none");
      $("#messageBox").addClass("d-sm-down-none");
      $("#sidePanelInbox").removeClass("d-sm-down-none");
    });

    function resizeMessages() {
      let headerHeight = $("header.navbar").height();
      let contactProfileHeight = $(".contact-profile").height();
      let messageInputHeight = $(".message-input").height();
      $(".messages").height($(window).height() - (headerHeight + contactProfileHeight + messageInputHeight + 9));
    }

    $(window).on("resize", function() {
      setTimeout(function() {
        resizeMessages();
      }, 0);
    });
    resizeMessages();

    var HelloButton = function(context) {
      var ui = $.summernote.ui;
      var button = ui.button({
        contents: '<button type="button" class="btn btn-primary text-white"><i class="fa fa-send"/> Send</button>',
        click: function() {
          if ($(".message-box").val() !== null && $(".message-box").val() !== "") {
            $("#chat-mail").submit();
          }
        }
      });
      return button.render(); // return button as jquery object
    };

    $("#summernote").summernote({
      placeholder: "Type here",
      tabsize: 2,
      height: 80,
      toolbar: [["style", ["style"]], ["font", ["bold", "italic", "underline"]], ["fontname", ["fontname"]], ["color", ["color"]], ["para", ["ul", "ol", "paragraph"]], ["height", ["height"]], ["insert", ["link", "picture", "hr"]], ["hello"]],
      buttons: {
        hello: HelloButton
      }
    });
    $(".messages").animate(
      {
        scrollTop: $(document).height()
      },
      "fast"
    );
    $("#status-options").removeClass("active");
  });

  function newMessage() {
    message = $(".message-input input").val();

    if ($.trim(message) === "") {
      return false;
    }

    $('<li class="sent"><img alt="" /><p>' + message + "</p></li>").appendTo($(".messages ul"));
    $(".message-input input").val(null);
    $(".contact.active .preview").html("<span>You: </span>" + message);
    $(".messages").animate(
      {
        scrollTop: $(document).height()
      },
      "fast"
    );
  }

  $(".submit").click(function() {
    newMessage();
  });
  $(window).on("keydown", function(e) {
    if (e.which === 13) {
      newMessage();
      return false;
    }
  });
})(jQuery);
//# sourceMappingURL=inbox.js.map
