<div class="row">
    <div class="col-12">
        <div class="card w-100 bg-white rounded-0 shadow-none border-0 pl-3 pr-3 pt-1">
            <div class="row text-center">
                <div class="col-2 pt-3 pb-3 "
                    {!! (request()->segment(2) == 'penawaran') ? 'style="border-bottom: 4px solid;border-color: #008CC6;"' : ''  !!}>
                    <a href="{{ route('penawaran.client') }}" style="color: #008CC6;">
                        Penawaran
                    </a>
                </div>
                <div class="col-2 pt-3 pb-3"
                    {!! (request()->segment(2) == 'pembayaran') ? 'style="border-bottom: 4px solid;border-color: #008CC6;"' : ''  !!}>
                    <a href="{{ route('pembayaran.client') }}" style="color: #008CC6;">
                        Pembayaran
                    </a>
                </div>
                <div class="col-2 pt-3 pb-3"
                    {!! (request()->segment(2) == 'project') && !request()->has('only') ? 'style="border-bottom: 4px solid;border-color: #008CC6;"' : ''  !!}>
                    <a href="{{ route('project.client') }}" style="color: #008CC6;">
                        Dalam Proses
                    </a>
                </div>
                <div class="col-2 pt-3 pb-3"
                    {!! (request()->segment(2) == 'project') && request()->has('only') && (request()->input('only') == 'selesai') ? 'style="border-bottom: 4px solid;border-color: #008CC6;"' : ''  !!}>
                    <a href="{{ route('project.client',['only'=>'selesai']) }}" style="color: #008CC6;">
                        Selesai
                    </a>
                </div>
                <div class="col-3 pt-3 pb-3"
                    {!! (request()->segment(2) == 'project') && request()->has('only') && (request()->input('only') == 'batal') ? 'style="border-bottom: 4px solid;border-color: #008CC6;"' : ''  !!}>
                    <a href="{{ route('project.client',['only'=>'batal']) }}" style="color: #008CC6;">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
