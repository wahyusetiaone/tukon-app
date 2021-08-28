import Swal from 'sweetalert2';
$(document).on('click', '[id^=btn-sub]', function (e) {
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
            $('#form-edit-produk').submit();
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
