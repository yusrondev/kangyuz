<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<style>
    .images{
        width:50%;
        /* height: 50%; */
    }
    .center{
        text-align: center !important;
    }

    .nameof{
        font-weight: bold;
        font-size: 18px
    }

    .count-task{
        text-align: center !important;
        font-size: 60px;
        background-color: #dfe4ea;
        color:#2f3542;
        font-weight: bolder
    }

    .job-title{
        color: #ffffff;
        font-size: 18px;
        margin-top: -10px;
        text-align: center !important;
        margin-bottom: 20px;
    }

    .bg-green{
        background-color: #78e08f;
        padding: 3px;
        border-radius: 5px;
    }

    .rank-1{
        background-color: #f6b93b;
        padding: 0px;
        border-radius: 6px;
    }

    .rank-2{
        background-color: #45aaf2;
        padding: 0px;
        border-radius: 6px;
    }

    .rank-3{
        background-color: #a55eea;
        padding: 0px;
        border-radius: 6px;
    }

    .number{
        font-size: 50px;
        text-align: center !important;
        font-weight: bolder;
        color: white;
    }

    .description{
        margin-top: -10px;
        color: #4b6584
    }

    .project-name{
        font-weight: 100;
    }
</style>
<body>
    <audio id="myAudio">
        <source src="{{ asset('sound/cute_notification.mp3') }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    <div class="container-fluid">
        <!-- content header -->
        <div class="row">

            <div class="col-md-6">
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-1">
                                <div class="rank-1">
                                    <h3 class="number">
                                        1
                                    </h3>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="people-of-rank">
                                    <h3>
                                        Yusron Laksono
                                        <span class="project-name">- Perpustakaan</span>
                                    </h3>
                                </div>
                                <div class="description">
                                    Mengerjakan 10 list hari ini!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-1">
                                <div class="rank-2">
                                    <h3 class="number">
                                        2
                                    </h3>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="people-of-rank">
                                    <h3>
                                        Yusron Laksono
                                        <span class="project-name">- Perpustakaan</span>
                                    </h3>
                                </div>
                                <div class="description">
                                    Mengerjakan 10 list hari ini!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-1">
                                <div class="rank-3">
                                    <h3 class="number">
                                        3
                                    </h3>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="people-of-rank">
                                    <h3>
                                        Yusron Laksono
                                        <span class="project-name">- Perpustakaan</span>
                                    </h3>
                                </div>
                                <div class="description">
                                    Mengerjakan 10 list hari ini!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mt-3">
                    <div class="card-header">
                        Project
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="15%">
                                        Nama Project
                                    </th>
                                    <th>
                                        Total Pekerjaan
                                    </th>
                                    <th>
                                        Selesai
                                    </th>
                                    <th>
                                        Programmer
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <span class="job-title">
                                            <b class="bg-green">Perpustakaan</b>
                                        </span>
                                    </td>
                                    <td>
                                        30
                                    </td>
                                    <td>
                                        10
                                    </td>
                                    <td>
                                        Yusron Laksono
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- list job -->
        <div class="row content-task">
            {!! $html !!}
        </div>
    </div>
</body>
    <script src="{{ asset('js/jquery-3.6.1.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ url('js/app.js') }}"></script>
    <!-- Pusher -->
    <script>
        $(function(){
            const Echo    = window.Echo;

            var sound = document.getElementById("myAudio"); 
            let channel = Echo.channel('channel-task');

            channel.listen('TaskEvent', function(data){

                $('.content-task').html('');
                    
                $('.content-task').append(data.task.html_task);
                        
                sound.play(); 
            });

        });
        
    </script>
</html>