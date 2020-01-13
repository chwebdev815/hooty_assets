/* global Chart:true */

/* eslint-disable no-new */
// localStorage.setItem("hasTourClosed", false);

jQuery(document).ready(function() {
  try {
    console.log(window.walk_through_status, "STATTS");

    var walk_through_status = !isNaN(window.walk_through_status) ? window.walk_through_status : 1;

    $("body").pagewalkthrough({
      name: "introduction",
      onClose: function() {
        $.ajax({
          url: "/walkthrough-completed?status=1",
          success: function(data) {
            console.log(data, "data");
          }
        });
      },
      steps: [
        {
          popup: {
            content: "#walkthrough-1",
            type: "modal"
          }
        },
        {
          wrapper: ".createPitchButton",
          popup: {
            content: "#walkthrough-2",
            type: "tooltip",
            position: "right"
          }
        },
        {
          wrapper: ".findJournilists",
          popup: {
            content: "#walkthrough-3",
            type: "tooltip",
            position: "right"
          }
        },
        {
          wrapper: ".searchArticles a",
          popup: {
            content: "#walkthrough-4",
            type: "tooltip",
            position: "right"
          }
        },
        {
          wrapper: ".campaigns",
          popup: {
            content: "#walkthrough-5",
            type: "tooltip",
            position: "right"
          }
        },
        {
          wrapper: ".newsJacking ",
          popup: {
            content: "#walkthrough-6",
            type: "tooltip",
            position: "right"
          }
        }
      ]
    });

    if (!walk_through_status) {
      $("body").pagewalkthrough("show");
    }
  } catch (err) {
    console.log(err);
  }
});
