/* global message:true */
(function($) {
    $(document).ready(function() {
        $('.list-group-item').click(function() {
            $('#report-tab').addClass('d-sm-down-none');
            $('#reportBox').removeClass('d-sm-down-none');
            console.log($(this).data("id"));
            var id = $(this).data("id");
            $.ajax({
                url: "/individual-campaign/?id=" + id + "&json=true",
                success: function(result) {
                    console.log(JSON.parse(result));
                    $('#list_home').html(result);
                }
            });
        });

        $('#backKey').click(function() {
            $('#reportBox').addClass('d-sm-down-none');
            $('#report-tab').removeClass('d-sm-down-none');
        });

        $('#sideHeader .list-group a').each(function() {
            var ThisHref = $(this).attr('href')
            if (window.location.href.indexOf(ThisHref) > -1) {
                $(this).addClass('active');
            }
        });


        $.extend($.fn.dataTable.defaults, {
            searching: false,
            paging: false,
            info: false
        });

        let tableLoad = $('#listWiseReport').DataTable({
            "aaSorting": [],
            columnDefs: [{
                targets: [1, 2, 3],
                className: 'dt-center'
            }],
            responsive: true
        });

        $("#firstLink").click(function() {
            tableLoad.columns.adjust().responsive.recalc();
            $("#sideHeader").addClass("d-sm-down-none")
            $("#campaignName").removeClass("d-none d-md-block")
            setTimeout(function() {
                // $('#example').DataTable().reload()
            }, 0)
        });

        // modal
        $('#getstarted').click(function() {
            $('#wizardModal').modal('show')
            setTimeout(function() {
                $('#firstModal').modal('toggle')
            }, 50)
        });
        $('#secondModal').modalSteps({
            btnCancelHtml: "Cancel",
            btnNextHtml: "Next",
            btnLastStepHtml: "Complete",
            disableNextButton: false,
            completeCallback: function() {
                window.location.href = 'compose.html'
            },
            callbacks: {},
            getTitleAndStep: function() {}
        });
    });
})(jQuery);
//# sourceMappingURL=inbox.js.map