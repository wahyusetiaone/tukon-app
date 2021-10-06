<!DOCTYPE html>
<html>
<head>
    <title>Invoice {{$data->pin->pengajuan->nama_proyek}}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .borderless td, .borderless th {
            border: none;
        }

        {{--.bg {--}}
        {{--    /* The image used */--}}
        {{--    background-image: url("{{asset('images/bg_img.png')}}");--}}

        {{--    height: 100%;--}}

        {{--    /* Center and scale the image nicely */--}}
        {{--    background-position: center;--}}
        {{--    background-repeat: no-repeat;--}}
        {{--    background-size: 100%;--}}
        {{--}--}}

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
<div>
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
        {{--    <img src="{{asset('/images/image001.jpg')}}">--}}
        <br>
        <br>
        <h5 style="color: #0c525d;"><strong><u>INVOICE</u></strong></h5>
        <div class="float-right ">{{indonesiaDate($data->created_at)}}</div>
        <br>
        <table cellspacing="2">
            <tbody>
            <tr>
                <td><p style="font-size: 16px;">Nama</p></td>
                <td><p style="font-size: 16px;"> : </p></td>
                <td><p style="font-size: 16px;">{{$data->pin->pengajuan->client->user->name}}</p></td>
            </tr>
            <tr>
                <td><p style="font-size: 16px;">Status</p></td>
                <td><p style="font-size: 16px;"> : </p></td>
                <td><p style="font-size: 16px;">Klien</p></td>
            </tr>
            <tr>
                <td><p style="font-size: 16px;">NO</p></td>
                <td><p style="font-size: 16px;"> : </p></td>
                <td><p style="font-size: 16px;">{{$data->id}}/RAI/I/2021</p></td>
            </tr>
            </tbody>
        </table>
    </center>

    <table style="width: 100%; border-color: #000 !important;" class="table borderless">
        {{$nomor = 1 }}
        {{$tt = 0 }}
        <thead class="thead-dark">
        <tr>
            <th scope="col"><small>No</small></th>
            <th scope="col"><small>Nama Item</small></th>
            <th scope="col"><small>Harga</small></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row"><small>1</small></th>
            <td><small>Bahan dan alat yang digunakan untuk melaksanakan pekerjaan proyek.</small></td>
            <td><small>{{indonesiaRupiah($data->pin->penawaran->harga)}}</small></td>
        </tr>
        </tbody>
        <table style="width: 100%">
            <tbody>
            <tr>
                <td><p><em>Important Note :</em></p></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td rowspan="5" style="width: 45%">
                    <div style="width: 350px; border: 1px solid black; padding: 5px;">
                        Pembayaran via cash atau transfer ke Rekening :
                        BCA 3930294127 a.n Wendi Ardiawan Happy
                        Mandiri 1140014145562 a.n CV Radja Advertise Indonesia
                        Pembayaran pelunasan dilakukan setelah diterima
                        tanda tangan BAST
                        Bila BAST pekerjaan telah di Tandatangani belum ada
                        pelunasan, maka pekerjaan akan di lakukan
                        pembongkaran / penarikan
                    </div>
                </td>
                <td style="width:15%; text-align: right; vertical-align: bottom;">Jasa :</td>
                <td style="width:40%; text-align: right; vertical-align: bottom;">{{indonesiaRupiah(($data->pin->penawaran->harga*$data->pin->penawaran->keuntungan)/100)}}</td>
            </tr>
            <tr>
                <td style="width:15%; text-align: right; vertical-align: bottom;">Total :</td>
                <td style="width:40%; text-align: right; vertical-align: bottom;">{{indonesiaRupiah($data->total_tagihan)}}</td>
            </tr>
            </tbody>
        </table>
    </table>
</div>
</body>
</html>
