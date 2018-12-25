<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel - File Upload Extension Problem</title>

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
            .justify-content-center{
                margin:0 auto;
                text-align: center;
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
            .message-section{
                margin: 10px;
            }
            .custom-file-error-msg {
                color: #ff0000;
                font-weight: 600;
            }
            .custom-file-success-msg {
                color: #2fc712;
                font-weight: 600;
            }
        </style>
    </head>
    <body>

        <div class="flex-center position-ref full-height">
            <div class="container custom-upload-file">
                <h3>Laravel File Upload Extension Blank Problem Solution</h3>
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
                        <div class="message-section">
                            @if(\Session::has('error'))
                                <label class="custom-file-error-msg">{!! \Session::get('error') !!}</label>
                            @endif
                            @if(\Session::has('success'))
                                <label class="custom-file-success-msg">{!! \Session::get('success') !!}</label>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </body>
</html>
