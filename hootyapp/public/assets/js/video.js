var recordedData;
var recorded_form_data;

toastr.options.timeOut = 1000; // 1s

var uploader;
var webCamVideouploader;

var player = videojs(
  "myVideo",
  {
    controls: true,

    height: 540,
    fluid: false,
    plugins: {
      record: {
        audio: true,
        video: true,
        maxLength: 10,
        debug: true
      }
    }
  },
  function() {
    // print version information at startup
    var msg =
      "Using video.js " +
      videojs.VERSION +
      " with videojs-record " +
      videojs.getPluginVersion("record") +
      " and recordrtc " +
      RecordRTC.version;
    videojs.log(msg);
  }
);

// error handling
player.on("deviceError", function() {
  console.log("device error:", player.deviceErrorCode);
});

player.on("error", function(error) {
  console.log("error:", error);
});

// user clicked the record button and started recording
player.on("startRecord", function() {
  console.log("started recording!");
  toastr.success("The video recording has been started", "Success");
});

// user completed recording and stream is available
player.on("finishRecord", function() {
  console.log("finished recording: ", player.recordedData);
  toastr.success("The video recording has been stoped", "Success");
  recordedData = player.recordedData;
});

$("#videoSaveBtn").click(() => {
  if (recordedData) {
    $("#videoSaveBtn").prop("disabled", true);
    $("#videoSaveBtn").html(
      '<i class="fa fa-spinner fa-pulse"></i>&nbsp;&nbsp;Uploading Files...</button>'
    );

    webCamVideouploader.addFile(recordedData);

    setTimeout(function() {
      webCamVideouploader.processQueue();
    }, 500);
  } else {
    console.log("false");
  }
});

function saveAttributesAjaxCall(name) {
  var token = $("#token").val();

  $.ajax({
    method: "POST",
    url: "/save-video-attributes",
    data: {
      name: name,
      _token: token
    },
    success: function(data) {
      console.log("saveAttributesAjaxCall Success", data);
    },
    error: function(err) {
      console.log("saveAttributesAjaxCall Error", err);
    }
  });
}

/* global Chart:true */

/* eslint-disable no-new */
jQuery(document).ready(function() {
  // GRAPH OPEN RATES

  $.extend($.fn.dataTable.defaults, {
    searching: false,
    paging: false,
    info: false
  });
  $("#dashDtable").DataTable({
    columnDefs: [
      {
        targets: [0],
        className: "p-2"
      },
      {
        targets: [1, 2, 3],
        className: "dt-center"
      }
    ],
    responsive: true
  });
});

//DROPZONE UPLOAD
// Make AJAX POST requests work with laravel. See https://stackoverflow.com/a/47806189
$.ajaxSetup({
  beforeSend: function(xhr, type) {
    if (!type.crossDomain) {
      xhr.setRequestHeader(
        "X-CSRF-Token",
        $('meta[name="csrf-token"]').attr("content")
      );
    }
  }
});

