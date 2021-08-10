import { base_url } from './app.js'

$(document).ready(function () {
    $("#search_input").keypress(function(event) {
        if (event.keyCode === 13) {
            if ($(this).val() !== ""){
                window.location = base_url+"/search/"+$('#filter_search').val()+"/"+$(this).val();
            }
        }
    });

    $("#send_pengajuan").click(function () {
        var data = $(this);
        window.location = "/client/pengajuan/form/"+data.val();
    });
});
