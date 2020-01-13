var page = 1;
$( ".live_search_outlet").click(function() {
    $(".list_data").html('');
    $("#selected").val(0);
    $(".select_all_record_label").hide();
    $('#allselect').prop('checked', false);
    $(".count_selected_btn").html('<sam class="total_record">0</sam> - <sam class="view_record">Selected</sam>');
    var name = $("#search").val();

    var data = {
        'search' : name,
        'page' : page,
        'type' : 'outlet'
    }
    $.ajax({
        dataType: 'json',
        url: url+ '/',   
        data: data
    }).done(function(data){
        $(".search_deta_box").attr('style',"display: block;");

        var rows = '';
        $.each( data.journalist, function( key, value ) {
            rows = rows + '<tr>';
            rows = rows + '<td width="15%"><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input select_all" id="checkmeout_'+key+'"><label class="custom-control-label select_box_margin" for="checkmeout_'+key+'"></label></div></td>';
            rows = rows + '<td width="30%">'+value.First_name+' '+value.Last_name+'</td>';
            rows = rows + '<td width="20%">'+value.Domain_name+'</td>';
            rows = rows + '<td></td>';
            rows = rows + '</tr>';
        });


        $(".list_data").html(rows);
        $(".count_btn   ").html('<sam class="total_record">'+data.journalist.length+'</sam> - <sam class="view_record">'+data.journalist_count+'</sam>');
        var t_page = $("#t_record").val(data.journalist_count);
        var no_record = $("#no_record").val(data.journalist.length);
    });
});

$( ".live_search_keyword").click(function() {
    $(".list_data").html('');
    $("#selected").val(0);
    $(".select_all_record_label").hide();
    $('#allselect').prop('checked', false);
    $(".count_selected_btn").html('<sam class="total_record">0</sam> - <sam class="view_record">Selected</sam>');
    var name = $("#search").val();

    var data = {
        'search' : name,
        'page' : page,
        'type' : 'keyword'
    }
    $.ajax({
        dataType: 'json',
        url: url+ '/',   
        data: data
    }).done(function(data){
        $(".search_deta_box").attr('style',"display: block;");

        var rows = '';
        $.each( data.journalist, function( key, value ) {
            rows = rows + '<tr>';
            rows = rows + '<td width="15%"><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input select_all" id="checkmeout_'+value.id+'"><label class="custom-control-label select_box_margin" for="checkmeout_'+value.id+'"></label></div></td>';
            rows = rows + '<td width="30%">'+value.First_name+' '+value.Last_name+'</td>';
            rows = rows + '<td width="20%">'+value.Domain_name+'</td>';
            rows = rows + '<td></td>';
            rows = rows + '</tr>';
        });


        $(".list_data").html(rows);
        $(".count_btn   ").html('<sam class="total_record">'+data.journalist.length+'</sam> - <sam class="view_record">'+data.journalist_count+'</sam>');
        var t_page = $("#t_record").val(data.journalist_count);
        var no_record = $("#no_record").val(data.journalist.length);
    });
});

var temp = 0;
var v = 1
$(window).scroll(function(){

if(temp == 0)
{
    if($(window).scrollTop() + $(window).height() == $(document).height()) {
        if(v == 1)
        {
            v = 0;
            $(".loding img").show();
            
            var name = $("#search").val();
            page++;

            var data = {
                'search' : name,
                'page' : page
            }
            $.ajax({
                dataType: 'json',
                url: url+ '/',   
                data: data
            }).done(function(data){

                var rows = '';
                $.each( data.journalist, function( key, value ) {
                    rows = rows + '<tr>';
                    if($("#selected").val() == 1)
                    {
                        rows = rows + '<td width="10%"><div class="custom-control custom-checkbox"><input type="checkbox"  checked="" class="custom-control-input select_all" id="checkmeout_'+value.id+'"><label class="custom-control-label select_box_margin" for="checkmeout_'+value.id+'"></label></div></td>';
                    }
                    else
                    {
                        rows = rows + '<td width="10%"><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input select_all" id="checkmeout_'+value.id+'"><label class="custom-control-label select_box_margin" for="checkmeout_'+value.id+'"></label></div></td>';
                    }
                    rows = rows + '<td width="30%">'+value.First_name+' '+value.Last_name+'</td>';
                    rows = rows + '<td width="20%">'+value.Domain_name+'</td>';
                    rows = rows + '<td></td>';
                    rows = rows + '</tr>';
                });
                setTimeout(function(){

                    $(".list_data tr:last").after(rows);
                    var t_page = $("#t_record").val(data.journalist_count);
                    var no_record = $("#no_record").val(data.temp.length);
                    if(data.journalist_count == data.temp.length)
                    {
                        temp = 1;
                    }

                    $(".count_btn").html('<sam class="total_record">'+data.temp.length+'</sam> - <sam class="view_record">'+data.journalist_count+'</sam>');
                    $(".loding img").hide();
                    v = 1;
                }, 1500);
            });
        }
    }   
}
var numberOfChecked = $('.list_data input:checkbox:checked').length;
$(".count_selected_btn").html('<sam class="total_record">'+numberOfChecked+'</sam> - <sam class="view_record">Selected</sam>');

});

window.onscroll = function() {myFunction()};
var header = document.getElementById("myHeader");
var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}

$("#allselect").click(function () {

    if($("#allselect").prop('checked') == true)
    {
        $('.select_all').prop('checked', true);
    }
    else
    {
        $('.select_all').prop('checked', false);
    }
        var t_page = $("#t_record").val();
        var no_record = $("#no_record").val();

        if($(".select_all").prop('checked') == true){
            $(".select_all_record_label").show();
            $(".all_row_remove_seleced").hide();
            $(".all_row_seleced").show();
            $(".all_row_seleced").html('<span>All '+no_record+' contacts on this page are selected. Select all '+t_page+' contacts in this list.</span>')
        }
        else
        {
            $(".all_row_remove_seleced").show();
            $(".select_all_record_label").hide();
        }

});

$(".all_row_seleced").click(function () {
    $("#selected").val(1);
    $('.select_all').prop('checked', true);
    $(".all_row_seleced").hide();
    $(".all_row_remove_seleced").show();

    var t_page = $("#t_record").val();
    $(".all_row_remove_seleced").html('All '+t_page+' contacts in this list are selected. Clear selection')
});

$(".all_row_remove_seleced").click(function () {
    $("#selected").val(0);
    $('#allselect').prop('checked', false);
    $('.select_all').prop('checked', false);
    $(".all_row_seleced").hide();
    $(".all_row_remove_seleced").hide();

    var t_page = 0;
    $(".all_row_remove_seleced").html('All '+t_page+' contacts in this list are selected.Clear selection')
    $(".select_all_record_label").hide();
});

$("body").click(function () {
    var numberOfChecked = $('.list_data input:checkbox:checked').length;
    $(".count_selected_btn").html('<sam class="total_record">'+numberOfChecked+'</sam> - <sam class="view_record">Selected</sam>');
});