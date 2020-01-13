// DATATABLES JQUERY
/* global swal:true */
$(document).ready(function () {
  $.extend($.fn.dataTable.defaults, {
    searching: false,
    paging: true,
    info: false
  })
  $('#example').DataTable({
    // columnDefs: [{
    //     targets: [1, 2, 3, 4],
    //     className: 'dt-center'
    // }],
    responsive: true,
    scrollY: 200,
    deferRender: true,
    scroller: true
  })
  /* SWEET ALERT SCRIPT */

  $('table').on('click', '.deleteJ', function (e) {
    e.preventDefault()
    swal({
      title: 'Are you sure?',
      text: 'Are you sure you want to remove this list?!',
      icon: 'warning',
      buttons: true,
      dangerMode: true
    }).then(willDelete => {
      if (willDelete) {
        swal('Poof! You have successfully removed the list.', {
          icon: 'success'
        })
      } // else {
      //     swal("Your imaginary file is safe!");
      // }
    })
  })
  /* SWEET ALERT SCRIPT END */

  $('#list_tags').selectize({
    // create: true,
    maxItems: 1,
    delimiter: ',',
    persist: false,
    create: function (input) {
      return {
        value: input,
        text: input
      }
    },
    options: [{
      value: 'avenger',
      text: 'Forbes Journalists'
    }, {
      value: 'caliber',
      text: 'Life/Health Journalists'
    }, {
      value: 'caravan-grand-passenger',
      text: 'Tech News Journalists'
    }]
  })
})
// # sourceMappingURL=individual_list.js.map
