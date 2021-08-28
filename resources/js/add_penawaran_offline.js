import Swal from 'sweetalert2';
import {base_url} from "./app";

var index = 0;
var sum = 0;
var keuntungan = 0;
var listofcomponent = [];
var hargatotal = 0;
var tbl_komponen = document.getElementById("tbl_komponen");
var presentase = document.getElementById("keuntungan");
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
            '</div>'
            +
            '<div class="input-group mb-3">' +
            '<div class="input-group-prepend">' +
            '<span class="input-group-text"><i class="fas fa-dice-one"></i></span>' +
            '</div>' +
            '<input type="text" id="swal_merek_type_komponen" class="form-control" maxlength="20" placeholder="Merk/Type Komponen">' +
            '</div>'
            +
            '<div class="input-group mb-3">' +
            '<div class="input-group-prepend">' +
            '<span class="input-group-text"><i class="fas fa-dice-one"></i></span>' +
            '</div>' +
            '<input type="text" id="swal_spesifikasi_komponen" class="form-control" maxlength="50" placeholder="Spesifikasi Singkat Komponen">' +
            '</div>'
            +
            '<div class="input-group mb-3">' +
            '<div class="input-group-prepend">' +
            '<span class="input-group-text"><i class="fas fa-dice-one"></i></span>' +
            '</div>' +
            '<input type="text" id="swal_satuan_komponen" class="form-control" maxlength="10" placeholder="Satuan Komponen">' +
            '</div>'
            +
            '<div class="input-group mb-3">' +
            '<div class="input-group-prepend">' +
            '<span class="input-group-text"><i class="fas fa-dice-one"></i></span>' +
            '</div>' +
            '<input type="number" id="swal_total_unit_komponen" class="form-control" placeholder="Total Unit Komponen">' +
            '</div>'
            +
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
                document.getElementById('swal_harga_komponen').value,
                document.getElementById('swal_merek_type_komponen').value,
                document.getElementById('swal_spesifikasi_komponen').value,
                document.getElementById('swal_satuan_komponen').value,
                document.getElementById('swal_total_unit_komponen').value,
                index,
                null
            ];
        }
    }).then((result) => {
        if (result.isConfirmed) {
            var rows = tbl_komponen.tBodies[0].rows.length;
            var row = tbl_komponen.insertRow(rows);
            row.id = 'tbl_komponent_row_' + index;
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);
            var cell6 = row.insertCell(5);
            console.log(listofcomponent[index]);
            cell1.innerHTML = listofcomponent[index][0];
            cell2.innerHTML = listofcomponent[index][2];
            cell3.innerHTML = listofcomponent[index][3];
            cell4.innerHTML = listofcomponent[index][5] + " (" + listofcomponent[index][4] + ")";
            cell5.innerHTML = listofcomponent[index][1];
            cell6.innerHTML = '<div class="btn-group btn-group-sm">\n' +
                '                                        <button id="btn_del_com" value="' + index + '" class="btn btn-danger"><i class="fas fa-trash"></i></button>\n' +
                '                                    </div>';
            index++;
            sum = 0;
            listofcomponent.forEach(function myFunction(item) {
                sum += parseInt(item[1]);
            });
            h_total_c.value = sum;
            keuntungan = (sum * parseInt(presentase.value)) / 100;
            h_keuntungan.value = keuntungan;
            h_total.value = sum + keuntungan;
        }
    });
    return false;
});

// $(document).on('click', '[id^=btn_del_com]', function () {
//     var data = $(this);
//     Swal.fire({
//         icon: 'warning',
//         text: 'Apa kamu yakin akan menghapus komponen ini?',
//         showCancelButton: true,
//         confirmButtonText: 'Hapus',
//         confirmButtonColor: '#F44336',
//     }).then((result) => {
//         if (result.isConfirmed) {
//             var pos = parseInt(data.val());
//             listofcomponent.splice(pos, 1);
//             var rowid = 'tbl_komponent_row_' + pos;
//             var row = document.getElementById(rowid);
//             row.parentNode.removeChild(row);
//
//             sum = 0;
//             listofcomponent.forEach(function myFunction(item) {
//                 sum += item[1];
//             });
//             h_total_c.value = sum;
//             keuntungan = (sum * parseInt(presentase.value)) / 100;
//             h_keuntungan.value = keuntungan;
//             h_total.value = sum + keuntungan;
//         }
//     });
//     return false;
// });

$(document).ready(function () {
    $('#inputPresentase').on('change', function () {
        sum = parseInt(h_total_c.value);
        keuntungan = (sum * parseInt(presentase.value)) / 100;
        h_keuntungan.value = keuntungan;
        h_total.value = sum + keuntungan;
    }).change();
});

$(document).on('click', '[id^=btnsubmitpenawaran]', function () {
    var data = $(this);
    Swal.fire({
        icon: 'question',
        text: 'Apa kamu yakin akan menambahkan data penawaran offline ini?',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        confirmButtonColor: '#2196F3',
    }).then((result) => {
        if (result.isConfirmed) {
            listofcomponent.forEach((entry) => {
                $('<input>').attr({
                    type: 'hidden',
                    name: 'nama_komponen[]',
                    value: entry[0]
                }).appendTo('form');
                $('<input>').attr({
                    type: 'hidden',
                    name: 'harga_komponen[]',
                    value: entry[1]
                }).appendTo('form');
                $('<input>').attr({
                    type: 'hidden',
                    name: 'merk_type_komponen[]',
                    value: entry[2]
                }).appendTo('form');
                $('<input>').attr({
                    type: 'hidden',
                    name: 'spesifikasi_komponen[]',
                    value: entry[3]
                }).appendTo('form');
                $('<input>').attr({
                    type: 'hidden',
                    name: 'satuan[]',
                    value: entry[4]
                }).appendTo('form');
                $('<input>').attr({
                    type: 'hidden',
                    name: 'total_unit[]',
                    value: entry[5]
                }).appendTo('form');

                //hargatotal
                sum = 0;
                listofcomponent.forEach(function myFunction(item) {
                    sum += item[1];
                });
                $('<input>').attr({
                    type: 'hidden',
                    name: 'harga_total',
                    value: h_keuntungan.value
                }).appendTo('form');
            })

            $('form#formaddpenawaranoffline').submit();

        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Mohon untuk minimal memasukan 1 Komponen !'
            })
        }
    });
    return false;
});
