<!DOCTYPE html>
<html>
<head>
    <title>BAST {{$data->nama_proyek}}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .borderless td, .borderless th {
            border: none;
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
    <h5 style="color: #0c525d;"><strong><u>BERITA ACARA SERAH TERIMA PEKERJAAN</u></strong></h5>
</center>
<br>
<p>
    Dengan Hormat,<br>
    Bersama surat ini kami memberikan berita acara serah terima pekerjaan sebagai berikut :
</p>
<table class="table borderless">
    <tr>
        <td width="5%"></td>
        <td width="20%">Kepada Yth </td>
        <td width="75%">: {{$data->pembayaran->pin->pengajuan->client->user->name}}</td>
    </tr>
    <tr>
        <td width="5%"></td>
        <td width="20%">Tanggal </td>
        <td width="75%">: {{indonesiaDate($data->updated_at, false)}}</td>
    </tr>
    <tr>
        <td width="5%"></td>
        <td width="20%">Perihal </td>
        <td width="75%">: Proyek {{$data->pembayaran->pin->pengajuan->nama_proyek}}</td>
    </tr>
</table>
<p>
    Menyatakan pekerjaan jasa / produk yang dikerjakan diterima dalam keadaan baik dan sesuai
    dengan permintaan.
</p>
<br>
<br>
<table class="table borderless">
    <tbody>
    <tr>
        <td width="50%">
            <p class="text-center">Penerima,</p>
        </td>
        <td width="50%">
            <p class="text-center">Hormat Kami,</p>
        </td>
    </tr>
    </tbody>
</table>
<br>
<br>
<br>
<table class="table borderless">
    <tbody>
    <tr>
        <td width="50%">
            <p class="text-center"><u>( {{$data->pembayaran->pin->pengajuan->client->user->name}} )</u></p>
        </td>
        <td width="50%">
            <p class="text-center"><u>( {{$data->pembayaran->pin->tukang->user->name}} )</u></p>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
