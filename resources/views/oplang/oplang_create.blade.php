
<h1 class="h3 mb-2 text-gray-800">Update Data CTB setelah Call OBC</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-xl-12">
                <a href="{{ url('oplang') }}" class="btn btn-danger btn-sm float-right"><i class="fas fa-arrow-left"></i> Kembali ke Data Oplang</a>
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
        <form action="{{ url('oplang/update/'.$ctb[0]->id) }}" method="post">
            @csrf
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                DATA CTB SETELAH CALL
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nd_pots"><strong>HASIL CARING :</strong></label>
                                    <select name="hasil_caring" id="hasil_caring" class="select2 form-control">
                                        <option value="">-- Pilih Hasil Caring --</option>
                                        @foreach ($hasil_caring as $hc)
                                            <option value="{{ $hc->id_hasil_caring }}" 
                                            @if ($hc->id_hasil_caring == $ctb[0]->hasil_call)
                                                {{ 'selected' }}
                                            @else
                                                {{ '' }}
                                            @endif>{{ $hc->hasil_caring }}</option>
                                        @endforeach
                                    </select>
                                    {{-- <input type="text" class="form-control form-control-sm border-bottom text-danger" value="{{ $ctb[0]->hasil_caring }}" disabled> --}}
                                </div>
                                <div class="form-group">
                                    <label for="nd_pots"><strong>USER OBC :</strong></label>
                                    <input type="text" class="form-control form-control-sm border-bottom" value="{{ $ctb[0]->user_obc }}" disabled>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="nd_pots"><strong>NO HP / KONTAK :</strong></label>
                                    <input type="text" class="form-control form-control-sm border-bottom" value="{{ $ctb[0]->no_hp }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="nd_pots"><strong>PIC :</strong></label>
                                    <input type="text" class="form-control form-control-sm border-bottom" value="{{ $ctb[0]->pic_obc }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="nd_pots"><strong>ND POTS :</strong></label>
                                    <input type="text" class="form-control form-control-sm border-bottom" value="{{ $ctb[0]->nd_pots }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="nd_pots"><strong>ND INTERNET :</strong></label>
                                    <input type="text" class="form-control form-control-sm border-bottom" value="{{ $ctb[0]->nd_internet }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="nd_pots"><strong>NAMA PELANGGAN :</strong></label>
                                    <input type="text" class="form-control form-control-sm border-bottom" value="{{ $ctb[0]->nama_pelanggan }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="nd_pots"><strong>WITEL :</strong></label>
                                    <input type="text" class="form-control form-control-sm border-bottom" value="{{ $ctb[0]->witel }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="nd_pots"><strong>KETERANGAN CALL:</strong></label>
                                    <textarea id="" cols="30" rows="10" class="form-control form-control-sm border-bottom" disabled>{{ $ctb[0]->keterangan_call }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="col-sm-12 col-md-6 col-xl-6">
                    <div class="form-group">
                        <label for="nd_pots">HASIL MC</label>
                        <select name="hasil_mc" id="hasil_mc" class="select2 form-control">
                            <option value="">Pilih Hasil MC</option>
                            <option value="1" <?php if($ctb[0]->hasil_mc == 1){echo 'selected';}else{echo '';}?>>SUKSES</option>
                            <option value="2" <?php if($ctb[0]->hasil_mc == 2){echo 'selected';}else{echo '';}?>>ANOMALI</option>
                            <option value="3" <?php if($ctb[0]->hasil_mc == 3){echo 'selected';}else{echo '';}?>>GAGAL</option>
                        </select>
                        @error('hasil_mc') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="nd_pots">REASON MC</label>
                        <select name="reason_mc" id="reason_mc" class="select2 form-control">
                            <option value="">Pilih Reason</option>
                            @foreach ($reason as $r)
                                <option value="{{ $r->id_reason }}"
                                    @if ($r->id_reason == $ctb[0]->reason_mc)
                                        {{ 'selected' }}
                                    @else
                                        {{ '' }}
                                    @endif>{{ $r->reason }}</option>
                            @endforeach
                        </select>
                        @error('reason_mc') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="nd_pots">NOMOR PERMINTAAN :</label>
                        <input type="text" class="form-control" name="nomor_permintaan" id="nomor_permintaan" value="{{ $ctb[0]->nomor_permintaan }}">
                        @error('nomor_permintaan') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="keterangan_mc">KETERANGAN MC</label>
                        <textarea name="keterangan_mc" id="keterangan_mc" class="form-control" cols="30" rows="10">{{ $ctb[0]->keterangan_mc }}</textarea>
                        @error('keterangan_mc') <small class="text-danger">{{ $message }}</small> @enderror
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
          