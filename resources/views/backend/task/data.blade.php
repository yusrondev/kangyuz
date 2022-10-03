@extends('template.backend')
@section('active-menu-task', 'mm-active')
@section('title-content', 'Task')
@section('description-content', 'Data pekerjaan')
@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-display2 icon-gradient bg-mean-fruit">
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
                <button type="button" class="btn mr-2 mb-2 show-modal btn-primary" data-toggle="modal"
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
                    <table class="mb-0 table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Flag</th>
                                <th>Project</th>
                                <th>Judul</th>
                                <th>Programmer</th>
                                <th>Rank</th>
                                <th>Type</th>
                                <th width="7%">Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($task as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->flag->name }}</td>
                                    <td>{{ $item->user->project_name }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->rank }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td>
                                        @if($item->status == 'new')
                                            <center>
                                                <span class="status-new">New</span>
                                            </center>
                                        @elseif($item->status == 'process')
                                            <center>
                                                <span class="status-process">Process</span>
                                            </center>
                                        @else
                                            <center>
                                                <span class="status-finish">Selesai</span>
                                            </center>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning detail" data-id="{{ $item->id }}">Detail</button>
                                        
                                        @if($item->status == 'new')
                                            <button class="btn btn-sm btn-primary update-status" data-value="process" data-id="{{ $item->id }}">Proses</button>
                                        @elseif($item->status == 'process')
                                            <button class="btn btn-sm btn-success update-status" data-value="finish" data-id="{{ $item->id }}">Selesai</button>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $task->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <!-- Large modal -->

    <div class="modal add-task fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-task" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="position-relative row form-group">
                            <label for="flag_id" class="col-sm-2 col-form-label">Flag</label>
                            <div class="col-sm-10">
                                <select name="flag_id" id="flag_id" class="form-control">
                                    <option value="0" selected disabled>- Pilih Flag -</option>
                                    @foreach($flag as $flags)
                                        <option value="{{ $flags->id }}">{{ $flags->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="position-relative row form-group">
                            <label for="user_id" class="col-sm-2 col-form-label">Programmer</label>
                            <div class="col-sm-10">
                                <select name="user_id" id="user_id" class="form-control choose-user">
                                    <option value="0" selected disabled>- Pilih Programmer -</option>
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
                                    <option value="0" disabled selected>- Pilih Type -</option>
                                    <option value="Request">Request</option>
                                    <option value="Bug">Bug</option>
                                    <option value="Checking">Checking</option>
                                </select>
                            </div>
                        </div>

                        <div class="position-relative row form-group">
                            <label class="col-sm-2 col-form-label">Project</label>
                            <div class="col-sm-10">
                                <input type="text" id="project_name" disabled class="form-control project-name">
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

                    let channel = Echo.channel('channel-task');
                    channel.listen('TaskEvent', function(data){
                        console.log(data);
                    });
                
                    location.reload(); 
                    
                }});
            });
        });

        $(".choose-user").on("change",function(){
            var project_name = $(this).find(":selected").data("project");
            $(".project-name").val(project_name);
        });

        $('body').on('click','.detail', function(elem){

            elem.preventDefault();
            var id = $(this).data('id');

            jQuery.ajax({
                url        : "{{ url('administrator/get-task') }}" + "/" + id,
                method     : 'GET',
                dataType   : "JSON",
                success: function(result){

                    $('.show-modal').trigger('click');
                    $('#flag_id').val(result.flag.id);
                    $('#user_id').val(result.user.id);
                    $('#type').val(result.type);
                    $('#project_name').val(result.user.project_name);
                    $('#title').val(result.title);
                    $('#description').text(result.description);
                    $('#rank').val(result.rank);
                    $('.modal-title').text('Edit Task');

                }
            });    
        });
        
        $('body').on('click','.update-status', function(elem){

            elem.preventDefault();
            var id     = $(this).data('id');
            var status = $(this).data('value');

            jQuery.ajax({
                url        : "{{ url('administrator/update-task') }}" + "/" + id,
                method     : 'GET',
                dataType   : "JSON",
                data       : {
                    status : status
                },
                success: function(result){
                    if (result) {
                        location.reload();
                    }
                }
            });    

        });

        $('.show-modal').click(function(){
            $('#flag_id').val('0');
            $('#user_id').val('0');
            $('#type').val('0');
            $('#project_name').val('');
            $('#title').val('');
            $('#description').text('');
            $('#rank').val('');
            $('.modal-title').text('Tambah Task');
        });

        $('body').on('click','.detail', function(elem){

            elem.preventDefault();
            var id = $(this).data('id');

            jQuery.ajax({
            url        : "{{ url('administrator/get-task') }}" + "/" + id,
            method     : 'GET',
            dataType   : "JSON",
            success: function(result){

                $('.show-modal').trigger('click');
                $('#flag_id').val(result.flag.id);
                $('#user_id').val(result.user.id);
                $('#type').val(result.type);
                $('#project_name').val(result.user.project_name);
                $('#title').val(result.title);
                $('#description').text(result.description);
                $('#rank').val(result.rank);
                $('.modal-title').text('Edit Task');

            }});    

        });
        
    </script>
@endpush
