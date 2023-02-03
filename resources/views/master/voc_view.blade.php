<style>
    #btnWhenUpdate{
        display: none;
    }
</style>
<h1 class="h3 mb-2 text-gray-800">HASIL VOC</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Master</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xl-12 mb-3">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <input type="text" name="voc" id="voc" class="form-control form-control-sm" placeholder="Nama Hasil VOC">
                            <small class="notif text-danger" id="notifError"></small>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6" id="btnWhenCreate">
                        <button class="btn btn-sm btn-success btn-block" id="btnSubmit" onclick="simpanVoc();"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                    <div class="col-sm-12 col-md-6" id="btnWhenUpdate">
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-xl-6">
                                <button class="btn btn-sm btn-primary btn-block" id="btnUpdate" onclick="updateVoc();"><i class="fas fa-edit"></i> Update</button>
                            </div>
                            <div class="col-sm-6 col-md-6 col-xl-6">
                                <button class="btn btn-sm btn-danger btn-block" id="btnCancel" onclick="cancelVoc();"><i class="fas fa-times"></i> Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                    <th>#</th>
                    <th>HASIL CARING</th>
                    <th>ACTION</th>
                </tr>
              </thead>
            </table>
        </div>
    </div>
</div>

<script>
   $(document).ready( function () {
        loadData();
    } );

    function cancelCaring(){
        $('#btnWhenUpdate').hide();
        $('#btnWhenCreate').show();
        $('#voc').val("");
    }

    function loadData(){
        $('#dataTable').DataTable({
            asynchronous: true,
            processing: true, 
            destroy: true,
            ajax: {
                url: "{{ url('voc/load') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'GET'
            },
            columns: [
                { name: 'id_voc', searchable: false, orderable: true, className: 'text-center' },
                { name: 'voc' },
                { name: 'action', searchable: false, orderable: false, className: 'text-center' }
            ],
            order: [[0, 'asc']],
            iDisplayInLength: 10 
        });
    }

    function simpanVoc(){
        var caring = $('#voc').val();
        $.ajax({
            url : '{{ url("voc/insert") }}',
            method : 'POST',
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            data : {
                'voc' : caring
            },
            success:function(res){
                if(res.status == 200){
                    $('#notifError').text("");
                    $('#voc').val('');
                    $('#dataTable').DataTable().ajax.reload(null, false);
                }else if(res.status == 401){
                    $.each(res.errors, function (i, val) {
                        $('#notifError').text(val);
                    });
                }else{
                    alert(res.message);
                }
            }
        })
    }

    function editVoc(id){
        $.ajax({
            url : "{{ url('voc/edit/') }}/"+id,
            dataType : 'JSON',
            method : 'GET',
            success:function(res){
                $('#voc').val(res[0].voc);
                $('#btnWhenUpdate').show();
                $('#btnWhenCreate').hide();
                $('#btnUpdate').attr('onclick','updateCaring('+res[0].id_voc+')');
            }
        })
    }

    function updateVoc(id){
        var caring = $('#voc').val();
        $.ajax({
            url : '{{ url("voc/update") }}/'+id,
            method : 'POST',
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            data : {
                'voc' : caring
            },
            success:function(res){
                if(res.status == 200){
                    $('#notifError').text("");
                    $('#voc').val('');
                    $('#dataTable').DataTable().ajax.reload(null, false);
                }else if(res.status == 401){
                    $.each(res.errors, function (i, val) {
                        $('#notifError').text(val);
                    });
                }else{
                    alert(res.message);
                }
            }
        })
    }

    function deleteVod(id){
        $.ajax({
            url : '{{ url("voc/delete") }}/'+id,
            dataType: 'JSON',
            method : 'GET',
            success:function(res){
                if(res.status == 200){
                    loadData();
                }else{
                    alert(res.message);
                }
            }
        })
    }
</script>