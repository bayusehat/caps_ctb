<style>
    .border-bottom{
        border: none;
        border-bottom : 1px solid grey;
        padding: 0;
    }
</style>
<h1 class="h3 mb-2 text-gray-800">Share WO OBC</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-xl-12">
                <a href="javascript:void(0)" class="btn btn-primary btn-sm float-right" onclick="getUnmappedWo()"><i class="fas fa-sync"></i> Refresh WO</a>
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
            
        <table class="table table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th>Desc</th>
                    <th>Unmapped WO</th>
                </tr>
            </thead>
            <tbody id="tableWo">

            </tbody>
        </table>
        <br>
        <form action="" method="post" id="form">
            @csrf
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <select name="user_obc" id="user_obc" class="form-control select2">
                        <option value="">Pilih User</option>
                        @foreach ($user_obc as $v)
                            <option value="{{ $v->username }}">{{ $v->username }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 col-sm-12">
                   <input type="text" name="jumlah" id="jumlah" class="form-control">
                </div>
                <div class="col-md-3 col-sm-12">
                    <button type="button" onclick="runShareWo()" class="btn btn-success"><i class="fas fa-plus"></i> Share WO</button>
                </div>
            </div>   
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){
        getUnmappedWo();
    })
    function getUnmappedWo(){
        $.ajax({
            url : "{{ url('wo/unmapped') }}",
            method: 'GET',
            dataType : 'JSON',
            beforeSend:function(){
                $('#tableWo').loading();
            },
            complete:function(){
                $('#tableWo').loading('stop');
            },
            success:function(res){
                var row = '';
                $.each(res,function(i,val){
                    row += '<tr>'+
                            '<td>No Plot WO</td>'+
                            '<td>'+val.not_called+'</td>'+
                      '</tr>';
                })
                
                $("#tableWo").html(row);
            }
        })
    }

    function runShareWo(){
        var formData = $('#form').serialize();
        $.ajax({
            url : "{{ url('wo/share') }}",
            method : 'POST',
            headers : {
                'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content')
            },
            dataType : 'JSON',
            data : formData,
            beforeSend:function(){
                $('body').loading();
            },
            complete:function(){
                $('body').loading('stop');
            },
            success: function(res){
                if(res.status == 200){
                    alert(res.message);
                    getUnmappedWo();
                }else{
                    alert(res.message);
                } 
            }
        })
    }
</script>
          