<style>
    #btnWhenUpdate{
        display: none;
    }
</style>
<h1 class="h3 mb-2 text-gray-800">INDIHOME PREPAID</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Indihome Prepaid</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xl-12 mb-3">
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                    <th>#</th>
                    <th>ND</th>
                    <th>CUSTOMER NAME</th>
                    <th>CP NUMBER</th>
                    <th>WITEL</th>
                    <th>STATUS PREPAID</th>
                    <th>STATUS CALL</th>
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

    function loadData(){
        $('#dataTable').DataTable({
            asynchronous: true,
            processing: true, 
            destroy: true,
            ajax: {
                url: "{{ url('prepaid/load') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'GET'
            },
            columns: [
                { name: 'id_prepaid', searchable: false, orderable: true, className: 'text-center' },
                { name: 'nd' },
                { name: 'cust_name' },
                { name: 'cp_num' },
                { name: 'witel' }, 
                { name: 'status_prepaid' },
                { name: 'status_call' },
                { name: 'action', searchable: false, orderable: false, className: 'text-center' }
            ],
            order: [[0, 'asc']],
            iDisplayInLength: 10 
        });
    }
</script>