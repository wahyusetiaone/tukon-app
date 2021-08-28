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
<center>
    <br>
    <img src="{{asset('/images/image001.jpg')}}">
    <br>
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
