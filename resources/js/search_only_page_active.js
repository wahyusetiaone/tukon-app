import {base_url} from './app.js'

$(document).ready(function () {

    var url = window.location.href;
    var pathname = new URL(url).pathname;
    var partsOfStr = pathname.split('/');

    let searchParams = new URLSearchParams(window.location.search)

    $('#filter_search').val(partsOfStr[2])
    $("#search_input").val(partsOfStr[3])
    $('#b_query_search').append(partsOfStr[3])

    if (searchParams.has('prov')) {
        if (searchParams.has('kota')) {
            let prov = searchParams.get('prov')
            let kota = searchParams.get('kota')
            $('#inProv').val(prov);
            funCallKOta(prov,kota,false);
            $('#inKota').val(kota);
            $('#b_filter').append(kota)
        } else {
            $('#b_filter').append('Semua Kota')
        }
    } else {
        $('#b_filter').append('Semua Kota')
    }

    $('#inProv').on('change', function (e) {
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
        if (valueSelected == 'all') {
            $('#inKota').prop('disabled', true);
        } else {
            funCallKOta(valueSelected,'', true);
        }
    });

    $('#inKota').on('change', function (e) {
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
    });

    $("#btnGass").click(function () {
        if($("#inKota").is(":disabled")){
            window.location = base_url+'/search/'+$('#filter_search').val()+'/'+$('#search_input').val();
        }else{
            window.location = base_url+
                '/search/'+$('#filter_search').val()+
                '/'+$('#search_input').val()+'?prov='+
                $('#inProv').val()+'&kota='+$('#inKota').val();
        }
    });

    function funCallKOta(valueSelected, kota, hasnokota) {
        $('#inKota').empty();
        if (hasnokota){
            $.ajax({
                url: base_url+ '/get/kota/' + valueSelected,
                type: "GET",
                crossDomain: true,
                dataType: 'json',
                success: function (data) {
                    // console.log(data.kota_kabupaten);
                    data.kota_kabupaten.forEach(function (item, index) {
                        $('#inKota').append('<option value="' + item.nama + '">' + item.nama + '</option>')
                    });
                },
                error: function (error) {
                    console.log("Error:");
                    console.log(error);
                }
            });
        }else {
            $.ajax({
                url: base_url+ '/get/kota/' + valueSelected,
                type: "GET",
                crossDomain: true,
                dataType: 'json',
                success: function (data) {
                    // console.log(data.kota_kabupaten);
                    data.kota_kabupaten.forEach(function (item, index) {
                        var active = '';
                        if(kota === item.nama){
                            active = 'selected';
                        }
                        $('#inKota').append('<option '+active+' value="' + item.nama + '">' + item.nama + '</option>')
                    });
                },
                error: function (error) {
                    console.log("Error:");
                    console.log(error);
                }
            });
        }
        $('#inKota').prop('disabled', false);
    }
});
