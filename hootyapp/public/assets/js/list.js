/* global swal:true */
$(document).ready(function() {
  $.extend($.fn.dataTable.defaults, {
    searching: false,
    paging: false,
    info: false
  });
  let table = $("#listPageTable").DataTable({
    responsive: true,

    order: [[1, "asc"]]
  });

  table.columns().iterator("column", function(ctx, idx) {
    if (idx > 0 && idx < 3) {
      $(table.column(idx).header()).append('<span class="sort-icon"/>');
    }
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
          url: "/group/delete/" + id,
          success: function() {
            location.reload();
          }
        });
      }
    });
  });
  /* SWEET ALERT SCRIPT END */
}); // # sourceMappingURL=list.js.map
//# sourceMappingURL=list.js.map
