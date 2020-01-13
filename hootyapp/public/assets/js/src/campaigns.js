// import jQuery from 'jquery';

(function ($) {
  $(document).ready(function () {
    $.extend($.fn.dataTable.defaults, {
      searching: false,
      paging: false,
      info: false
    })
    $('#campDtable').DataTable({
      columnDefs: [{
        targets: [2, 3, 4, 5],
        className: 'dt-center'
      }],
      responsive: true
    })
  })
})(jQuery)
// # sourceMappingURL=campaigns.js.map
