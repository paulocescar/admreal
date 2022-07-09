@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
    <h1>Usuários</h1>
@stop

@section('content')
    <div>
        <table id="table" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <td><input type="number" id="id" name="id" class="form-control" placeholder="Código"></td>
                    <td><input type="text" id="nome" name="nome" class="form-control" placeholder="Nome"></td>
                    <td><input type="email" id="email" name="email" class="form-control" placeholder="E-mail"></td>
                    <td><input type="date" id="dateStart" name="dateStart" class="form-control"></td>
                </tr>
                <tr>
                    <th>Código</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    <style>
        .dt-buttons{
            flex-wrap: wrap!important;
        }
        .dt-button{
            color: #fff!important;
            background-color: #6c757d!important;
            border-color: #6c757d!important;
            box-shadow: none!important;
        }
        div.dataTables_wrapper div.dataTables_filter input {
            border-radius: 5px;
        }
    </style>
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <!--botoes-->
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/r-2.3.0/b-colvis-2.2.3/datatables.min.js"></script>
    <!--/botoes-->

    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            var table = $('#table').DataTable({
                dom: 'B<"clear">Qrtlp',
                name: 'primary',
                buttons: true,
                'processing' : true,
                'serverSide' : true,
                'ajax' : {
                    'url' : 'admin/usersData',
                    'type' : 'get'
                },
                "columns": [
                    {data : 'id'},
                    {data : 'name'},
                    {data : 'email'},
                    {data : 'created_at'}
                ]
            })

            // Event listener to the two range filtering inputs to redraw on input
            $('#id').keyup(function () {
                table.columns(0).search( $('#id').val()).draw();
            });
            $('#nome').keyup(function () {
                table.columns(1).search( $('#nome').val()).draw();
            });
            $('#email').keyup(function () {
                table.columns(2).search( $('#email').val()).draw();
            });
            $('#dateStart').on('change',function () {
                table.columns(3).search( $('#dateStart').val()).draw();
            });
        }); 
    </script>
@stop

