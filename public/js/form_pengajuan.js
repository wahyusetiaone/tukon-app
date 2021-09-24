/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************!*\
  !*** ./resources/js/form_pengajuan.js ***!
  \****************************************/
$('#path_add').change(function () {
  var files = $(this)[0].files;
  $('#count_file').text(files.length + ' Gambar terpilih.');
});
$('#path_berkas').change(function () {
  var files = $(this)[0].files;
  $('#count_berkas').text(files.length + ' File terpilih.');
});
/******/ })()
;