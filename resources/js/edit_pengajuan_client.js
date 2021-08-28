import Swal from 'sweetalert2';
import {base_url} from "./app";
$(document).on('click', '[id^=btn_submit_pengajuan]', function (e) {
    e.preventDefault();
    var data = $(this).serialize();
    Swal.fire({
        icon: 'question',
        text: 'Do you want to update this?',
        showCancelButton: true,
        confirmButtonText: 'Update',
        confirmButtonColor: '#2196F3',
    }).then((result) => {
        if (result.isConfirmed) {
            $('#form-edit-pengajuan').submit();
        }
    });
    return false;
});

$(document).on('click', '[id^=btn_hps_pengajuan]', function (e) {
    e.preventDefault();
    var id = $(this).val();
    Swal.fire({
        icon: 'warning',
        text: 'Apa kamu yakin akan menghapus pengajuan ini ?',
        showCancelButton: true,
        confirmButtonText: 'Hapus',
        confirmButtonColor: '#F44336',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: base_url+"/client/pengajuan/check-safe-args/"+id,
                type: "get",
                dataType: "json",
                success: function(data){
                    if (data.data){
                        Swal.fire({
                            icon: 'warning',
                            text: 'Pengajuan ini sudah ada penawaran yang masuk, tetap ingin menghapus ?',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Hapus',
                            confirmButtonColor: '#F44336',
                        }).then((result) => {
                            $.ajax({
                                url: base_url+"/client/pengajuan/delete/"+id,
                                type: "get",
                                dataType: "json",
                                success: function(data){
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Successfully',
                                        text: 'Berhasil menghapus pengajuan',
                                    })
                                    window.location.href = base_url+"/client/pengajuan";
                                }
                            });
                        });
                    }else {
                        $.ajax({
                            url: base_url+"/client/pengajuan/delete/"+id,
                            type: "get",
                            dataType: "json",
                            success: function(data){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Successfully',
                                    text: 'Berhasil menghapus pengajuan',
                                })
                                window.location.href = base_url+"/client/pengajuan";
                            }
                        });
                    }
                }
            });
        }
    });
    return false;
});

$(document).ready(function(){
    $('img[name="thumnailImg"]').click(function(){
        var src = $(this).attr('src');
        $("#targetImg").attr("src",src);
    });
});

$(document).ready(function(){
    $('a[name="removeImg"]').click(function(){
        var src = $('#targetImg').attr('src');
        $('input[name="urlImg"]').val(src);
        Swal.fire({
            icon: 'question',
            text: 'Do you want to remove this?',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            confirmButtonColor: '#F44336',
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-rm-img').submit();
            }
        });
    });
});

$(document).ready(function(){
    $('#path_show').on('change', function(){
        $('#form-add-img').submit();

    });
});