jQuery(document).ready(function($) {
  uploader = new Dropzone("#s3dropzone", {
    url: $("#s3dropzone").attr("action"),
    autoProcessQueue: true,
    maxfiles: 5,
    timeout: null,
    parallelUploads: 3,
    maxThumbnailFilesize: 8, // 3MB
    thumbnailWidth: 150,
    thumbnailHeight: 150,
    acceptedFiles: ".mp4,.mov,.avi,.mpeg4,.flv,.3gpp",
    accept: function(file, done) {
      file.postData = [];
      $.ajax({
        url: aws_upload_url,
        data: {
          filename: file.name
        },
        type: "POST",
        dataType: "json",
        success: function(response) {
          console.log(response);
          if (!response.success) done(response.message);

          delete response.success;
          file.custom_status = "ready";
          file.postData = response;
          file.s3 = response.key;
          $(file.previewTemplate).addClass("uploading");
          done();
        },
        error: function(response) {
          file.custom_status = "rejected";
          if (response.responseText) {
            response = JSON.parse(response.responseText);
          }
          if (response.message) {
            done(response.message);
            return;
          }
          done("error preparing the upload");
        }
      });
    },
    /**
     * Called just before each file is sent.
     * @param object   file https://developer.mozilla.org/en-US/docs/Web/API/File
     * @param object   xhr
     * @param object   formData https://developer.mozilla.org/en-US/docs/Web/API/FormData
     */
    sending: function(file, xhr, formData) {
      $("#dropzoneFA1").addClass("d-none");
      $("#dropzoneFA2").addClass("d-none");

      $("#dropzoneFA").html(
        "<i class='fa fa-spinner fa-pulse'></i>&nbsp;&nbsp;Uploading Files...</button>"
      );

      $.each(file.postData, function(k, v) {
        formData.append(k, v);
      });

      formData.append("Content-type", "application/octet-stream");
      // formData.append('Content-length', '');
      formData.append("acl", "public-read");
      formData.append("success_action_status", "200");

      console.log("FILE POST DATA", file);

      for (var value of formData.keys()) {
        console.log("FORM DATA", value, formData.get(value));
      }
    },
    success: function(file) {
      console.log(file);
      $("#dropzoneFA1").removeClass("d-none");
      $("#dropzoneFA2").removeClass("d-none");

      var name = file.name;
      toastr.success("The Video has been Uploaded.", "Success");
      $("#dropzoneFA1").removeClass("d-none");
      $("#dropzoneFA1").removeClass("d-none");
      $("#dropzoneFA").addClass("d-none");

      saveAttributesAjaxCall(name);
      $("#uploadVideoModal").modal("hide");
    }
  });
  uploader.on("complete", function(file) {
    uploader.removeFile(file);
  });

  webCamVideouploader = new Dropzone("#webCamDropzone", {
    url: $("#s3dropzone").attr("action"),
    autoProcessQueue: false,
    maxfiles: 5,
    timeout: null,
    parallelUploads: 3,
    maxThumbnailFilesize: 8, // 3MB
    thumbnailWidth: 150,
    thumbnailHeight: 150,
    acceptedFiles: ".mp4,.mov,.avi,.mpeg4,.flv,.3gpp, .webm",
    accept: function(file, done) {
      file.postData = [];
      $.ajax({
        url: aws_upload_url,
        data: {
          filename: file.name
        },
        type: "POST",
        dataType: "json",
        success: function(response) {
          console.log(response);
          if (!response.success) done(response.message);

          delete response.success;
          file.custom_status = "ready";
          file.postData = response;
          file.s3 = response.key;
          $(file.previewTemplate).addClass("uploading");
          done();
        },
        error: function(response) {
          file.custom_status = "rejected";
          if (response.responseText) {
            response = JSON.parse(response.responseText);
          }
          if (response.message) {
            done(response.message);
            return;
          }
          done("error preparing the upload");
        }
      });
    },
    sending: function(file, xhr, formData) {
      // $("#dropzoneFA1").addClass("d-none");
      // $("#dropzoneFA2").addClass("d-none");

      // $("#dropzoneFA").html(
      //   "<i class='fa fa-spinner fa-pulse'></i>&nbsp;&nbsp;Uploading Files...</button>"
      // );

      $.each(file.postData, function(k, v) {
        formData.append(k, v);
      });

      formData.append("Content-type", "application/octet-stream");

      // formData.append('Content-length', '');
      formData.append("acl", "public-read");
      formData.append("success_action_status", "200");

      console.log("FILE POST DATA", file);

      for (var value of formData.keys()) {
        console.log("FORM DATA", value, formData.get(value));
      }
    },
    success: function(file) {
      // $("#dropzoneFA1").removeClass("d-none");
      // $("#dropzoneFA2").removeClass("d-none");
      // var name = file.name;
      // toastr.success("The Video has been Uploaded.", "Success");
      // $("#dropzoneFA1").removeClass("d-none");
      // $("#dropzoneFA1").removeClass("d-none");
      // $("#dropzoneFA").addClass("d-none");
      // saveAttributesAjaxCall(name);
      // $("#uploadVideoModal").modal("hide");
    }
  });
});

/* SWEET ALERT SCRIPT */

$("table").on("click", ".deleteJ", function(e) {
  var id = $(this).data("id");
  console.log(id);

  e.preventDefault();
  swal({
    title: "Are you sure?",
    text: "Are you sure you want to remove this list?!",
    icon: "warning",
    buttons: true,
    dangerMode: true
  }).then(willDelete => {
    if (willDelete) {
      $.ajax({
        url: "/video/delete/" + id,
        success: function() {
          location.reload();
        }
      });
      //   location.reload();
      // }
      //   });
    } else {
      swal("Cancelled!");
    }
  });
});
/* SWEET ALERT SCRIPT END */
