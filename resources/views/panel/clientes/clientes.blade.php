@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
    <h1>Clientes</h1>
@stop

@section('content')
    @permission('view-clients')
    @include('modalok')
    <a href="#create" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#create" style="z-index: 2!important; position: relative; cursor:pointer; float:right;"><i class="fa fa-plus"></i></a>
    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header-custom">
                <h5 class="modal-title">Deseja adicionar?</h5>
                <span>preencha todos os campos para adicionar.</span><br>
                <span>todos os campos com * são obrigatórios.</span>
                <hr>
            </div>
            <form action="{{route('clients.store')}}" method="POST">
            <div class="container">
                @CSRF
                <div class="form-group">
                    <label for"nome">Nome</label>
                    <input type="text" class="form-control" name="cliente_nome" value="" required>
                </div>

                <div class="form-group">
                    <label for"nome">CNPJ</label>
                    <input type="text" class="form-control" name="cliente_cnpj" value="" required>
                </div>
                <div class="form-group">
                    <label for"nome">Comissao</label>
                    <input type="number" step="0.1" class="form-control" name="cliente_comissao" value="" required>
                </div>

            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Adicionar</button>
                    
            </form>
        
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
        </div>
    </div>
    <div class="table-responsive">
        <table id="table" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <td><input type="number" id="id" name="id" class="form-control" placeholder="Código"></td>
                    <td><input type="text" id="nome" name="nome" class="form-control" placeholder="Nome"></td>
                    <td><input type="text" id="cnpj" name="cnpj" class="form-control" placeholder="CNPJ"></td>
                    <td><input type="number" step="0.1" id="comissao" name="comissao" class="form-control" placeholder="Comissao"></td>
                    <td><input type="date" id="dateStart" name="dateStart" class="form-control"></td>
                </tr>
                <tr>
                    <th>Código</th>
                    <th>Nome</th>
                    <th>CNPJ</th>
                    <th>Comissão</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    @else
        <div>
           <p> Você não possui permissão para ver este conteúdo.</p>
           <a class="btn btn-default" href="/home"><i class="fa fa-arrow-left"></i> Voltar</a>
        </div>
    @endpermission
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
    
    @if(\Session::has('success'))
        <script>$('#btnSucess').click();</script>
    @endif
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <!--botoes-
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/r-2.3.0/b-colvis-2.2.3/datatables.min.js"></script>
    botoes-->

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
                    'url' : '/admin/clients/data',
                    'type' : 'get'
                },
                "columns": [
                    {data : 'cliente_id'},
                    {data : 'cliente_nome'},
                    {data : 'cliente_cnpj'},
                    {data : 'cliente_comissao'},
                    {data : 'd_ins'},
                    {data : 'action'}
                ]
            })

            // Event listener to the two range filtering inputs to redraw on input
            $('#id').keyup(function () {
                table.columns(0).search( $('#id').val()).draw();
            });
            $('#nome').keyup(function () {
                table.columns(1).search( $('#nome').val()).draw();
            });
            $('#cnpj').keyup(function () {
                table.columns(2).search( $('#cnpj').val()).draw();
            });
            $('#comissao').keyup(function () {
                table.columns(3).search( $('#comissao').val()).draw();
            });
            $('#dateStart').on('change',function () {
                table.columns(4).search( $('#dateStart').val()).draw();
            });
        }); 
    </script>
@stop

