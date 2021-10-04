import Swal from 'sweetalert2';
import {base_url} from "./app";

var index = 0;
var sum = 0;
var keuntungan = 0;
var listofcomponent = [];
var masterlistofcomponent = [];
var tbl_komponen = document.getElementById("tbl_komponen");
var presentase = document.getElementById("inputPresentase");
var h_total_c = document.getElementById("inputTotalHargaKomponen");
var h_keuntungan = document.getElementById("inputKeuntungan");
var h_keuntunganPersen = document.getElementById("inputKeuntunganPersen");
var h_bpa = document.getElementById("bpa");
var h_old_bpa = document.getElementById("old_bpa");
var h_total = document.getElementById("inputHargaTotal");
var addList = [];
var removeList = [];
var dump_add = [];
var dump_remove = [];

tmp.forEach((entry) => {
    listofcomponent[index] = [
        entry.nama_komponen,
        entry.harga,
        entry.merk_type,
        entry.spesifikasi_teknis,
        entry.satuan,
        entry.total_unit,
        index,
        entry.id
    ];
    masterlistofcomponent[index] = [
        entry.nama_komponen,
        entry.harga,
        entry.merk_type,
        entry.spesifikasi_teknis,
        entry.satuan,
        entry.total_unit,
        index,
        entry.id
    ];
    var rows = tbl_komponen.tBodies[0].rows.length;
    var row = tbl_komponen.insertRow(rows);
    row.id = 'tbl_komponent_row_' + index;
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    var cell6 = row.insertCell(5);
    var cell7 = row.insertCell(6);
    cell1.innerHTML = listofcomponent[index][0];
    cell2.innerHTML = listofcomponent[index][5];
    cell3.innerHTML = listofcomponent[index][2];
    cell4.innerHTML = listofcomponent[index][3];
    cell5.innerHTML = listofcomponent[index][4];
    cell6.innerHTML = listofcomponent[index][1];
    cell7.innerHTML = '<div class="btn-group btn-group-sm">\n' +
        '                                        <button id="btn_del_com" value="' + index + '" class="btn btn-danger"><i class="fas fa-trash"></i></button>\n' +
        '                                    </div>';
    index++;
});

sum = 0;
listofcomponent.forEach(function myFunction(item) {
    sum += parseInt(item[1]);
});
h_total_c.value = sum;
h_keuntunganPersen.value = parseInt(presentase.value) +parseInt(h_bpa.value);
keuntungan = (sum * parseInt(h_keuntunganPersen.value)) / 100;
h_keuntungan.value = keuntungan;
h_total.value = sum + keuntungan;

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
            var cell7 = row.insertCell(6);
            cell1.innerHTML = listofcomponent[index][0];
            cell2.innerHTML = listofcomponent[index][5];
            cell3.innerHTML = listofcomponent[index][2];
            cell4.innerHTML = listofcomponent[index][3];
            cell5.innerHTML = listofcomponent[index][4];
            cell6.innerHTML = listofcomponent[index][1];
            cell7.innerHTML = '<div class="btn-group btn-group-sm">\n' +
                '                                        <button id="btn_del_com" value="' + index + '" class="btn btn-danger"><i class="fas fa-trash"></i></button>\n' +
                '                                    </div>';
            index++;
            sum = 0;
            listofcomponent.forEach(function myFunction(item) {
                sum += parseInt(item[1]);
            });
            h_total_c.value = sum;
            keuntungan = (sum * parseInt(h_keuntunganPersen.value)) / 100;
            h_keuntungan.value = keuntungan;
            h_total.value = sum + keuntungan;
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
            var rowid = 'tbl_komponent_row_' + pos;
            var row = document.getElementById(rowid);
            row.parentNode.removeChild(row);

            sum = 0;
            listofcomponent.forEach(function myFunction(item) {
                sum += item[1];
            });
            h_total_c.value = sum;
            keuntungan = (sum * parseInt(presentase.value)) / 100;
            h_keuntungan.value = keuntungan;
            h_total.value = sum + keuntungan;
        }
    });
    return false;
});

$(document).ready(function () {
    $('#inputPresentase').on('change', function () {
        sum = parseInt(h_total_c.value);
        h_keuntunganPersen.value = parseInt(presentase.value) + parseInt(h_bpa.value);
        keuntungan = (sum * parseInt(h_keuntunganPersen.value)) / 100;
        h_keuntungan.value = keuntungan;
        h_total.value = sum + keuntungan;
    }).change();
});

$(document).on('click', '[id^=btnsubmitpenawaran]', function () {
    var data = $(this);
    Swal.fire({
        icon: 'question',
        text: 'Apa kamu yakin akan mengirim penawaran ini?',
        showCancelButton: true,
        confirmButtonText: 'Kirim',
        confirmButtonColor: '#2196F3',
    }).then((result) => {
        if (result.isConfirmed) {

            console.log(masterlistofcomponent);
            console.log(listofcomponent);
            $.each(masterlistofcomponent, function (old_index, old_obj) {
                var old_id = old_obj[7];
                var found = false;
                $.each(listofcomponent, function (new_index, new_obj) {
                    var type = typeof new_obj;
                    if (type !== 'undefined') {
                        if (new_obj[7] === old_id) {
                            found = true;
                        }
                    }
                });
                if (!found) {
                    removeList.push(old_obj);
                }
            });
            $.each(listofcomponent, function (old_index, old_obj) {
                var type = typeof old_obj;
                if (type !== 'undefined') {
                    var old_id = old_obj[7];
                    var found = false;
                    $.each(masterlistofcomponent, function (new_index, new_obj) {
                        if (new_obj[7] === old_id) {
                            found = true;
                        }
                    });
                    if (!found) {
                        addList.push(old_obj);
                    }
                }
            });

            console.log(addList);
            console.log(removeList);
            if (listofcomponent.length !== 0) {
                addList.forEach(function myFunction(item) {
                    dump_add.push({
                        'nama_komponen': item[0],
                        'harga_komponen' : item[1],
                        'merk_type' : item[2],
                        'spesifikasi_teknis' : item[3],
                        'satuan' : item[4],
                        'total_unit' : item[5],
                    });
                });
                removeList.forEach(function myFunction(item) {
                    dump_remove.push({
                        'nama_komponen': item[0],
                        'harga_komponen' : item[1],
                        'merk_type' : item[2],
                        'spesifikasi_teknis' : item[3],
                        'satuan' : item[4],
                        'total_unit' : item[5],
                        'id' : item[7]
                    });
                });
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: base_url + '/penawaran/update/'+data.val(),
                type: "post",
                data: {
                    'kode_spd' : parseInt($("input[name='kode_spd']:checked").val()),
                    'keuntungan': parseInt(h_keuntunganPersen.value),
                    'harga_total': parseInt(h_total.value),
                    'dump_add': dump_add,
                    'dump_remove': dump_remove
                },
                success: function (response) {
                    if (response) {
                        console.log(response)
                        Swal.fire({
                            icon: 'success',
                            title: 'Revisi Penawaran telah diajukan !!!',
                            showConfirmButton: false,
                            timer: 1500
                        }).then((res) => {
                            window.location = base_url+'/penawaran/show/'+data.val()
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Mohon untuk minimal memasukan 1 Komponen !'
                })
            }
        }
    });
    return false;
});
