<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/app.css') }}">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .custom-upload-file {
                border: 2px solid #4d6df5;
                border-radius: 5px;
                padding: 50px;
                margin-top: -150px;
            }
            .file-input-control {
                padding: 10px;
                border: 1px solid #d2d2d2;
                border-radius: 5px;
            }
            .file-button-section {
                text-align: center;
                padding: 10px;
                margin: 20px 10px -10px 10px;
            }
            .file-button-class {
                padding: 15px 40px;
                color: #fff;
                text-align: center;
                font-size: 14px;
                background: #4d6df5;
                border-radius: 6px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            {{-- <div class="content">
                <h2>Upload your file here</h2>
                <form class="form-horizontal" name="file_upload_form" method="POST" action="{{ url('file-upload') }}" enctype="multipart/form-data">
                    @csrf
                    <input class="form-control" type="file" name="file" id="file" required>
                    <button class="btn btn-default" type="submit">Upload</button>
                </form>
            </div> --}}
            <div class="container custom-upload-file">
                <div class="row justify-content-center">
                        <h2>Upload your file here</h2>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header"></div>
                            <div class="card-body">
                                <form class="form-horizontal" name="file_upload_form" method="POST" action="{{ url('file-upload') }}" enctype="multipart/form-data">
                                @csrf

                                    <div class="form-group row">
                                        <input class="form-control file-input-control" type="file" name="file" id="file" required>
                                    </div>
                                    <div class="form-group row file-button-section">
                                        <button class="btn btn-default file-button-class" type="submit">Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <script type="text/javascript">
            @if(\Session::has('error'))
                alert('{!! \Session::get('error') !!}');
            @endif
            @if(\Session::has('success'))
                alert('{!! \Session::get('success') !!}');
            @endif
        </script>
    </body>
</html>
