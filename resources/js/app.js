require('./bootstrap');
require('admin-lte');
require( '../../node_modules/datatables.net/js/jquery.dataTables.js' );
require( '../../node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js' );
require('jquery-mask-plugin');

import $ from 'jquery';
import Swal from "sweetalert2";

window.AdminLte = require('admin-lte');
window.$ = window.jQuery = $;

var base_url = process.env.MIX_BASE_URL;
$(document ).ready(function() {
    var hidden_tk = $("#hidden_tk");
    var hidden_cl = $("#hidden_cl");
    $('select').on('change', function() {
        console.log(this.value);
        if (this.value === '1'){
            hidden_tk.hide();
            hidden_cl.hide();
        } else if (this.value === '2'){
            hidden_cl.hide();
            hidden_tk.show();
        } else if (this.value === '3'){
            hidden_tk.hide();
            hidden_cl.show();
        }
    });

    var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
    if (isMobile) {
        if(localStorage.getItem('popState') != 'shown'){
            Swal.fire({
                showCloseButton: true,
                showConfirmButton: false,
                width: '700px',
                html: '<iframe width="100%" height="700px" src="'+base_url+'/forbiden-mobile-view" frameborder="0"></iframe>'
            });
            localStorage.setItem('popState','shown')
        }
    }
    $( '.rupiah' ).mask('0.000.000.000', {reverse: true});
    $('form').on('submit', function(){
        $('.rupiah').unmask();
    });
});

export { base_url };

