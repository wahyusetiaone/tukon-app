import Swal from 'sweetalert2';
import {base_url} from "./app";

var index = 0;
var sum = 0;
var keuntungan = 0;
var listofcomponent = [];
var tbl_komponen = document.getElementById("tbl_komponen");
var presentase = document.getElementById("inputPresentase");
var h_total_c = document.getElementById("inputTotalHargaKomponen");
var h_keuntungan = document.getElementById("inputKeuntungan");
var h_total = document.getElementById("inputHargaTotal");
$(document).on('click', '[id^=btn-tbh-componen]', function (e) {
    e.preventDefault();
    Swal.fire({
        title: 'Tambah Komponen',
        html:
            '<div class="input-group mb-3">' +
            '<div class="input-group-prepend">' +
            '<span class="input-group-text"><i class="fas fa-tools"></i></span>' +
            '</div>' +
            '<input type="text" id="swal_nama_komponen" class="form-control" placeholder="Nama Komponen">' +
            '</div>' +
            '<div class="input-group mb-3">' +
            '<div class="input-group-prepend">' +
            '<span class="input-group-text"><i class="fas fa-dice-one"></i></span>' +
            '</div>' +
            '<input type="number" id="swal_harga_komponen" class="form-control" placeholder="Harga Komponen">' +
            '</div>'
        ,
        focusConfirm: false,
        showCancelButton: true,
        preConfirm: () => {
            listofcomponent[index] = [
                document.getElementById('swal_nama_komponen').value,
                document.getElementById('swal_harga_komponen').value
            ];
        }
    }).then((result) => {
        if (result.isConfirmed) {
            var rows = tbl_komponen.tBodies[0].rows.length;
            var row = tbl_komponen.insertRow(rows);
            row.id = 'tbl_komponent_row_'+index;
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            cell1.innerHTML = listofcomponent[index][0];
            cell2.innerHTML = listofcomponent[index][1];
            cell3.innerHTML = '<div class="btn-group btn-group-sm">\n' +
                '                                        <button id="btn_del_com" value="' + index + '" class="btn btn-danger"><i class="fas fa-trash"></i></button>\n' +
                '                                    </div>';
            index++;
            sum = 0;
            listofcomponent.forEach(function myFunction(item) {
                sum += parseInt(item[1]);
            });
            h_total_c.value = sum;
            keuntungan = (sum*parseInt(presentase.value))/100;
            h_keuntungan.value = keuntungan;
            h_total.value =  sum + keuntungan;
        }
    });
    return false;
});

$(document).on('click', '[id^=btn_del_com]', function () {
    var data = $(this);
    Swal.fire({
        icon: 'warning',
        text: 'Apa kamu yakin akan menghapus komponen ini?',
        showCancelButton: true,
        confirmButtonText: 'Hapus',
        confirmButtonColor: '#F44336',
    }).then((result) => {
        if (result.isConfirmed) {
            var pos = parseInt(data.val());
            listofcomponent.splice(pos, 1);
            var rowid = 'tbl_komponent_row_'+pos;
            var row = document.getElementById(rowid);
            row.parentNode.removeChild(row);

            sum = 0;
            listofcomponent.forEach(function myFunction(item) {
                sum += item[1];
            });
            h_total_c.value = sum;
            keuntungan = (sum*parseInt(presentase.value))/100;
            h_keuntungan.value = keuntungan;
            h_total.value =  sum + keuntungan;
        }
    });
    return false;
});

$(document).ready(function(){
    $('#inputPresentase').on('change',function(){
        sum = parseInt(h_total_c.value);
        keuntungan = (sum*parseInt(presentase.value))/100;
        h_keuntungan.value = keuntungan;
        h_total.value =  sum + keuntungan;
    }).change();
});
