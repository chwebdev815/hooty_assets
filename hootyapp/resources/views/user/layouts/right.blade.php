<aside class="aside-menu">
    <!-- Tab panes-->
    <div class="tab-content msgBar">
    </div>
</aside>
<script src="{{asset('assets/js/jquery-dateformat.min.js')}}"></script>

<script>
    $.ajax({
        url: '/side-bar',
        success: function(result) {
            var msgs = JSON.parse(result);
            var html = "";
            console.log(msgs);
            if(msgs && msgs.length > 0) {
                msgs.forEach(function(msg) {
                    html += `<a style="text-decoration: none;" href="/message/chatrooms/`+msg.message_id+`"> <div class="message pl-3"><div> <small class="text-muted">` + msg.First_name + `</small> <small class="text-muted float-right mt-1">` + jQuery.format.prettyDate(msg.created_at + 'Z') + `</small> </div><div class="text-truncate font-weight-bold">` + msg.title + `</div> <small class="text-muted">` + msg.message + `</small> </div></a> <hr>`
                });
                $('.message-count').html(msgs.length).removeClass('d-none');
            } else {
                html += ` <div class="message pt-4"><div class="text-center text-muted h2"> ` + "No Messages" + ` </div></div> `
            }
            $('.msgBar').html(html);
        }
    });
</script>