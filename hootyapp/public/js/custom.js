/* manage data list */
$( ".show_member").click(function() {
    var id = $(this).parent("td").data('id');

    $.ajax({
        dataType: 'json',
        url: url + '/' + id,
    }).done(function(data){
        //console.log(data.groups_member);
        $(".group_name").html('<b>'+data.group.name+'</b>');
        var rows = '';
        var colum = '';
        $.each( data.groups_member, function( key, value ) {
            rows = rows + '<tr>';
            rows = rows + '<td>'+value.id+'</td>';
            rows = rows + '<td>'+value.First_name+'</td>';
            rows = rows + '<td>'+value.Last_name+'</td>';
            rows = rows + '<td>'+value.email_address+'</td>';
            rows = rows + '</td>';
            rows = rows + '</tr>';
        });


        $(".member_row_data").html(rows);
    });
});

$( ".block_btn").click(function() {
    var id = $(this).parent("td").data('id');
    $.ajax({
        dataType: 'json',
        url: block_url + '/' + id,
    }).done(function(data){
        $(".block_btn_"+id).addClass('display_non');
        $(".active_btn_"+id).removeClass('display_non');
    });
});

$( ".active_btn").click(function() {
    var id = $(this).parent("td").data('id');
    $.ajax({
        dataType: 'json',
        url: active_url + '/' + id,
    }).done(function(data){
        $(".active_btn_"+id).addClass('display_non');
        $(".block_btn_"+id).removeClass('display_non');
    });
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


jQuery(document).ready(function(){
    $( "#chat_search_box" ).on('input', function(e) {
        var name = $("#chat_search_box").val();
        var message_id = $("#message_id").val();
        var journalists_id = $("#journalists_id").val();
        $.ajax({
            type: "POST",
            url: chat_search_name,
            data: {name: name,message_id:message_id,journalists_id:journalists_id},
            dataType: "json",
            success: function( data ) {
                console.log(data);
                var rows = '';
                var colum = '';
                $.each( data, function( key, value ) {
                    rows = rows + '<a href="'+baseurl+'admin/chets/'+value.message_id+'11@@99'+value.journalists_id+'"> ';
                    rows = rows + '<li>';
                    rows = rows + '<span>'+value.first_name.slice(0,1).toUpperCase()+''+value.last_name.slice(0,1).toUpperCase()+'</span>';
                    rows = rows + value.first_name+' '+value.last_name;
                    if(value.chat_status != 0)
                    {
                        rows = rows + '<div class="unread_count">'+value.chat_status+'-new</div>';
                    }
                    rows = rows + '</li>';
                    rows = rows + '</a>';
                });

                $(".chet_list").html(rows);

                if(data == '')
                {
                 $(".chet_list").html('');
                }
            }});
       });
});


$(".all_jornalist_select").click(function () {

    if($(".all_jornalist_select").prop('checked') == true)
    {
        $('.select_delete').prop('checked', true);
    }
    else
    {
        $('.select_delete').prop('checked', false);
    }

});

$(".delete_selected_btn").click(function () {

    var r = confirm("you are sore all selected records deleted");
    if (r == true) 
    {
        var yourArray=[];
        $("input:checkbox[name=delete_journalist]:checked").each(function(){
            yourArray.push($(this).val());
            $(".row_del_id_"+ $(this).val()).hide();
        });

        $.ajax({
            type: "POST",
            url: JournaList_delete,
            data: {yourArray:yourArray},
            dataType: "json",
            success: function( data ) {
                console.log(data);
        }});
    }

});