<style>
    .border-bottom{
        border: none;
        border-bottom : 1px solid grey;
        padding: 0;
    }
</style>
<h1 class="h3 mb-2 text-gray-800">Update Data Indihome Prepaid</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-xl-12">
                <a href="{{ url('prepaid') }}" class="btn btn-danger btn-sm float-right"><i class="fas fa-arrow-left"></i> Kembali ke Data Indihome Prepaid</a>
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
        <form action="{{ url('prepaid/update/'.$pp[0]->id_prepaid) }}" method="post">
            @csrf
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                DATA INDIHOME PREPAID
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nd_pots"><strong>NO HP / KONTAK :</strong></label>
                                    <input type="text" class="form-control form-control-sm border-bottom" value="{{ $pp[0]->cp_num }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="nd_pots"><strong>ND:</strong></label>
                                    <input type="text" class="form-control form-control-sm border-bottom" value="{{ $pp[0]->nd }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="nd_pots"><strong>NAMA PELANGGAN :</strong></label>
                                    <input type="text" class="form-control form-control-sm border-bottom" value="{{ $pp[0]->cust_name }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="nd_pots"><strong>WITEL :</strong></label>
                                    <input type="text" class="form-control form-control-sm border-bottom" value="{{ $pp[0]->witel }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="col-sm-12 col-md-6 col-xl-6">
                    <div class="form-group">
                        <label for="nd_pots">HASIL CALL</label>
                        <select name="hasil_voc" id="hasil_voc" class="select2 form-control">
                            <option value="">Pilih Hasil Call</option>
                            @foreach ($voc as $v)
                                <option value="{{ $v->id_voc }}" <?php if($v->id_voc == $pp[0]->hasil_voc){echo 'selected';}else{ echo '';} ?> >{{ $v->voc }}</option>
                            @endforeach
                        </select>
                        @error('hasil_voc') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="nd_pots"><strong>PIC :</strong></label>
                        <input type="text" class="form-control" name="pic_voc" id="pic_voc" value="{{ $pp[0]->pic_voc }}">
                        @error('pic_voc') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="keterangan_call">KETERANGAN CALL</label>
                        <textarea name="keterangan_call" id="keterangan_voc" class="form-control" cols="30" rows="10">{{ $pp[0]->keterangan_voc }}</textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success float-right"><i class="fas fa-save"></i> Simpan Data</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
          