jQuery(document).ready(function() {
  var indie_selectizeEmptyOrNot = 1;

  $("#saveAsDraftButton").click(function(e) {
    $("#draft").prop("checked", true);
    $("#send_individual_compose").submit();
  });

  $("#sendMessageButton").click(function(e) {
    e.preventDefault();

    var indie_summerNoteEmptyOrNot = $("#summernote").summernote("code");

    $("#send_individual_compose").validate(function(valid, elem) {});

    if (!$("#send_individual_compose").isValid() || !indie_selectizeEmptyOrNot || !indie_summerNoteEmptyOrNot) {
      if (!indie_selectizeEmptyOrNot) {
        $("#to_ErrorMsg").removeClass("d-none");
      }
      if (!indie_summerNoteEmptyOrNot) {
        $("#summer_note_ErrorMsg").removeClass("d-none");
      }
      if (!$("#send_individual_compose").isValid()) {
        $("#subjectErrorMsg").removeClass("d-none");
      }
      console.log("false");
      return false;
    } else {
      console.log("true");
      $("#send_individual_compose").submit();
    }
  });

  $("#list-tags").selectize({
    plugins: ["remove_button"],
    delimiter: ",",
    persist: false,
    create: function(input) {
      return {
        value: input,
        text: input
      };
    },
    onChange: function(value) {
      console.log(value);
      $("#to_ErrorMsg").addClass("d-none");
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
  // var text = "";
  // console.log("TEXT", text);
  $("#summernote").summernote("code", text);
}); // # sourceMappingURL=individual_compose.js.map
//# sourceMappingURL=individual_compose.js.map
