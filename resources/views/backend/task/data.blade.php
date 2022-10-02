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
                    Task
                    <div class="page-title-subheading">
                        Data task project
                    </div>
                </div>
            </div>
            <div class="page-title-actions">
                <button type="button" class="btn mr-2 mb-2 btn-primary" data-toggle="modal"
                    data-target=".bd-example-modal-lg">
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

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Tambah Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-task" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="position-relative row form-group">
                            <label for="user_id" class="col-sm-2 col-form-label">Programmer</label>
                            <div class="col-sm-10">
                                <select name="user_id" id="user_id" class="form-control choose-user">
                                    <option selected disabled>- Pilih Murid -</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" data-project="{{ $user->project_name }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="position-relative row form-group">
                            <label for="type" class="col-sm-2 col-form-label">type</label>
                            <div class="col-sm-10">
                                <select name="type" id="type" name="type" class="form-control">
                                    <option value="Request">Request</option>
                                    <option value="Bug">Bug</option>
                                    <option value="Checking">Checking</option>
                                </select>
                            </div>
                        </div>

                        <div class="position-relative row form-group">
                            <label class="col-sm-2 col-form-label">Project</label>
                            <div class="col-sm-10">
                                <input type="text" disabled class="form-control project-name">
                            </div>
                        </div>

                        <div class="position-relative row form-group">
                            <label for="title" class="col-sm-2 col-form-label">Judul</label>
                            <div class="col-sm-10">
                                <input type="text" id="title" name="title" class="form-control">
                            </div>
                        </div>

                        <div class="position-relative row form-group">
                            <label for="description" class="col-sm-2 col-form-label">Deskripsi</label>
                            <div class="col-sm-10">
                                <textarea name="description" class="form-control" id="description" cols="30" rows="10"></textarea>
                            </div>
                        </div>

                        <div class="position-relative row form-group">
                            <label for="image" class="col-sm-2 col-form-label">Gambar</label>
                            <div class="col-sm-10">
                                <input type="file" id="image" name="image" class="form-control">
                            </div>
                        </div>

                        <div class="position-relative row form-group">
                            <label for="rank" class="col-sm-2 col-form-label">Rank</label>
                            <div class="col-sm-10">
                                <select name="rank" id="rank" class="form-control">
                                    <option value="Easy">Easy</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Hard">Hard</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary save">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Pusher -->
    <script>
        $(function(){

            const Echo    = window.Echo;
            const user_id    = $('#user_id');
            const description = $('#description');

            $('.save').click(function(){

                var form_data = new FormData($("#form-task")[0]);
                
                jQuery.ajax({
                processData: false,
                contentType: false,  
                  url        : "{{ url('administrator/store-task') }}",
                  method     : 'POST',
                  dataType   : "JSON",
                  data       : form_data,
                  success: function(result){

                    //   Http.post("{{ url('administrator/store-task') }}", {
                    //       'user_id'   : user_id.val(),
                    //       'description': description.val(),
                    //   }).then(()=>{

                    //   });   
                      
                  }});
               });

            let channel = Echo.channel('channel-task');
            channel.listen('TaskEvent', function(data){
                console.log(data);
            });

        });

        $(".choose-user").on("change",function(){
            var project_name = $(this).find(":selected").data("project");
            $(".project-name").val(project_name);
        })
        
    </script>
@endpush
