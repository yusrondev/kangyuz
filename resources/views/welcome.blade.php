<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body>
    <div class="container">
        <div class="row mt-3">
            <div class="col-6 offset-3">
                <div class="card">
                    <div class="card-header">
                        Lorems
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" id="name">
                        </div>
                        <div class="form-group" id="data-message">

                        </div>
                        <div class="form-group">
                            <textarea name="" id="message" cols="30" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-block btn-primary">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ url('js/app.js') }}"></script>
    <script>
        $(function(){
            const Http    = window.axios;
            const Echo    = window.Echo;
            const name    = $('#name');
            const message = $('#message');

            $("input, textarea").keyup(function(){
                $(this).removeClass('is-invalid');
            });

            $('button').click(function(){
                if (name.val() == '') {
                    name.addClass('is-invalid');
                }else if(message.val() == ''){
                    message.addClass('is-invalid');
                }else{
                    Http.post("{{ url('send') }}", {
                        'name'   : name.val(),
                        'message': message.val(),
                    }).then(()=>{
                        message.val('');
                    });
                }
            });

            let channel = Echo.channel('channel-chat');
            channel.listen('ChatEvent', function(data){
                $('#data-message').append(`<strong>${data.message.name}</strong> : ${data.message.message} <br>`);
            });

        });
        
    </script>
</html>