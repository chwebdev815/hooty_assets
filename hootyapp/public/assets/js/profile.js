$(document).ready(function() {
  if (currentPlanId === 3) {
    $("#lite_montly").prop("disabled", true);
  } else if (currentPlanId === 4) {
    $("#lite_yearly").prop("disabled", true);
  }

  if (current_status === -1) {
    $("#planCancel").addClass("d-none");
    $("#planResume").removeClass("d-none");
  }

  $.extend($.fn.dataTable.defaults, {
    searching: false,
    paging: true,
    info: false
  });
  $("#example").DataTable({
    drawCallback: function(settings) {
      $(".headerNone thead").remove();
    },
    scrollY: 200,
    deferRender: true,
    scroller: true
  });

  /*SWEET ALERT SCRIPT*/
  $("#planCancel").click(function() {
    var token = $("#token").val();
    swal({
      title: "Cancel?",
      text: "Are you sure you want to cancel this plan?",
      icon: "assets/img/frown-face.png",
      buttons: ["No", "Yes"],
      dangerMode: true
    }).then(willDelete => {
      if (willDelete) {
        $("#planCancel")
          .prop("disabled", true)
          .html("Processing...");
        $.ajax({
          url: "/pay/lite/cancel",
          success: function(data) {
            console.log(data, "data");
            swal("Done! We gonna miss you.", {
              icon: "success"
            });
            $("#planCancel")
              .prop("disabled", false)
              .html("Cancel");
            window.location.reload();
          },
          error: function(jqXHR, exception) {
            console.log(jqXHR, exception);
            $("#planCancel")
              .prop("disabled", false)
              .html("Cancel");
          }
        });
      }
    });
  });
  $("#planResume").click(function() {
    var token = $("#token").val();
    swal({
      title: "Are you sure?",
      text: "Are you sure you want to resume this plan!",
      icon: "assets/img/happyFace.png",
      buttons: true
    }).then(ifYes => {
      if (ifYes) {
        console.log(ifYes);
        $("#planResume")
          .prop("disabled", true)
          .html("Processing...");
        $.ajax({
          url: "pay/lite/resume",
          success: function(data) {
            console.log(data);
            window.location.reload();
          },
          error: function(jqXHR, exception) {
            console.log(jqXHR, exception);
            $("#planResume")
              .prop("disabled", false)
              .html("Cancel");
          }
        });
      }
    });
  });
  //ImageCrop Script
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
  });

  $uploadCrop = $("#upload-demo").croppie({
    enableExif: true,
    viewport: {
      width: 200,
      height: 200,
      type: "circle"
    },
    boundary: {
      width: 300,
      height: 300
    }
  });

  $("#upload").on("change", function() {
    var reader = new FileReader();
    reader.onload = function(e) {
      $uploadCrop
        .croppie("bind", {
          url: e.target.result
        })
        .then(function() {
          console.log("jQuery bind complete");
        });
    };
    reader.readAsDataURL(this.files[0]);
  });

  let imgResp;
  $(".upload-result").on("click", function(ev) {
    ev.preventDefault();
    $uploadCrop
      .croppie("result", {
        type: "canvas",
        size: "viewport"
      })
      .then(function(resp) {
        imgResp = resp;
        console.log(`image working ${imgResp}`);
        $("#image").val(resp);
        $(".profile-pic").attr("src", resp);
        $("#imageCropModal").modal("hide");
      });
  });

  $(".lite_plan").click(function(e) {
    var planId = $(this).data("plan");
    console.log(planId, "planId");
    if (planId === 1) {
      $("#lite_montly")
        .prop("disabled", true)
        .html("PROCESSING...");
    } else if (planId === 2) {
      $("#lite_yearly")
        .prop("disabled", true)
        .html("PROCESSING...");
    }
    var token = $("#token").val();

    $.ajax({
      type: "POST",
      url: "/pay/lite/update",
      data: {
        plan: planId
      },
      success: function(data) {
        console.log(data, "data");
        location.reload();
      },
      error: function(jqXHR, exception) {
        console.log(jqXHR, exception);
        if (planId === 1) {
          $("#lite_montly")
            .prop("disabled", false)
            .html("GET STARTED  <span class='d-none d-xl-inline'>30-DAY FREE TRIAL</span>");
        } else if (planId === 2) {
          $("#lite_yearly")
            .prop("disabled", false)
            .html("GET STARTED  <span class='d-none d-xl-inline'>30-DAY FREE TRIAL</span>");
        }
      }
    });
  });

  // $('#profile').on('submit', function(e) {
  //     e.preventDefault();
  //     let formData = $(this).serializeArray()

  //     let formDataPlus = {};
  //     var key;

  //     for (let i = 0; i < formData.length; i++) {

  //         key = formData[i].name;

  //         formDataPlus[key] = formData[i].value;

  //     }

  //     formDataPlus.image = imgResp;

  //     console.log(formDataPlus);

  // })

  //ImageCrop Script End

  //Image Upload

  var readURL = function(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $(".profile-pic").attr("src", e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  };

  $(".file-upload").on("change", function() {
    readURL(this);
  });

  $(".upload-button").on("click", function() {
    $(".file-upload").click();
  });
});
