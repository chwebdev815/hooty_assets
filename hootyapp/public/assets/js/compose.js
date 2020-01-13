// summernote
var doNotAllowLeavePage = true;

$(window).bind("beforeunload", function() {
  if (doNotAllowLeavePage) {
    return "Are you sure you want to leave? The changes you have made will not be saved!";
  }
});

jQuery(document).ready(function() {
  var selectizeEmptyOrNot;

  $("input[name='title']").focus();

  $("#saveAsDraftButton").click(function(e) {
    doNotAllowLeavePage = false;
    $("#draft").prop("checked", true);
    $("#sendForm").submit();
  });

  $("#sendMessageButton").click(function(e) {
    e.preventDefault();
    var summerNoteEmptyOrNot = $("#summernote").summernote("code");

    console.log(summerNoteEmptyOrNot);
    $("#sendForm").validate(function(valid, elem) {});

    if (!$("#sendForm").isValid() || !selectizeEmptyOrNot || !summerNoteEmptyOrNot) {
      if (!selectizeEmptyOrNot) {
        $("#listErrorMsg").removeClass("d-none");
      }

      if (!summerNoteEmptyOrNot) {
        $("#noteErrorMsg").removeClass("d-none");
      }

      if (!$("#sendForm").isValid()) {
        $("#campaign_error_position").removeClass("d-none");
      }

      return false;
    } else {
      doNotAllowLeavePage = false;
      $("#sendForm").submit();
    }
  });

  $("#list-tags").selectize({
    plugins: ["remove_button"],
    delimiter: ",",
    allowEmptyOption: true,
    persist: false,
    render: {
      option_create: function(data, escape) {
        return '<div class="create p-2"><i class="fa fa-plus"></i>&nbsp;&nbsp;Create new list</div>';
      }
    },
    createLink: true,
    placeholder: "Choose lists to which you want to send the campaign",
    create: function(input) {
      window.location = "/search-journalists";
      return false;
    },
    onChange: function(value) {
      $("#listErrorMsg").addClass("d-none");
      selectizeEmptyOrNot = value;
    }
  });

  var InsertTags = function(context) {
    var ui = $.summernote.ui;
    console.log(ui, "ui");
    var button = ui.buttonGroup([
      ui.button({
        className: "dropdown-toggle",
        contents: '<span class="twa twa-smile"></span>Merge Fields<span class="caret"></span>',
        data: {
          toggle: "dropdown"
        },
        click: function() {
          context.invoke("editor.saveRange");
        }
      }),
      ui.dropdown({
        className: "dropdown-style emoji-list",
        //items: emojis, // list of style tag
        contents: "<ul style='list-style:none; padding:0px;'><li style='pointer:cursor;padding:5px' data-value='[First_name]'>First Name</li><li style='pointer:cursor;padding:5px;' data-value='[Last_name]'>Last Name</li></ul>",
        callback: function($dropdown) {
          $dropdown.find("li").each(function() {
            $(this).click(function() {
              context.invoke("editor.restoreRange");
              context.invoke("editor.focus");
              context.invoke("editor.insertText", $(this).data("value"));
            });
          });
        }
      })
    ]);

    return button.render();
  };
  $("#summernote").summernote({
    placeholder: "Type here",
    tabsize: 2,
    height: 80,
    toolbar: [
      ["style", ["insert_tags", "bold", "italic", "underline", "clear"]],
      ["fontname", ["fontname"]],
      ["color", ["color"]],
      ["para", ["ul", "ol", "paragraph"]],
      ["height", ["height"]],
      ["table", ["table"]],
      ["insert", ["link", "picture", "hr", "video"]],
      ["view", ["fullscreen", "codeview"]],
      ["help", ["help"]][("custom", "hello")]
    ],
    buttons: {
      insert_tags: InsertTags
    },
    callbacks: {
      onChange: function(contents, $editable) {
        $("#noteErrorMsg").addClass("d-none");
      }
    }
  });

  console.log("TEXT", text);
  $("#summernote").summernote("code", text);
}); // # sourceMappingURL=compose.js.map
//# sourceMappingURL=compose.js.map
