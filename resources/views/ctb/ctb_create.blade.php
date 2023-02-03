<h1 class="h3 mb-2 text-gray-800">Input Data CTB</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form</h6>
    </div>
    <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-12">
                    <a href="{{ url('ctb') }}" class="btn btn-danger btn-sm float-right"><i class="fas fa-arrow-left"></i> Kembali ke Data CTB</a>
                </div>
            </div>
        <hr>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses!</strong> {{ Session::get('success')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> {{ Session::get('error')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <form action="{{ url('ctb/insert') }}" method="post">
            @csrf
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label for="nd_pots">ND INTERNET</label>
                            <input type="text" name="nd_internet" id="nd_internet" class="form-control">
                            @error('nd_internet') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="nd_pots">ND POTS</label>
                            <input type="text" name="nd_pots" id="nd_pots" class="form-control">
                            @error('nd_pots') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="nd_pots">NAMA PELANGGAN</label>
                            <input type="text" name="nama_pelanggan" id="nama_pelanggan" class="form-control">
                            @error('nama_pelanggan') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="nd_pots">NO IDENTITAS</label>
                            <input type="text" name="no_ktp" id="no_ktp" class="form-control">
                            @error('no_ktp') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="nd_pots">NO HP</label>
                            <input type="text" name="no_hp" id="no_hp" class="form-control">
                            @error('no_hp') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                <div class="col-sm-12 col-md-6 col-xl-6">
                    <div class="form-group">
                        <label for="witel">PAKET TERAKHIR</label>
                        <input type="text" name="paket_terakhir" id="paket_terakhir" class="form-control">
                        @error('paket_terakhir') <small class="text-danger">{{ $message }}</small> @enderror<br>
                        <small class="text-danger" id="notifError"></small>
                    </div>
                    <div class="form-group">
                        <label for="keterangan_ctb">KETERANGAN</label>
                        <textarea name="keterangan_ctb" id="keterangan_ctb" class="form-control" cols="30" rows="10"></textarea>
                        @error('keterangan_ctb') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4>Inpu Nomor Rekening Refund : </h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="">Nama Bank</label>
                    <input type="text" name="nama_bank" id="nama_bank" class="form-control">
                    @error('nama_bank') <small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="col-md-4">
                    <label for="">Nomor rekening</label>
                    <input type="text" name="no_rekening" id="no_rekening" class="form-control">
                    @error('no_rekening') <small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="col-md-4">
                    <label for="">Atas Nama Rekening</label>
                    <input type="text" name="atas_nama" id="atas_nama" class="form-control">
                    @error('atas_nama') <small class="text-danger">{{ $message }}</small>@enderror
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-12">
                    <button type="submit" class="btn btn-success float-right"><i class="fas fa-save"></i> Simpan Data</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $("#nd_internet").keyup(function () {
        var el = $(this);
            $.ajax({
                url: "{{ url('ctb/auto') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                type: "POST",
                data: {'nd_internet':el.val()},
                beforeSend:function(){
                    $('body').loading();
                },
                complete:function(){
                    $('body').loading('stop');
                },
                success:function(res){
                        if(res.status == 200){
                            if(el.val().length == res.nd_internet.length){
                                $('#paket_terakhir').val(res.paket_terakhir);
                                $('#notifError').text("");
                            }else{
                                $('#notifError').text("");
                                $('#paket_terakhir').val("");
                            }
                        }else{
                            $('#notifError').text('Paket tidak tersedia');
                            $('body').loading('stop');
                        }
                    }
                })
            });
</script>
          