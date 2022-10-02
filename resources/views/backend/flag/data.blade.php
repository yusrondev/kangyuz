@extends('template.backend')
@section('active-menu-task', 'mm-active')
@section('title-content', 'Task')
@section('description-content', 'Data pekerjaan')
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-car icon-gradient bg-mean-fruit">
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
            <button type="button" class="btn mr-2 mb-2 btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">
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
                <table class="mb-0 table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Project</th>
                            <th>Last Name</th>
                            <th>Username</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            <td>
                                <button class="btn btn-success" type="button">Done</button>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                            <td>
                                <button class="btn btn-success" type="button">Done</button>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                            <td>
                                <button class="btn btn-success" type="button">Done</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<!-- Large modal -->

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <form id="form-flag" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Tambah Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="position-relative row form-group">
                        <label class="col-sm-2 col-form-label">Project</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary save">Save changes</button>
                    </div>
                </div>
        </form>
    </div>
</div>

<!-- Pusher -->
<script>
    $(function() {

        const Echo = window.Echo;
        const user_id = $('#user_id');
        const description = $('#description');

        $('.save').click(function() {

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
        });

        let channel = Echo.channel('channel-task');
        channel.listen('TaskEvent', function(data) {
            console.log(data);
        });

    });
</script>
@endpush