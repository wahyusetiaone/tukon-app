import Swal from "sweetalert2";
import {base_url} from "./app";

$(document).ready(function () {

    if (location.hash) {
        $('a[href=\'' + location.hash + '\']').tab('show');
    }
    var activeTab = localStorage.getItem('activeTab');
    if (activeTab) {
        $('a[href="' + activeTab + '"]').tab('show');
    }

    $('body').on('click', 'a[data-toggle=\'tab\']', function (e) {
        e.preventDefault()
        var tab_name = this.getAttribute('href')
        if (history.pushState) {
            history.pushState(null, null, tab_name)
        }
        else {
            location.hash = tab_name
        }
        localStorage.setItem('activeTab', tab_name)

        $(this).tab('show');
        return false;
    });
    $(window).on('popstate', function () {
        var anchor = location.hash ||
            $('a[data-toggle=\'tab\']').first().attr('href');
        $('a[href=\'' + anchor + '\']').tab('show');
    });

    $("#btnKonfirmasiSelesaiProyek").click(function () {
        var data = $(this);
        if (!data.hasClass("disabled")) {

            Swal.fire({
                icon: 'warning',
                text: 'Pastikan kamu telah mengecek keseluruhan projek, sesudah anda melakukan konfirmasi uang akan langsung di transfer ke rekening tukang dan aplikasi tidak lagi bertanggung jawab?',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya',
                confirmButtonColor: '#2196F3',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = base_url + "/client/project/approve/" + data.val();
                }
            });
        }
    });

    $('button[name="btnTerima"]').click(function () {
        var data = $(this);
        if (!data.hasClass("disabled")) {

            Swal.fire({
                icon: 'question',
                text: 'Apakah kamu akan menerima penarikan dana ke tukang ?',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Terima',
                confirmButtonColor: '#2196F3',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: base_url + "/client/penarikan-dana/terima/" + data.val(),
                        success: function(data){
                            console.log(data)
                            if (data.status){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil menyetujui penarikan dana Tukang.',
                                    text: data.data,
                                }).then((result)=>{
                                    location.reload(true);
                                })
                            }else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: data.data.error,
                                })
                            }
                        }
                    });
                }
            });
        }
    });

    $('button[name="btnTolak"]').click(function () {
        var data = $(this);
        if (!data.hasClass("disabled")) {

            Swal.fire({
                icon: 'warning',
                text: 'Apakah kamu akan menolak pencairan dana tukang ?',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Tolak',
                confirmButtonColor: '#2196F3',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: base_url + "/client/penarikan-dana/tolak/" + data.val(),
                        success: function(data){
                            console.log(data)
                            if (data.status){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil menolak penarikan dana Tukang.',
                                    text: data.data,
                                }).then((result) =>{
                                    location.reload(true);
                                })
                            }else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: data.data.error,
                                })
                            }
                        }
                    });                }
            });
        }
    });
});
