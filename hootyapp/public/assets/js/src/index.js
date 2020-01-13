/* global Chart:true */
/* eslint-disable no-new */
jQuery(document).ready(function () {
  // GRAPH OPEN RATES
  var ctx = $('#chartOpenRates')
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Aug 1', 'Aug 2', 'Aug 3', 'Aug 4', 'Aug 5', 'Aug 6', 'Aug 7'],
      datasets: [{
        label: 'Open rates',
        data: [12, 10, 3, 21, 2, 16, 18],
        backgroundColor: 'rgba(54, 162, 235)',
        borderColor: 'rgba(54, 162, 235, 1)'
      }]
    },
    options: {
      scales: {
        xAxes: [{
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Days'
          },
          barPercentage: 0.2
        }],
        yAxes: [{
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Value'
          }
        }]
      }
    }
  })
  // GRAPH REPLAY RATES

  var ctxr = $('#chartReplyRates')
  new Chart(ctxr, {
    type: 'bar',
    data: {
      labels: ['Aug 1', 'Aug 2', 'Aug 3', 'Aug 4', 'Aug 5', 'Aug 6', 'Aug 7'],
      datasets: [{
        label: 'Reply rates',
        data: [12, 19, 3, 5, 2, 3, 23],
        backgroundColor: 'rgba(255, 99, 132)',
        borderColor: 'rgba(255,99,132,1)'
      }]
    },
    options: {
      scales: {
        xAxes: [{
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Days'
          },
          barPercentage: 0.2
        }],
        yAxes: [{
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Opened'
          }
        }]
      }
    }
  }) // TOOLTIP

  $('[data-toggle="tooltip"]').tooltip()
  // DATATABLE

  $.extend($.fn.dataTable.defaults, {
    searching: false,
    paging: true,
    info: false
  })
  $('#dashDtable').DataTable({
    columnDefs: [{
      targets: [1, 2, 3, 4],
      className: 'dt-center'
    }],
    responsive: true,
    scrollY: 200,
    deferRender: true,
    scroller: true
  })
  $('#getstarted').click(function () {
    $('#wizardModal').modal('show')
    setTimeout(function () {
      $('#firstModal').modal('toggle')
    }, 50)
  })
  $('#secondModal').modalSteps({
    btnCancelHtml: 'Cancel',
    btnNextHtml: 'Next',
    btnLastStepHtml: 'Complete',
    disableNextButton: false,
    completeCallback: function () {
      window.location.href = 'compose.html'
    },
    callbacks: {},
    getTitleAndStep: function () {}
  })
}) // $('#list-tags').selectize({
//     plugins: ['remove_button'],
//     delimiter: ',',
//     persist: false,
//     create: function(input) {
//         return {
//             value: input,
//             text: input
//         }
//     }
// });
// # sourceMappingURL=index.js.map
