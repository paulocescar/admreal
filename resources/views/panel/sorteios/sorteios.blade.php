@extends('adminlte::page')

@section('title', 'Sorteios')

@section('content_header')
    <h1>Sorteios</h1>
@stop

@section('content')
    @permission('view-rooms')
    @include('modalok')
    <a href="#create" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#create" style="z-index: 2!important; position: relative; cursor:pointer; float:right;"><i class="fa fa-plus"></i></a>
    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header-custom">
                <h5 class="modal-title">Deseja adicionar?</h5>
                <span>preencha todos os campos para adicionar.</span><br>
                <span>todos os campos com * são obrigatórios.</span>
                <hr>
            </div>
            <form action="{{route('sweepstakes.store')}}" method="POST">
            <div class="container">
                @CSRF
                <div class="row">
                    <div class="form-group col-3">
                        <label for="nome">Cliente*</label>
                        <select class="form-control js-example-basic-single" style="width: 100%!important;" name="cliente_id" required>
                            <option value="">Escolha</option>
                            @foreach($clientes as $data)
                                    <option value="{{$data->cliente_id}}">{{$data->cliente_id}} - {{$data->cliente_nome}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group col-6">
                        <label for"nome">Numero da sala</label>
                        <select class="form-control js-example-basic-single" style="width: 100%!important;" name="sala_id" required>
                            <option value="">Escolha</option>
                            @foreach($salas as $data)
                                    <option value="{{$data->sala_id}}">{{$data->sala_id}} - {{$data->sala_nome}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-3">
                        <label for"nome">Tipo do sorteio</label>
                        <select class="form-control js-example-basic-single" onChange="giros()" class="form-control" style="width:100%!important;" name="sorteio_tipo" id="sorteio_tipo" required>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="60">60</option>
                            <option value="90">90</option>
                        </select>
                    </div>

                    <div class="form-group col-3">
                        <label for"nome">Nome do sorteio</label>
                        <input type="text" class="form-control" name="sorteio_nome" value="" required>
                    </div>
                    <div class="form-group col-3">
                        <label for"nome">Qtd. de tickets de pré-venda</label>
                        <input type="text" class="form-control" name="sorteio_quantidade_tickets_pre" value="" required>
                    </div>
                    <div class="form-group col-3">
                        <label for"nome">Qtd. de Tickets Livres</label>
                        <input type="text" class="form-control" name="sorteio_quantidade_tickets_livre" value="" required>
                    </div>
                    <div class="form-group col-3">
                        <label for"nome">Qtd. à venda</label>
                        <input type="text" class="form-control" name="sorteio_quantidade_venda" value="" required>
                    </div>
                    <div class="form-group col-3">
                        <label for"nome">Qtd. de numeros</label>
                        <input type="text" class="form-control" name="sorteio_quantidade_numeros" value="" required>
                    </div>
                    <div class="form-group col-3">
                        <label for"nome">Seleção tipo</label>
                        <input type="text" class="form-control" name="sorteio_selecao_tipo" value="" required>
                    </div>
                    <div class="form-group col-3">
                        <label for"nome">Limite de seleção</label>
                        <input type="text" class="form-control" name="sorteio_selecao_limite" value="" required>
                    </div>
                    <div class="form-group col-3">
                        <label for"nome">Qtd. de rodadas</label>
                        <input type="text" class="form-control" name="sorteio_quantidade_rodadas" value="" required>
                    </div>
                    <div class="form-group col-3" id="qtdGiros">
                        <label for"nome">Qtd. de giros</label>
                        <input type="text" class="form-control" name="sorteio_quantidade_giros" value="" required>
                    </div>
                    <div class="form-group col-3">
                        <label for"nome">Forçar seleção</label>
                        <input type="text" class="form-control" name="sorteio_selecao_forcar" value="" required>
                    </div>

                    <!-- <div class="d-none">
                        <div class="form-group">
                            <label for"nome">Data de criação</label>
                            <input type="text" class="form-control" name="sorteio_criacao_data" value="" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Data de liberação do sorteio</label>
                            <input type="text" class="form-control" name="sorteio_liberacao_data" value="" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Data de início do sorteio</label>
                            <input type="text" class="form-control" name="sorteio_inicio_data" value="" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Data de finalização do sorteio</label>
                            <input type="text" class="form-control" name="sorteio_final_data" value="" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Data de previsão</label>
                            <input type="text" class="form-control" name="sorteio_previsao_data" value="" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Preço das cartelas</label>
                            <input type="text" class="form-control" name="sorteio_cartela_preco" value="" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Indice da rodada</label>
                            <input type="text" class="form-control" name="sorteio_indice_rodada" value="" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Indice do giro</label>
                            <input type="text" class="form-control" name="sorteio_indice_giro" value="" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Indetificação do sorteio</label>
                            <input type="text" class="form-control" name="sorteio_identificador" value="" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Orgão de processo</label>
                            <input type="text" class="form-control" name="sorteio_processo_orgao" value="" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Numero do processo</label>
                            <input type="text" class="form-control" name="sorteio_processo_numero" value="" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Valor do prêmio por rodada</label>
                            <input type="text" class="form-control" name="sorteio_premio_rodada_valor" value="" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Nome da rodada</label>
                            <input type="text" class="form-control" name="sorteio_premio_rodada_nome" value="" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Valor do prêmio por giro</label>
                            <input type="text" class="form-control" name="sorteio_premio_giro_valor" value="" required>
                        </div>
                        <div class="form-group">
                            <label for"nome">Nome do giro</label>
                            <input type="text" class="form-control" name="sorteio_premio_giro_nome" value="" required>
                        </div>
                    </div> -->
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
                    <td><select class="form-control js-example-basic-single" style="width: 100%!important;" id="cliente" required>
                            <option value="">Escolha</option>
                            @foreach($clientes as $data)
                                    <option value="{{$data->cliente_id}}">{{$data->cliente_id}} - {{$data->cliente_nome}}</option>
                            @endforeach
                        </select></td>
                    <td><select class="form-control js-example-basic-single" style="width: 100%!important;" id="sala" required>
                        <option value="">Escolha</option>
                        @foreach($salas as $data)
                                <option value="{{$data->sala_id}}">{{$data->sala_id}} - {{$data->sala_nome}}</option>
                        @endforeach
                    </select></td>
                    <td><input type="text" id="nome" name="nome" class="form-control" placeholder="Nome"></td>
                    <td><input type="date" id="dateStart" name="dateStart" class="form-control"></td>
                </tr>
                <tr>
                    <th>Código</th>
                    <th>Cliente</th>
                    <th>Sala</th>
                    <th>Nome</th>
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
        html{
            overflow-x: hidden;
        }
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
        .modal-header-custom{
            padding: 12px;
        }
        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #aaa;
            border-radius: 4px;
            height: 38px!important;
        }
        .select2-container--default .select2-dropdown.select2-dropdown--below {
            border-top: 0;
            z-index: 999999;
        }
    </style>
    </style>
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    
    @if(\Session::has('success'))
        <script>$('#btnSucess').click();</script>
    @endif
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <!--botoes
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/r-2.3.0/b-colvis-2.2.3/datatables.min.js"></script>
    botoes-->

    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script type="text/javascript">
        
        function giros(){
            if($('#sorteio_tipo').val() == 60 || $('#sorteio_tipo').val() == 90) {
                $('#qtdGiros').removeClass('d-none');
            }else{
                $('#qtdGiros').addClass('d-none');
            }
        }

        $(document).ready(function () {
            giros()
            $('.js-example-basic-single').select2();
            var table = $('#table').DataTable({
                dom: 'B<"clear">Qrtlp',
                name: 'primary',
                buttons: true,
                'processing' : true,
                'serverSide' : true,
                'ajax' : {
                    'url' : '/admin/sweepstakes/data',
                    'type' : 'get'
                },
                "columns": [
                    {data : 'sorteio_id'},
                    {data : 'cliente_id'},
                    {data : 'sala_id'},
                    {data : 'sorteio_nome'},
                    {data : 'd_ins'},
                    {data : 'action'}
                ],
                "initComplete": function( settings, json ) {
                    $('.js-example-basic-single').select2();
                }
            })

            // Event listener to the two range filtering inputs to redraw on input
            $('#id').keyup(function () {
                table.columns(0).search( $('#id').val()).draw();
            });
            $('#cliente').on('change',function () {
                table.columns(1).search( $('#cliente').val()).draw();
            });
            $('#sala').keyup(function () {
                table.columns(2).search( $('#sala').val()).draw();
            });
            $('#nome').keyup(function () {
                table.columns(3).search( $('#nome').val()).draw();
            });
            $('#dateStart').on('change',function () {
                table.columns(4).search( $('#dateStart').val()).draw();
            });
        }); 
    </script>
@stop

