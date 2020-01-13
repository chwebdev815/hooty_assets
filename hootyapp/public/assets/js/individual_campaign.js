$(document).ready(function() {
    $.extend($.fn.dataTable.defaults, {
        searching: false,
        paging: false,
        info: false
    });
    $('#listWiseReport').DataTable({
        "aaSorting": [],
        columnDefs: [{
            targets: [1, 2, 3],
            className: 'dt-center'
        }],
        responsive: true,
        deferRender: true,
        // scroller: true
    }); // Configure/customize these variables.

    var showChar = 200; // How many characters are shown by default

    var ellipsestext = '...';
    var moretext = 'Show more >';
    var lesstext = 'Show less';
    $('.more').each(function() {
        var content = $(this).html();

        if (content.length > showChar) {
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
            var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
            $(this).html(html);
        }
    });
    $('.morelink').click(function() {
        if ($(this).hasClass('less')) {
            $(this).removeClass('less');
            $(this).html(moretext);
        } else {
            $(this).addClass('less');
            $(this).html(lesstext);
        }

        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
}); // # sourceMappingURL=individual_campaign.js.map
//# sourceMappingURL=individual_campaign.js.map