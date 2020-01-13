// import jQuery from 'jquery';
(function($) {
  $(document).ready(function() {
    $.extend($.fn.dataTable.defaults, {
      searching: false,
      paging: false,
      info: false
    });
    var table = $("#campDtable").DataTable({
      aaSorting: [],
      columnDefs: [
        {
          targets: [2, 3, 4, 5],
          className: "dt-center"
        }
      ],
      responsive: true
    });

    table.columns().iterator("column", function(ctx, idx) {
      if (idx < 6) $(table.column(idx).header()).append('<span class="sort-icon"/>');
    });

    $(".deleteJ").on("click", function(e) {
      var id = $(this).data("id");

      e.preventDefault();

      swal({
        title: "Are you sure?",
        text: "Are you sure you want to remove this campaign?",
        icon: "warning",
        buttons: ["No", "Yes"],
        dangerMode: true
      }).then(willDelete => {
        if (willDelete) {
          $.ajax({
            url: "/campaign/delete/" + id,
            success: function() {
              location.reload();
            }
          });
        }
      });
    });
  });
})(jQuery); // # sourceMappingURL=campaigns.js.map
//# sourceMappingURL=campaigns.js.map
