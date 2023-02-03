<style>
    .border-bottom{
        border: none;
        border-bottom : 1px solid grey;
        padding: 0;
    }
</style>
<h1 class="h3 mb-2 text-gray-800">Update Data HVC CAPS Call</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-xl-12">
                <a href="{{ url('obc') }}" class="btn btn-danger btn-sm float-right"><i class="fas fa-arrow-left"></i> Kembali ke Data HVC Caps</a>
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
        <form action="{{ url('hvc/update/'.$hvc[0]->id) }}" method="post">
            @csrf
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                DATA CTB
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nd_pots"><strong>NO HP / KONTAK :</strong></label>
                                    <input type="text" class="form-control form-control-sm border-bottom" value="{{ $hvc[0]->newcp }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="nd_pots"><strong>ND POTS :</strong></label>
                                    <input type="text" class="form-control form-control-sm border-bottom" value="{{ $hvc[0]->notel_pots }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="nd_pots"><strong>ND INTERNET :</strong></label>
                                    <input type="text" class="form-control form-control-sm border-bottom" value="{{ $hvc[0]->notel_net }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="nd_pots"><strong>NAMA PELANGGAN :</strong></label>
                                    <input type="text" class="form-control form-control-sm border-bottom" value="{{ $hvc[0]->nama }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="nd_pots"><strong>WITEL :</strong></label>
                                    <input type="text" class="form-control form-control-sm border-bottom" value="{{ $hvc[0]->witel }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="nd_pots"><strong>KATEGORI HVC :</strong></label>
                                    <textarea id="" cols="30" rows="10" class="form-control form-control-sm border-bottom" disabled>{{ $hvc[0]->kat_hvc }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="col-sm-12 col-md-6 col-xl-6">
                    <div class="form-group">
                        <label for="nd_pots">HASIL CALL</label>
                        <select name="hasil_call" id="hasil_call" class="select2 form-control">
                            <option value="">Pilih Hasil Call</option>
                            @foreach ($hasil_caring as $hc)
                                <option value="{{ $hc->id_hasil_caring }}" <?php if($hc->id_hasil_caring == $hvc[0]->hasil_call){echo 'selected';}else{ echo '';} ?> >{{ $hc->hasil_caring }}</option>
                            @endforeach
                        </select>
                        @error('hasil_call') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="keterangan_call">KETERANGAN CALL</label>
                        <textarea name="keterangan_call" id="keterangan_call" class="form-control" cols="30" rows="10">{{ $hvc[0]->keterangan_call }}</textarea>
                        @error('keterangan_call') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success float-right"><i class="fas fa-save"></i> Simpan Data</button>
                    </div>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-sm-12 col-md-12 col-xl-12">
                    <button type="submit" class="btn btn-success float-right"><i class="fas fa-save"></i> Simpan Data</button>
                </div>
            </div> --}}
        </form>
    </div>
</div>
          