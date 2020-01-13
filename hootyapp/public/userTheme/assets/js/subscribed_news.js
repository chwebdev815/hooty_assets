var page1 = 1;
var page = 1;
var temp = 0;
var v = 1
var selectedTab = "journalist";
let totalArticlePages;


function searchArticles(page = 1) {
    $.ajax({
        type: 'POST',
        url: api_url + '/v1/search-news',
        data: {
            text: phrases,
            genre: genre,
            outlets: outlets && outlets.length > 1 ? JSON.parse(outlets) : null,
            page: page
        },
        success: function(data) {
            console.log(data);
            $('.loader').addClass('d-none');
            handleBarData(data);
        }
    })

}

searchArticles();

function handleBarData(data) {
    var display = `${data.count} results of "${phrases}" found`
    var dataArray = data.docs
    totalArticlePages = data.pages;

    if (dataArray.length > 0) {
        $('#buttonToshowAlerts').removeClass('d-none');
        $('.noresults').addClass('d-none');
    } else {
        $('#buttonToshowAlerts').addClass('d-none');
        $('.noresults').removeClass('d-none');
    }

    $('#keyAndCount').find('.totalResults').html(display);

    for (let i = 0; i < dataArray.length; i++) {
        let template = $('#articleCards').html();
        let element = $(template);
        // $(element).find('input[name="sub_news[]"]').val(dataArray[i]._id);
        $(element).find('.selectedArticles').attr('value', (dataArray[i]._id));
        $(element).find('.singleArticle').attr('value', (dataArray[i]._id));

        $(element).find('.articleImage').attr('src', (dataArray[i].image))
        $(element).find('.tttt').attr('data-url', (dataArray[i].url))
        $(element).find('h5').html(dataArray[i].title);
        $(element).find('.articleContent').html(dataArray[i].content);
        $(element).find('.articleAuthor').html(dataArray[i].author_name);
        $(element).find('.articleOutlet').html(dataArray[i].source_name);
        $(element).find('.articleGenre').html(dataArray[i].genre);
        $(element).find('.date span').html($.timeago(dataArray[i].date));
        $('.data-articles').append($(element));
    }

}

$('body').on('click', '.tttt', function() {
    var url = $(this).attr('data-url');
    $('.newsDisplayFrame').attr('src', url);
})

function sendAllButtonToggle() {
    var subscribeNewsAlerts = [];

    $.each($('input[name="sub_news[]"]:checked'), function() {
        subscribeNewsAlerts.push($(this).val());
    });
    if (subscribeNewsAlerts.length > 0) {
        $('#btnSendToAll').removeClass('d-none');
    } else {
        $('#btnSendToAll').addClass('d-none');
    }
}

$(window).scroll(function() {
    if ($(window).scrollTop() + $(window).height() == $(document).height()) {
        if (page < totalArticlePages) {
            searchArticles(page++)
        }
    }
    // MULTI SELECT
});