import {base_url} from './base_url.js'
import Swal from 'sweetalert2';

$(document).ready(function () {
    //Bootstrap Duallistbox
    var duallistbox = $('#duallistbox');
    duallistbox.bootstrapDualListbox()
    var provinsi = $('#provinsi_t');
    provinsi.on('change', function (e) {
        var valueSelected = this.value;
        funCallKOta(valueSelected, '', true);
        $('#provinsi').val($("#provinsi_t option:selected").html())
    });

    function funCallKOta(valueSelected, kota, hasnokota) {
        duallistbox.empty();
        if (hasnokota) {
            $.ajax({
                url: base_url + '/get/kota/' + valueSelected,
                type: "GET",
                crossDomain: true,
                dataType: 'json',
                success: function (data) {
                    duallistbox.empty();
                    data.kota_kabupaten.forEach(function (item, index) {
                        duallistbox.append('<option value="' + item.nama + '">' + item.nama + '</option>')
                    });

                    duallistbox.bootstrapDualListbox('refresh', true);
                },
                error: function (error) {
                    console.log("Error:");
                    console.log(error);
                }
            });
        } else {
            $.ajax({
                url: base_url + '/get/kota/' + valueSelected,
                type: "GET",
                crossDomain: true,
                dataType: 'json',
                success: function (data) {
                    duallistbox.empty();
                    data.kota_kabupaten.forEach(function (item, index) {
                        var active = '';
                        if (kota === item.nama) {
                            active = 'selected';
                        }
                        duallistbox.append('<option ' + active + ' value="' + item.nama + '">' + item.nama + '</option>')
                    });

                    duallistbox.bootstrapDualListbox('refresh', true);
                },
                error: function (error) {
                    console.log("Error:");
                    console.log(error);
                }
            });
        }
    }
});
$(document).on('click', '[id^=btn-save]', function (e) {
    var count = $("#duallistbox :selected").length;

    Swal.fire({
        icon: 'question',
        text: 'Apakah kamu yakin ingin menambahkan Admin Cabang?',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        confirmButtonColor: '#2196F3',
    }).then((result) => {
        if (result.isConfirmed) {
            if (count === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Mohon untuk minimal memasukan 1 Cabang !'
                })
            } else {
                $('#fm-add-admincabang').submit();
            }
        }
    });
    return false;
});
