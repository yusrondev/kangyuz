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

    body{
        background-color: #2d3436
    }

    .images {
        width: 50%;
        /* height: 50%; */
    }

    .center {
        text-align: center !important;
    }

    .nameof {
        font-weight: bold;
        font-size: 30px
    }

    .count-task {
        text-align: center !important;
        font-size: 70px;
        background-color: #dfe4ea;
        color: #2f3542;
        font-weight: bolder
    }
    .count-task-medium {
        text-align: center !important;
        font-size: 70px;
        background-color: #ffa502;
        color: #ffffff;
        font-weight: bolder
    }
    .count-task-danger {
        text-align: center !important;
        font-size: 70px;
        background-color: #eb3b5a;
        color: #ffffff;
        font-weight: bolder
    }

    .job-title {
        color: #00aa5b;
        font-size: 20px;
        margin-top: -10px;
        text-align: center !important;
        margin-bottom: 20px;
    }

    .bg-green {
        background-color: #c9fde0;
        padding: 3px;
        border-radius: 5px;
    }

    .rank-1 {
        background-color: #f6b93b;
        padding: 0px;
        border-radius: 6px;
    }

    .rank-2 {
        background-color: #45aaf2;
        padding: 0px;
        border-radius: 6px;
    }

    .rank-3 {
        background-color: #a55eea;
        padding: 0px;
        border-radius: 6px;
    }

    .number {
        font-size: 50px;
        text-align: center !important;
        font-weight: bolder;
        color: white;
    }

    .description {
        margin-top: -10px;
        color: #4b6584
    }

    .project-name {
        font-weight: 100;
    }

    .project-name-blue {
        background-color: #dfe6e9;
        padding: 3px;
        color: #2f3542;
        border-radius: 4px;
        padding-left: 10px;
        padding-right: 10px;
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
            <div class="col-md-6 content-score-task">
                @if (count($html_score_task) <= 0)
                    <div class="mt-3">
                        <div class="alert alert-info">
                            <center>
                                <h3>Belum ada ranking hari ini</h3>
                            </center>
                        </div>
                    </div>
                @endif
                @foreach ($html_score_task as $key => $item)
                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="rank-{{ ($key + 1) }}">
                                        <h3 class="number">
                                            {{ ($key + 1) }}
                                        </h3>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="people-of-rank">
                                        <h3>
                                            {{ $item['name'] }}
                                            <span class="project-name">- {{ $item['project_name'] }}</span>
                                        </h3>
                                    </div>
                                    <div class="description">
                                        Mengerjakan {{ $item['count_task'] }} list hari ini!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-md-6">
                <div class="mt-3">
                    <div class="card pb-0">
                        <div class="card-body p-2 pb-0">
                            <div class="table-responsive" style="overflow: hidden;">
                                <table class="align-middle table table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th style="text-align: center" width="25%">
                                                Nama Project
                                            </th>
                                            <th style="text-align: center">
                                                Total Pekerjaan
                                            </th>
                                            <th style="text-align: center">
                                                Selesai
                                            </th>
                                            <th style="text-align: center">
                                                Programmer
                                            </th>
                                        </tr>
                                    </thead>
                                    
                                </table>
                                <div style="margin-top: -15px;max-height:166px">
                                    <marquee style="max-height: 166px" Vspace="1" scrollmount="900" direction="up" scrolldelay="120" behavior="" class="tbody-list-project">
                                        @foreach ($html_project as $item)
                                            <div class="row mb-1" style="background-color: #f5f5f5;padding:5px">
                                                <div class="col-md-3">
                                                    <span class="job-title">
                                                        <b class="bg-green">
                                                            {{ $item['project_name'] }}
                                                        </b>
                                                    </span>
                                                </div>
                                                <div class="col-md-3" style="font-weight: bolder;text-align:center">{{ $item['all_task'] }}</div>
                                                <div class="col-md-3" style="font-weight: bolder;text-align:center">{{ $item['finished_task'] }}</div>
                                                <div class="col-md-3" style="font-weight: bolder;text-align:center">{{ $item['name'] }}</div>
                                            </div>
                                        @endforeach
                                    </marquee>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <br>

        <!-- list job -->
        <div class="row content-task">

                @foreach ($html_task as $data)

                <div class='col-md-3 p-3'>
                    <div class='card'>
                        <div class='card-body'>
                            <div class='profile-header'>
                                <div class='row'>
                                    <p class='center nameof'>
                                        {{ ucfirst($data['name']) }}
                                    </p>
                                    <span class='job-title'>
                                        <b class='bg-green'>{{ ucfirst($data['project_name']) }}</b>
                                    </span>
                                </div>
                            </div>
                            <div class='{{ $data['class_count'] }}'>
                                {{ $data['count'] }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
<script src="{{ asset('js/jquery-3.6.1.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ url('js/app.js') }}"></script>
<!-- Pusher -->
<script>

    $(function() {
        const Echo = window.Echo;

        var sound = document.getElementById("myAudio");
        let channel = Echo.channel('channel-task');

        channel.listen('TaskEvent', function(data) {

            var url = $(location).attr('href'),
            parts = url.split("/"),
            last_part = parts[parts.length-1];

            if(last_part == data.task.html_task[0].key){
                
                $('.content-task').html('');
                $('.content-score-task').html('');
                $('.tbody-list-project').html('');

                var html_task   = "";
                var class_count = "";
                $.each(data.task.html_task, function(key, value) {

                    html_task += `<div class='col-md-3 p-3'>
                                        <div class='card push-notif-${value.user_id}'>
                                            <div class='card-body'>
                                                <div class='profile-header'>
                                                    <div class='row'>
                                                        <p class='center nameof'>
                                                            ${capitalizeFirstLetter(value.name)}
                                                        </p>
                                                        <span class='job-title'>
                                                            <b class='bg-green'>${capitalizeFirstLetter(value.project_name)}</b>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class='${value.class_count}'>
                                                    ${value.count}
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
                });

                var list_project = "";

                $.each(data.task.html_project, function(key, value) {

                    list_project += `<div class="row mb-1 push-notif-${value.user_id}" style="background-color: #f5f5f5;padding:5px">
                                        <div class="col-md-3">
                                            <span class="job-title">
                                                <b class="bg-green">
                                                    ${value.project_name}
                                                </b>
                                            </span>
                                        </div>
                                        <div class="col-md-3" style="font-weight: bolder;text-align:center">${value.all_task}</div>
                                        <div class="col-md-3" style="font-weight: bolder;text-align:center">${value.finished_task}</div>
                                        <div class="col-md-3" style="font-weight: bolder;text-align:center">${value.name}</div>
                                    </div>`;
                });

                var score_task = "";

                var count_project = data.task.html_score_task;

                if (count_project.length == 0) {
                    score_task = `<div class="mt-3">
                                    <div class="alert alert-info">
                                        <center>
                                            <h3>Belum ada ranking hari ini</h3>
                                        </center>
                                    </div>
                                </div>`;
                }

                $.each(data.task.html_score_task, function(key, value) {

                    score_task += `<div class="card mt-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <div class="rank-${key + 1}">
                                                    <h3 class="number">
                                                        ${key + 1}
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="people-of-rank">
                                                    <h3>
                                                        ${value.name}
                                                        <span class="project-name">- ${value.project_name}</span>
                                                    </h3>
                                                </div>
                                                <div class="description">
                                                    Mengerjakan ${value.count_task} list hari ini!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                });
                
                $('.content-task').append(html_task);
                $('.content-score-task').html(score_task);
                $('.tbody-list-project').append(list_project);

                sound.play();

                var class_blink = data.task.push_notif.user_id;
        
                for (let index = 0; index < 8; index++) {
                    
                    $(".push-notif-"+class_blink).fadeOut(300);
                    $(".push-notif-"+class_blink).fadeIn(300);
                    
                }
            }   
        });

        function capitalizeFirstLetter(string) {
         return string.charAt(0).toUpperCase() + string.slice(1);
        }


    });
</script>

</html>
