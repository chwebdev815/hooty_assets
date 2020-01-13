// DATATABLES JQUERY

/* global swal:true */
$(document).ready(function() {


    /* SWEET ALERT SCRIPT */

    $('table').on('click', '.deleteJ', function(e) {
        var id = $(this).data('id');
        console.log(id);
        e.preventDefault();
        swal({
            title: 'Are you sure?',
            text: 'Are you sure you want to remove this list?!',
            icon: 'warning',
            buttons: true,
            dangerMode: true
        }).then(willDelete => {
            if (willDelete) {
                console.log("Ajax running")
                $.ajax({
                    url: '/member/delete/' + id,
                    success: function(data) {

                        location.reload();
                    },

                })

            }

        });
    });
    /* SWEET ALERT SCRIPT END */


    $.extend($.fn.dataTable.defaults, {
        searching: false,
        paging: false,
        info: false
    });
    $('#example').DataTable({
        // columnDefs: [{
        //     targets: [1, 2, 3, 4],
        //     className: 'dt-center'
        // }],
        responsive: true,
        // scrollY: 200,
        deferRender: true,
        // scroller: true
    });


}); // # sourceMappingURL=individual_list.js.map
//# sourceMappingURL=individual_list.js.map