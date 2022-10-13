@extends('template.backend')
@section('active-menu-flag', 'mm-active')
@section('title-content', 'Flag')
@section('description-content', 'Data pekerjaan')
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-pendrive icon-gradient bg-mean-fruit">
                </i>
            </div>
            <div>
                Flag
                <div class="page-title-subheading">
                    Data flag
                </div>
            </div>
        </div>
        <div class="page-title-actions">
            <button type="button" class="btn mr-2 mb-2 btn-primary btn-add">
                <i class="fa fa-plus"></i>
            </button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="main-card mb-3 card">
            <div class="card-body">

                <h5 class="card-title">Data pekerjaan</h5>
                <table class="mb-0 table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th width="20">#</th>
                            <th>Flag Name</th>
                            <th>Number Of Task</th>
                            <th width="80">Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-body-data">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<!-- Large modal -->

<!-- ADD MODAL -->
<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <form id="form-flag" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Tambah Flag</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="position-relative row form-group">
                        <label class="col-sm-4 col-form-label">Nama Flag</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="name">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary save">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- EDIT MODAL -->
<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <form id="form-edit-flag" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Flag</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="position-relative row form-group">
                        <label class="col-sm-4 col-form-label">Nama Flag</label>
                        <div class="col-sm-8">
                            <input type="hidden" class="form-control" name="id">
                            <input type="text" class="form-control" name="name">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary save">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Pusher -->
<script>
    var modal_add  = new bootstrap.Modal(document.getElementById('modal-add'));
    var modal_edit = new bootstrap.Modal(document.getElementById('modal-edit'));
    $(document).ready(function() {
        refresh_data();

        $("#form-flag").submit(function(e) {

            var form_data = new FormData($("#form-flag")[0]);

            jQuery.ajax({
                processData: false,
                contentType: false,
                url: "{{ url('administrator/store-flag') }}",
                method: 'POST',
                dataType: "JSON",
                data: form_data,
                success: function(result) {
                    // location.reload();
                    refresh_data();
                }
            });
            e.preventDefault();
        });

        $("#form-edit-flag").submit(function(e) {

            var form_data = new FormData($("#form-edit-flag")[0]);

            jQuery.ajax({
                processData: false,
                contentType: false,
                url: "{{ url('administrator/update-flag') }}",
                method: 'POST',
                dataType: "JSON",
                data: form_data,
                success: function(result) {
                    // location.reload();
                    refresh_data();
                }
            });
            e.preventDefault();
        });

        
    });
    $("body").on("submit", ".form-delete", function(e) {

        e.preventDefault();

        // var form_data = new FormData($(this));

        jQuery.ajax({
            processData: false,
            contentType: false,
            url: $(this).attr("action"),
            method: 'DELETE',
            dataType: "JSON",
            data: $(this).serialize(),
            success: function(result) {
                // location.reload();
                refresh_data();
            }
        });
    });

    // ADD
    $("body").on("click", ".btn-add", function(){
        $("#modal-add").modal('show');
        
        $('input[name="name"]').val();
    });

    // EDIT
    $("body").on("click", ".btn-edit", function(){
        $("#modal-edit").modal('show');
        
        $('input[name="name"]').val($(this).data("name"));
        $('input[name="id"]').val($(this).data("id"));
    });
    
    
    function refresh_data(){
        jQuery.ajax({
            processData: false,
            contentType: false,
            url: "{{ url('administrator/data-flag') }}",
            method: 'POST',
            dataType: "JSON",
            success: function(result) {
                
                let forTable = "";
                let no       = 1;
                result.forEach(function(val){
                    // log(val);
                    forTable += `
                        <tr>
                            <td>${no++}</td>
                            <td>${val.name}</td>
                            <td><span class="text-info">${val.task_count}</span></td>
                            <td>

                                <form action="destroy-flag/${val.id}" class="form-delete" method="POST">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-warning btn-sm btn-edit" data-id="${val.id}" data-name="${val.name}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" type="submit"><i class="fa fa-trash"></i></button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    `;
                });
                $(".table-body-data").html(forTable);
                
                modal_edit.hide();
                modal_add.hide();
            }
        });
    }
    
</script>
@endpush
