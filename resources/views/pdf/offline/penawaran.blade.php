<!DOCTYPE html>
<html>
<head>
    <title>Penawaran {{$data->nama_proyek}}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .borderless td, .borderless th {
            border: none;
        }
        .table {
            font-size: 18px;
        }

        .table tr,.table td {
            height: 18px;
        }

        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th
        {
            padding:2px;
        }
        body{
            margin: 0;
            padding: 0;
        }

        #watermark {
            position: fixed;

            /** Change image dimensions**/
            width: 18.8cm;
            height: 27.2cm;

            /** Your watermark should be behind every content**/
            z-index: -1000;
            /* opacity: 0.9; */
        }

        /* Create two equal columns that floats next to each other */
        .column {
            float: left;
            width: 50%;
            padding: 10px;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
<div id="watermark" class="">
    <img src="{{asset('images/bg_img.png')}}" height="100%" width="100%"/>
</div>
<div class="row">
    <div class="column" style="width: 15%;">
        <img height="55px" width="101px" style="padding-top: 18px;" src="{{asset('/images/tukon_icon.png')}}">
    </div>
    <div class="column" style="width: 85%;">
        <p style="background-color: #000; color: #fff; margin-right: 40px; padding: 2px; margin-bottom: 2px">
            <small>
                Office : Komplek Pertokoan Universitas Muhammadiyah Surakarta Blok H No 1 <br>
                ( Komp Fakultas Farmasi UMS )
            </small>
        </p>
        <p style="background-color: #0c84ff; margin-right: 40px; padding: 2px;">
            <small>
                Website : https ://tukon.com/
            </small>
        </p>
    </div>
</div>
<center>
    <br>
    <br>
    <h5 style="color: #0c525d;"><strong><u>PENAWARAN</u></strong></h5>
    <div class="float-right ">{{indonesiaDate($data->created_at)}}</div>
    <br>
</center>
<p>
    Kepada Yth :<br>
    <b>{{$data->nama_client}}</b><br>
    Di Tempat<br>
    Perihal : {{$data->nama_proyek}}
</p>
<p>
    Dengan Hormat,<br>
    Bersama surat ini kami mengajukan penawaran kerjasama dalam proyek {{$data->nama_proyek}} dengan RAB
    sebagai berikut :
</p>
<table class="table">
    {{$nomor = 1 }}
    {{$tt = 0 }}
    <thead class="thead-dark">
    <tr>
        <th scope="col"><small>No</small></th>
        <th scope="col"><small>Nama Item</small></th>
        <th scope="col"><small>Spesifikasi</small></th>
        <th scope="col"><small>Satuan</small></th>
        <th scope="col"><small>Total Unit</small></th>
        <th scope="col"><small>Harga Peritem</small></th>
        <th scope="col"><small>Total</small></th>
    </tr>
    </thead>
    <tbody>
    @foreach($data->komponen as $item)
        <tr>
            <th scope="row"><small>{{$nomor}}</small></th>
            <td><small>{{$item->nama_komponen}}</small></td>
            <td><small>{{$item->spesifikasi_teknis}}</small></td>
            <td><small>{{$item->satuan}}</small></td>
            <td><small>{{$item->total_unit}}</small></td>
            <td><small>{{indonesiaRupiah(($item->harga/$item->total_unit))}}</small></td>
            <td><small>{{indonesiaRupiah($item->harga)}}</small></td>
        </tr>
        {{$nomor +=1}}
        {{$tt += $item->harga}}
    @endforeach
    <tr class="table">
        <th scope="col" colspan="6"><small class="float-right"><strong>Total</strong></small></th>
        <td><small>{{indonesiaRupiah($tt)}}</small></td>
    </tr>
    <tr class="table borderless">
        <th scope="col" colspan="6"><small class="float-right"><strong>Jasa</strong></small></th>
        <td><small>{{indonesiaRupiah(($tt*$data->keuntungan)/100)}}</small></td>
    </tr>
    <tr class="table borderless">
        <th scope="col" colspan="6"><small class="float-right"><strong>Total Harga</strong></small></th>
        <td><small>{{indonesiaRupiah($data->harga_total)}}</small></td>
    </tr>
    </tbody>
</table>
<p>Note :<br>
    - Harga belum termasuk PPN 10%,pajak reklame,perijinan<br>
    - Sistem pembayaran DP 50% ,pelunasan 50% setelah selesai pemasangan</p>
<p>Demikian surat penawaran ini kami ajukan, terima kasih.</p>
<p>Hormat Kami,</p>
<img width="100px" height="80px" src="{{asset('/images/ttd01.jpg')}}">
<p><u>Wendi Ardiawan Happy</u></p>
</body>
</html>
