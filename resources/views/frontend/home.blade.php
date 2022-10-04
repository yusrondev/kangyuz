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
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="25%">
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
                                <tbody class="marquee tbody-list-project">
                                    @foreach ($html_project as $item)
                                        <tr>
                                            <td>
                                                <b class="project-name-blue">
                                                    {{ $item['project_name'] }}
                                                </b>
                                            </td>
                                            <td>
                                                {{ $item['all_task'] }}
                                            </td>
                                            <td>
                                                {{ $item['finished_task'] }}
                                            </td>
                                            <td>
                                                {{ $item['name'] }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- list job -->
        <div class="row content-task">

                @foreach ($html_task as $data)

                <div class='col-md-3 p-3'>
                    <div class='card'>
                        <div class='card-body'>
                            <div class='profile-header'>
                                <div class='row'>
                                    <p class='center nameof'>
                                        {{ $data['name'] }}
                                    </p>
                                    <span class='job-title'>
                                        <b class='bg-green'>{{ $data['project_name'] }}</b>
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

            console.log(data);
            
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
                                                        ${value.name}
                                                    </p>
                                                    <span class='job-title'>
                                                        <b class='bg-green'>${value.project_name}</b>
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

                list_project += `<tr class="push-notif-${value.user_id}">
                                        <td>
                                            <b class="project-name-blue">${value.project_name}</b>
                                        </td>
                                        <td>
                                            ${value.all_task}
                                        </td>
                                        <td>
                                            ${value.finished_task}
                                        </td>
                                        <td>
                                            ${value.name}
                                        </td>
                                    </tr>`;
            });

            var score_task = "";
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
    
            for (let index = 0; index < 6; index++) {
                
                $(".push-notif-"+class_blink).fadeOut(300);
                $(".push-notif-"+class_blink).fadeIn(300);
                
            }
        });

    });
</script>

</html>
