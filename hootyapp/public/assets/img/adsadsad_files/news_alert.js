/* global swal:true */
$(document).ready(function() {
    $.extend($.fn.dataTable.defaults, {
        searching: false,
        paging: false,
        info: false
    });
    $('#example').DataTable({
        columnDefs: [{
            targets: [1, 2, 3, 4],
            className: 'dt-center'
        }],
        responsive: true
    });

    /* SWEET ALERT SCRIPT */

    if (typeof journalistNumber !== "undefined") {
        console.log('dasc', journalistNumber.length);
        $('#news_alert_search').addClass('d-none');
        if (journalistNumber.length > 0) {
            $('#news_alert_search').removeClass('d-none');
            $('.noresults_journalist').addClass('d-none');
        } else {
            $('#news_alert_search').addClass('d-none');
            $('.noresults_journalist').removeClass('d-none');

        }
    }

    $('body').on('click', '.iframeModal2', function() {
        var url = $(this).data('url');
        url = url.replace("http://", "https://");
        $('.newsDisplayFrame').attr('src', "");
        $.ajax({
            type: "POST",
            url: "/check-url-good-for-iframe",
            data: {
                url: url
            },
            success: function(result) {
                console.log('DDATA', result);
                if (!result.success) {
                    var win = window.open(url, 'newsWindow', 'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=600,height=600');
                    $("#iframeViewModal").modal('hide');
                } else {
                    $('.iframe-loader').addClass('d-none');
                    $('.newsDisplayFrame').attr('src', url);
                }
            },
            error: function() {

            }
        });
    })

    $('table').on('click', '.unsubscribeA', function(e) {
        var id = $(this).data('id');
        var token = $('#token').val();
        var link = $(this);
        e.preventDefault();
        swal({
            title: 'Are you sure?',
            text: 'Are you sure you want to unsubscribe?!',
            icon: 'assets/img/frown-face.png',
            buttons: true,
            dangerMode: true
        }).then(willDelete => {
            if (willDelete) {
                console.log("Ajax running")
                console.log(app_url + '/news-alerts/delete/');
                $.ajax({
                    type: 'GET',
                    url: app_url + '/news-alerts/delete/' + id,
                    success: function(data) {

                        link.parent().parent().remove();
                        // location.reload();
                    },

                })

            }

        });
    });

});