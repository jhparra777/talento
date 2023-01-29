<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <title>Administrador - </title><!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://code.jquery.com/jquery-1.12.0.js" type="text/javascript"></script>
        <script src="{{url("js/bootstrap-switch.min.js")}}" type="text/javascript"></script>
        <link href="{{ asset("css/bootstrap-switch.min.css")}}" rel="stylesheet" type="text/css"/>
        <link href="{{ url("css/jquery-ui.css") }}" rel="stylesheet">
        <script type="text/javascript" src="{{ url("js/jquery-ui.js") }}" ></script>
        <script src="{{asset("js/chosen.jquery.js")}}"></script>
        <link href="{{asset("css/chosen.css")}}" type="text/css" rel="stylesheet">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link href="{{url("css/estilo_admin.css")}}" type="text/css" rel="stylesheet">
        <link href="{{url("css/jquery-te-1.4.0.css")}}" type="text/css" rel="stylesheet">
        <script src="{{asset("js/jQuery-Autocomplete-master/src/jquery.autocomplete.js")}}"></script>

        <script src="{{asset("js/admin_functions.js")}}"></script>
        <script src="{{asset("js/jquery-te-1.4.0.min.js")}}"></script>
        <script src="{{asset("js/jQuery-Autocomplete-master/src/jquery.autocomplete.js")}}"></script>
        <meta name="token" content="{{ csrf_token() }}"/>
        <script src="{{asset("js/timepicker/jquery-ui-timepicker-addon.min.js")}}" type="text/javascript"></script>
        <link href="{{asset("js/timepicker/jquery-ui-timepicker-addon.min.css")}}" rel="stylesheet" type="text/css"/>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </head>
    <script>
$(function () {
    $.ajaxSetup({
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
        }
    });

});
    </script>
    <body>
        <?php
        $user = Sentinel::getUser();        
        ?>
        <header>
            <div class="container-logo-login">
                <div class="container">
                    <img class=""  src="{{url('img/Logo_Enlace.svg')}}" style="width: 300px;margin: 10px auto"/>
                </div>
                    
            </div>
        </header>
        <div class="fondo">
        <div class="container ">
            
            @yield("content")
        </div>
        </div>
        <footer class="footer" >
            @include('footer_all')
        </footer>
        <div class="modal fade" id="modal_peq" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div class="modal fade" id="modal_gr" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div class="modal" id="modal_success">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header alert-info">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title"><span class="fa fa-check-circle "></span> Confirmación</h4>
                    </div>
                    <div class="modal-body" id="texto">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </body>
</html>
