import {base_url} from './base_url.js'

$(document).ready(function () {

    $('#provinsi_t').on('change', function (e) {
        var valueSelected = this.value;
        if (valueSelected == 'all') {
            $('#kota').prop('disabled', true);
        } else {
            funCallKOta(valueSelected,'', true);
            $('#provinsi').val($("#provinsi_t option:selected").html())
        }
    });

    function funCallKOta(valueSelected, kota, hasnokota) {
        $('#kota').empty();
        $('#kota').append('<option>Memuat Daftar Kota</option>')
        if (hasnokota){
            $.ajax({
                url: base_url+ '/get/kota/' + valueSelected,
                type: "GET",
                crossDomain: true,
                dataType: 'json',
                success: function (data) {
                    $('#kota').empty();
                    data.kota_kabupaten.forEach(function (item, index) {
                        $('#kota').append('<option value="' + item.nama + '">' + item.nama + '</option>')
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
                    $('#kota').empty();
                    data.kota_kabupaten.forEach(function (item, index) {
                        var active = '';
                        if(kota === item.nama){
                            active = 'selected';
                        }
                        $('#kota').append('<option '+active+' value="' + item.nama + '">' + item.nama + '</option>')
                    });
                },
                error: function (error) {
                    console.log("Error:");
                    console.log(error);
                }
            });
        }
        $('#kota').prop('disabled', false);
    }

    $('#t_image').change(function(){
        $('#preview').attr('src', window.URL.createObjectURL(this.files[0]));
    });
});
