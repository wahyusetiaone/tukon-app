import Swal from 'sweetalert2';
import {base_url} from "./app";

var index = 0;
var sum = 0;
var keuntungan = 0;
var listofcomponent = [];
var harga = document.getElementById("harga");
var presentase = document.getElementById("inputPresentase");
var h_keuntungan = document.getElementById("inputKeuntungan");
var h_keuntunganPersen = document.getElementById("inputKeuntunganPersen");
var h_bpa = document.getElementById("bpa");
var h_total = document.getElementById("inputHargaTotal");

$(document).ready(function () {
    h_keuntunganPersen.value = parseInt(presentase.value)+parseInt(h_bpa.value);
    keuntungan = (parseInt(harga.value) * parseInt(h_keuntunganPersen.value)) / 100;
    h_keuntungan.value = keuntungan;
    h_total.value = parseInt(harga.value) + keuntungan;

    $('#inputPresentase').on('change', function () {
        h_keuntunganPersen.value = parseInt(presentase.value)+parseInt(h_bpa.value);
        keuntungan = (parseInt(harga.value) * parseInt(h_keuntunganPersen.value)) / 100;
        h_keuntungan.value = keuntungan;
        h_total.value = parseInt(harga.value) + keuntungan;
    }).change();
    $('#harga').on('change', function () {
        h_keuntunganPersen.value = parseInt(presentase.value)+parseInt(h_bpa.value);
        keuntungan = (parseInt(this.value) * parseInt(h_keuntunganPersen.value)) / 100;
        h_keuntungan.value = keuntungan;
        h_total.value = parseInt(this.value) + keuntungan;
    }).change();
});

$(document).on('click', '[id^=btnsubmitpenawaran]', function () {
    var data = $(this);
    Swal.fire({
        icon: 'question',
        text: 'Apa kamu yakin akan mengupload ulang penawaran ini?',
        showCancelButton: true,
        confirmButtonText: 'Kirim',
        confirmButtonColor: '#2196F3',
    }).then((result) => {
        if (result.isConfirmed) {
            $('#fm-penawaran-edit').submit();
        }
    });
    return false;
});
