/* global swal:true */

$(document).ready(function () {
  $.extend($.fn.dataTable.defaults, {
    searching: false,
    paging: false,
    info: false
  })
  $('#example').DataTable({
    responsive: true,
    'columnDefs': [{
      'targets': 0,
      'checkboxes': {
        'selectRow': true
      }
    }],
    'select': {
      'style': 'multi'
    },
    'order': [
      [1, 'asc']
    ]
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
})
// # sourceMappingURL=list.js.map
