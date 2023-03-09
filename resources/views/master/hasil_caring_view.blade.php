<style>
    #btnWhenUpdate{
        display: none;
    }
</style>
<h1 class="h3 mb-2 text-gray-800">HASIL CARING</h1>
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
                            <input type="text" name="hasil_caring" id="hasil_caring" class="form-control form-control-sm" placeholder="Nama Hasil Caring">
                            <small class="notif text-danger" id="notifError"></small>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6" id="btnWhenCreate">
                        <button class="btn btn-sm btn-success btn-block" id="btnSubmit" onclick="simpanCaring();"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                    <div class="col-sm-12 col-md-6" id="btnWhenUpdate">
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-xl-6">
                                <button class="btn btn-sm btn-primary btn-block" id="btnUpdate" onclick="updateCaring();"><i class="fas fa-edit"></i> Update</button>
                            </div>
                            <div class="col-sm-6 col-md-6 col-xl-6">
                                <button class="btn btn-sm btn-danger btn-block" id="btnCancel" onclick="cancelCaring();"><i class="fas fa-times"></i> Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered display responsive nowrap" id="dataTable" width="100%" cellspacing="0">
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
        $('#hasil_caring').val("");
    }

    function loadData(){
        $('#dataTable').DataTable({
            asynchronous: true,
            processing: true, 
            destroy: true,
            ajax: {
                url: "{{ url('master/caring/load') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'GET'
            },
            columns: [
                { name: 'id_hasil_caring', searchable: false, orderable: true, className: 'text-center' },
                { name: 'hasil_caring' },
                { name: 'action', searchable: false, orderable: false, className: 'text-center' }
            ],
            order: [[0, 'asc']],
            iDisplayInLength: 10 
        });
    }

    function simpanCaring(){
        var caring = $('#hasil_caring').val();
        $.ajax({
            url : '{{ url("master/caring/insert") }}',
            method : 'POST',
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            data : {
                'hasil_caring' : caring
            },
            success:function(res){
                if(res.status == 200){
                    $('#notifError').text("");
                    $('#hasil_caring').val('');
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

    function editHasilCaring(id){
        $.ajax({
            url : "{{ url('master/caring/edit/') }}/"+id,
            dataType : 'JSON',
            method : 'GET',
            success:function(res){
                $('#hasil_caring').val(res[0].hasil_caring);
                $('#btnWhenUpdate').show();
                $('#btnWhenCreate').hide();
                $('#btnUpdate').attr('onclick','updateCaring('+res[0].id_hasil_caring+')');
            }
        })
    }

    function updateCaring(id){
        var caring = $('#hasil_caring').val();
        $.ajax({
            url : '{{ url("master/caring/update") }}/'+id,
            method : 'POST',
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            data : {
                'hasil_caring' : caring
            },
            success:function(res){
                if(res.status == 200){
                    $('#notifError').text("");
                    $('#hasil_caring').val('');
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

    function deleteHasilCaring(id){
        $.ajax({
            url : '{{ url("master/caring/delete") }}/'+id,
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