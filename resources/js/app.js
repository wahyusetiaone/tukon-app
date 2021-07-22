require('./bootstrap');
require('admin-lte');
require( '../../node_modules/datatables.net/js/jquery.dataTables.js' );
require( '../../node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js' );
import $ from 'jquery';
import daterangepicker from 'admin-lte/plugins/daterangepicker'
window.$ = window.jQuery = $;
$( document ).ready(function() {
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
});

var base_url = process.env.MIX_BASE_URL;

export { base_url };
