<style>
    #btnWhenUpdate{
        display: none;
    }
</style>
<h1 class="h3 mb-2 text-gray-800">USER</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Master</h6>
    </div>
    <div class="card-body">
        <form id="form">
            @csrf
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xl-12 mb-3">
                    <div class="row">
                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <input type="text" name="username" id="username" class="form-control form-control-sm" placeholder="Username">
                                <small class="notif text-danger" id="notifusername"></small>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <select name="profil" id="profil" class="select2 form-control">
                                    <option value="">Pilih Profil</option>
                                    <option value="1">OBC</option>
                                    <option value="2">CTB</option>
                                    <option value="3">OPLANG</option>
                                    <option value="4">ADMIN</option>
                                </select>
                                <small class="notif text-danger" id="notifprofil"></small>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <select name="witel" id="witel" class="select2 form-control">
                                    <option value="">Pilih Witel</option>
                                    @foreach ($witel as $w)
                                        <option value="{{ $w->cwitel }}">{{ $w->witel }}</option>
                                    @endforeach
                                </select>
                                <small class="notif text-danger" id="notifwitel"></small>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3" id="btnWhenCreate">
                            <button type="button" class="btn btn-sm btn-success btn-block" id="btnSubmit" onclick="simpanUser();"><i class="fas fa-save"></i> Simpan</button>
                        </div>
                        <div class="col-sm-12 col-md-3" id="btnWhenUpdate">
                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-xl-6">
                                    <button type="button" class="btn btn-sm btn-primary btn-block" id="btnUpdate" onclick="updateUser();"><i class="fas fa-edit"></i> Update</button>
                                </div>
                                <div class="col-sm-6 col-md-6 col-xl-6">
                                    <button type="button" class="btn btn-sm btn-danger btn-block" id="btnCancel" onclick="cancelUser();"><i class="fas fa-times"></i> Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered display nowrap table-sm" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                    <th>#</th>
                    <th>USERNAME</th>
                    <th>PROFIL</th>
                    <th>WITEL</th>
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

    function cancelUser(){
        $('#btnWhenUpdate').hide();
        $('#btnWhenCreate').show();
        $('#form').trigger('reset');
        $('#profil').val('').trigger('change');
        $('#witel').val('').trigger('change');
    }

    function loadData(){
        $('#dataTable').DataTable({
            asynchronous: true,
            processing: true, 
            destroy: true,
            ajax: {
                url: "{{ url('user/load') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'GET'
            },
            columns: [
                { name: 'id_user', searchable: false, orderable: true, className: 'text-center' },
                { name: 'username' },
                { name: 'profil' },
                { name: 'witel' },
                { name: 'action', searchable: false, orderable: false, className: 'text-center' }
            ],
            order: [[0, 'asc']],
            iDisplayInLength: 10 
        });
    }

    function simpanUser(){
        var formData = $('#form').serialize();
        $.ajax({
            url : '{{ url("user/insert") }}',
            method : 'POST',
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            data : formData,
            success:function(res){
                if(res.status == 200){
                    $('.notif').text("");
                    $('#form').trigger('reset');
                    $('#dataTable').DataTable().ajax.reload(null, false);
                }else if(res.status == 401){
                    $.each(res.errors, function (i, val) {
                        $('#notif'+i).text(val);
                    });
                }else{
                    alert(res.message);
                }
            }
        })
    }

    function editUser(id){
        $.ajax({
            url : "{{ url('user/edit') }}/"+id,
            dataType : 'JSON',
            method : 'GET',
            success:function(res){
                $('#username').val(res[0].username);
                $('#profil').val(res[0].profil).trigger('change');
                $('#witel').val(res[0].cwitel).trigger('change');
                $('#btnWhenUpdate').show();
                $('#btnWhenCreate').hide();
                $('#btnUpdate').attr('onclick','updateUser('+res[0].id_user+')');
            }
        })
    }

    function updateUser(id){
        var formData = $('#form').serialize();
        $.ajax({
            url : '{{ url("user/update") }}/'+id,
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            data : formData,
            method : 'POST',
            success:function(res){
                if(res.status == 200){
                    $('.notif').text("");
                    $('#form').trigger('reset');
                    $('#dataTable').DataTable().ajax.reload(null, false);
                }else if(res.status == 401){
                    $.each(res.errors, function (i, val) {
                        $('#notif'+i).text(val);
                    });
                }else{
                    alert(res.message);
                }
            }
        })
    }

    function deleteUser(id){
        $.ajax({
            url : '{{ url("user/delete") }}/'+id,
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