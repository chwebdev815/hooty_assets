/* global swal:true */
$(document)
    .ready(function() {
        $.extend($.fn.dataTable.defaults, {
            searching: false,
            paging: false,
            info: false

        })

        $('#example')
            .DataTable({

                columnDefs: [{
                    targets: [1, 2, 3, 4],
                    className: 'dt-center'
                }],
                responsive: true

            })
    })

/* SWEET ALERT SCRIPT */

$('table')
    .on('click', '.unsubscribeA', function(e) {
        e.preventDefault()
        swal({
                title: 'Are you sure?',
                text: 'Are you sure you want to unsubscribe?!',
                icon: "{{asset('assets/img/frown-face.png')}}",
                buttons: true,
                dangerMode: true

            })
            .then((willDelete) => {
                if (willDelete) {
                    swal('You have succefully unsubscribed!', {
                            icon: 'success'
                        })
                        // } else {
                        //     swal("Your imaginary file is safe!", {
                        //         icon: "/src/img/happyFace.png",
                        //     });
                }
            })
    })