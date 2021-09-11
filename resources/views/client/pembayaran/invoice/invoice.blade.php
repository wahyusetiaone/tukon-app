<style>
    .borderless td, .borderless th {
        border: none !important;
        font-size: 24px;
        padding-top: 20px;
        padding-right: 50px;
        padding-bottom: 20px;
        padding-left: 50px;
    }

    .borderless td {
        color: #756F86;
    }

    .font-size-main {
        padding-top: 10px;
        font-size: 24px;
    }
</style>
<div class="container-fluid bg-white p-5 mb-5">
    <div class="row">
        <div class="col-6 float-left">
            @isset($data->invoice->available_banks)
                @php
                    $bank = $data->invoice->available_banks[0];
                    $path = $bank['bank_code'].'.png';
                @endphp
                <img width="108px" height="34px" src="{{asset('/images/channel/'.$path)}}">
            @endisset
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
            <h3 class="text-bold pt-2">Nomor Virtual Akun {{$bank['bank_code']}}</h3>
            <h3 class="text-info text-bold pt-2">
                {{$bank['bank_account_number']}}
                <i class="fa fa-copy pl-2"></i></h3>
            <h3 class="text-bold pt-2 text-muted">Nama Akun : {{$bank['account_holder_name']}}</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-12 pt-4">
            <table class="table borderless">
                <thead>
                <tr class="bg-gray-light"
                    style="border-right: solid 1px #F2F2F2 !important; border-left: solid 1px #F2F2F2 !important; border-top: solid 1px #F2F2F2 !important;">
                    <th>Total Pembayaran</th>
                    <th class="float-right">{{indonesiaRupiah($bank['transfer_amount'])}}</th>
                </tr>
                </thead>
                <tbody>
                <tr style="border-right: solid 1px #F2F2F2 !important; border-left: solid 1px #F2F2F2 !important;">
                    <td>Total Harga Komponen</td>
                    <td class="float-right">{{indonesiaRupiah($harga_total_komponen)}}</td>
                </tr>
                <tr style="border-left: solid 1px #F2F2F2 !important; border-right: solid 1px #F2F2F2 !important; border-bottom: solid 1px #F2F2F2 !important;">
                    <td>Harga Jasa</td>
                    <td class="float-right">{{indonesiaRupiah((($harga_total_komponen * $data->pin->penawaran->keuntungan)/100))}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <p class="text-muted font-size-main  float-left">Selesaikan Pembayaran dalam</p>
        </div>

        @php
              $rem = strtotime($data->invoice->expiry_date) - time();
              $day = floor($rem / 86400);
              $hr  = floor(($rem % 86400) / 3600);
              $min = floor(($rem % 3600) / 60);
              $sec = ($rem % 60);
              if($day) echo "$day Days ";
              if($hr) echo "$hr Hours ";
              if($min) echo "$min Minutes ";
              if($sec) echo "$sec Seconds ";
              echo "Remaining...";
        @endphp
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
</div>
