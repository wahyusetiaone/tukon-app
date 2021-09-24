import { base_url } from './base_url.js'

$(document).ready(function () {
    $("#search_input").keypress(function(event) {
        if (event.keyCode === 13) {
            if ($(this).val() !== ""){
                window.location = base_url+"/search/"+$('#filter_search').val()+"/"+$(this).val();
            }
        }
    });
    $('#btn-search').click(function (){
        window.location = base_url+"/search/"+$('#filter_search').val()+"/"+$('#search_input').val();
    });

    $("#send_pengajuan").click(function () {
        var data = $(this);
        window.location = "/client/pengajuan/form/"+data.val();
    });
});
