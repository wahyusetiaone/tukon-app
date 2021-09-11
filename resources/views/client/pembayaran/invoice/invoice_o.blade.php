<style>
    .borderless td, .borderless th {
        border: none !important;
        font-size: 24px;
        padding-top: 20px;
        padding-right: 50px;
        padding-bottom: 20px;
        padding-left: 50px;
    }
    .borderless td{
        color: #756F86;
    }

    .font-size-main{
        padding-top: 10px;
        font-size: 24px;
    }
</style>
<div class="container-fluid bg-white p-5 mb-5">
    <div class="row">
        <div class="col-6 float-left">
            <img width="108px" height="34px" src="{{asset('/images/channel/BCA.png')}}">
        </div>
        <div class="col-6">
            <p class="float-right text-muted align-middle">
                <i class="fa fa-chevron-left"></i>
                Kembali
            </p>
        </div>
    </div>
    <div class="row pt-5">
        <div class="col-12 text-center">
            <h3 class="text-bold pt-2">Nomor Virtual Akun BCA</h3>
            <h3 class="text-info text-bold pt-2">
                8881 0 08139 2236 5533
                <i class="fa fa-copy pl-2"></i></h3>
            <h3 class="text-bold pt-2 text-muted">Nama Akun : TUKANG ONLINE</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-12 pt-4">
            <table class="table borderless">
                <thead>
                <tr class="bg-gray-light" style="border-right: solid 1px #F2F2F2 !important; border-left: solid 1px #F2F2F2 !important; border-top: solid 1px #F2F2F2 !important;" >
                    <th>Total Pembayaran</th>
                    <th class="float-right">Rp. 1,270,000,-</th>
                </tr>
                </thead>
                <tbody>
                <tr style="border-right: solid 1px #F2F2F2 !important; border-left: solid 1px #F2F2F2 !important;">
                    <td>Total Harga Komponen</td>
                    <td class="float-right">Rp. 1,220,000,-</td>
                </tr>
                <tr style="border-left: solid 1px #F2F2F2 !important; border-right: solid 1px #F2F2F2 !important; border-bottom: solid 1px #F2F2F2 !important;">
                    <td>Harga Jasa</td>
                    <td class="float-right">Rp. 50,000,-</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <p class="text-muted font-size-main  float-left">Selesaikan Pembayaran dalam</p>
        </div>

        <div class="col-6">
            <p class="font-size-main float-right font-weight-bold" style="color: #FF5722">24:51:21</p>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <p class="text-muted font-size-main  float-left">Batas akhir pembayaran</p>
        </div>

        <div class="col-6">
            <p class="font-size-main float-right font-weight-bold">Selasa, 31 Agustus 2021 09:31</p>
        </div>
    </div>
    <div class="container-fluid pt-2 pl-4 pr-4">
        <div class="row">
            <div class="col-12">
                <p class="font-size-main font-weight-bold">Silahkan ikuti instruksi dibawah untuk transfer : </p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @include('client.pembayaran.invoice.instructions.bca')
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <p class="text-muted text-center"> Jika anda telah melakukan pembayaran, mohon melakukan konfirmasi pembayaran di bawah ini.</p>
            <a href="{{route('payoffline.pembayaran.client', $id)}}">
                <button class="btn btn-info btn-block btn-lg">
                    KONFIRMASI PEMBAYARAN
                </button>
            </a>
        </div>
    </div>
</div>
