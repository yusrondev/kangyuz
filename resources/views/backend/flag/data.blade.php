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
            <button type="button" class="btn mr-2 mb-2 btn-primary" data-toggle="modal" data-target="#modal-add">
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
                            <th>#</th>
                            <th>Flag Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($flags as $flag)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $flag->name }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm btn-edit" type="button" data-id="{{ $flag->id }}" data-name="{{ $flag->name }}">Edit</button>
                                <button class="btn btn-danger btn-sm" type="button">Delete</button>
                            </td>
                        </tr>
                        @endforeach
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
            <form id="form-flag" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Flag</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary save">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Pusher -->
<script>
    $(function() {

        const Echo = window.Echo;
        const user_id = $('#user_id');
        const description = $('#description');

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

                    //   Http.post("{{ url('administrator/store-task') }}", {
                    //       'user_id'   : user_id.val(),
                    //       'description': description.val(),
                    //   }).then(()=>{

                    //   });   

                }
            });
            e.preventDefault();
        });

        let channel = Echo.channel('channel-task');
        channel.listen('TaskEvent', function(data) {
            console.log(data);
        });

    });

    $(".btn-edit").click(function(){
        var myModal = new bootstrap.Modal(document.getElementById('modal-edit'));
        myModal.show()
    });
</script>
@endpush