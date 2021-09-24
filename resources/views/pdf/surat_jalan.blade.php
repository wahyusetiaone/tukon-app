<!DOCTYPE html>
<html>
<head>
    <title>Surat Jalan {{$data->pembayaran->pin->pengajuan->nama_proyek}}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .borderless td, .borderless th {
            border: none;
        }

        .table {
            font-size: 18px;
        }

        .table tr, .table td {
            height: 18px;
        }

        .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
            padding: 2px;
        }

        body {
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
        <p style="background-color: #78909C; color: #fff; margin-right: 40px; padding: 2px; padding-left: 5px; margin-bottom: 2px">
            <small>
                Office : Komplek Pertokoan Universitas Muhammadiyah Surakarta Blok H No 1 <br>
                ( Komp Fakultas Farmasi UMS )
            </small>
        </p>
        <p style="background-color: #00B0FF; margin-right: 40px; padding: 2px; padding-left: 5px; padding-bottom: 2px;">
            <small>
                Website : https ://tukon.com/
            </small>
        </p>
    </div>
</div>
<center>
    <br>
    <br>
    <h5 style="color: #0c525d;" class="pb-0 mb-0"><strong><u>SURAT JALAN</u></strong></h5>
    <p style="color: #0c525d;" class="pt-0 mt-0">Nomor : B.005/MM/PTRM/2021</p>
    <div class="float-right">{{$data->pembayaran->pin->tukang->kota}}, {{indonesiaDate($data->created_at, false)}}</div>
    <br>
</center>
<p>
    Kepada Yth :<br>
    <b>{{$data->pembayaran->pin->pengajuan->client->user->name}}</b><br>
    Di Tempat<br>
</p>
<p>
    Dengan Hormat,<br>
    Bersama surat ini kami mengirimkan barang - barang pesanan saudara dari
    proyek <b>{{$data->pembayaran->pin->pengajuan->nama_proyek}}</b> dengan rincian
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
        <th scope="col"><small>Pengecekan</small></th>
    </tr>
    </thead>
    <tbody>
    @foreach($data->pembayaran->pin->penawaran->komponen as $item)
        <tr>
            <th scope="row"><small{{$nomor}}</small></th>
            <td><small>{{$item->nama_komponen}}</small></td>
            <td><small>{{$item->spesifikasi_teknis}}</small></td>
            <td><small>{{$item->satuan}}</small></td>
            <td><small>{{$item->total_unit}}</small></td>
            <td><input type="checkbox"/></td>
        </tr>
        {{$nomor +=1}}
    @endforeach
    <tr class="table">
        <th scope="col" colspan="5"><small class="float-right"><strong>Lengkap</strong></small></th>
        <td><input type="checkbox"/></i>
        </td>
    </tr>
    </tbody>
</table>
<p>Mohon diperiksa kembali keadaan barang dan diterima.</p>
<div class="row">
    <div class="column" style="width: 50%;">
        <p style="text-align: center; padding-bottom: 55px;">Sopir</p>
        <p style="text-align: center"><u>(___________________)</u></p>
    </div>
    <div class="column justify-content-center" style="width: 50%;">
        <p style="text-align: center; padding: 0; margin: 0">Hormat Kami,</p>
        <p style="text-align: center; margin: 0; padding-bottom: 50px;">Tukang</p>
        <p style="text-align: center"><u>( {{$data->pembayaran->pin->tukang->user->name}} )</u></p>
    </div>
</div>

<div style="page-break-before: always;"></div>

<center>
    <br>
    <br>
    <h5 style="color: #0c525d;" class="pb-0 mb-0"><strong><u>BUKTI SURAT JALAN</u></strong></h5>
    <p style="color: #0c525d;" class="pt-0 mt-0">Nomor : B.005/MM/PTRM/2021</p>
    <p style="margin-right: 0; margin-left: 0;">Barang telah diperiksa dan diterima pada tanggal </p>
    <p style="margin-right: 0; margin-left: 0;">(________________________)</p>
    <p style="margin: 0; padding-bottom: 50px;">Penerima</p>
    <p><u>( {{$data->pembayaran->pin->pengajuan->client->user->name}} )</u></p>
</center>
</body>
</html>
