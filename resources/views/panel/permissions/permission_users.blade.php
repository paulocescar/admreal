@extends('adminlte::page')

@section('title', 'Permissões de usuários')

@section('content_header')
    <h1>Permissões de usuários</h1>
@stop

@section('content')
    @permission('view-user-permissions')
    <a href="#create" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#create" style="z-index: 2!important; position: relative; cursor:pointer; float:right;"><i class="fa fa-plus"></i></a>
    <div class="modal fade" id="create" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header-custom">
                <h5 class="modal-title">Deseja adicionar?</h5>
                <span>preencha todos os campos para adicionar.</span><br>
                <span>todos os campos com * são obrigatórios.</span>
                <hr>
            </div>
            <form action="{{route('permission_users.store')}}" method="POST">
            <div class="container">
                @CSRF
                <div class="form-group">
                    <label for="nome">Usuário*</label>
                    <select class="form-control js-example-basic-single" style="width: 100%!important;" name="usuario_id" required>
                        <option value="">Escolha</option>
                        @foreach($users as $user)
                                <option value="{{$user->usuario_id}}">{{$user->usuario_id}} - {{$user->usuario_login}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="nome">Permissão*</label>
                    <select class="form-control js-example-basic-single" style="width: 100%!important;" name="permission_id">
                        <option value="">Escolha</option>
                        @foreach($permissions as $permission)
                            <option value="{{$permission->id}}">{{$permission->id}} - {{$permission->description}}</option>
                        @endforeach
                    </select>
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
    <div>
        <table id="table" class="table table-striped table-bordered" style="width:100%; z-index: 1;">
            <thead>
                <tr>
                    <td>
                        <select class="form-control js-example-basic-single" id="user_id_s">
                            <option value="">Escolha</option>
                            @foreach($users as $user)
                                <option value="{{$user->usuario_id}}">{{$user->usuario_id}} - {{$user->usuario_login}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td> 
                        <select class="form-control js-example-basic-single" id="permission_id_s">
                            <option value="">Escolha</option>
                            @foreach($permissions as $permission)
                                <option value="{{$permission->id}}">{{$permission->id}} - {{$permission->description}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Usuário</th>
                    <th>Permissão</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        
    </div>
    <div class="modal fade" id="edit" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deseja alterar?</h5>
                </div>
                <form action="" id="action_edit" method="post">
                <div class="container">
                    @CSRF
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="user_id_old" id="user_id_old" value="">
                    <input type="hidden" name="permission_id_old" id="permission_id_old" value="">

                    <div class="form-group">
                        <label for"nome">Usuário</label> 
                        <select class="form-control js-example-basic-single" id="user_id_edit"  name="user_id" required style="width: 100%!important;">
                            @foreach($users as $user)
                                <option value="{{$user->usuario_id}}">{{$user->usuario_id}} - {{$user->usuario_login}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for"nome">Permissão</label>
                        <select class="form-control js-example-basic-single" id="permission_id_edit" name="permission_id" required style="width: 100%!important;">
                            @foreach($permissions as $permission)
                                <option value="{{$permission->id}}">{{$permission->id}} - {{$permission->description}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Alterar</button>
                        
                </form>
            
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <!--botoes
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/r-2.3.0/b-colvis-2.2.3/datatables.min.js"></script>
    botoes-->

    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript">

        function setEditFields(user_id, permission_id){
            
            $('#user_id_old').val(user_id);
            $('#permission_id_old').val(permission_id);

            $(`#user_id_edit option:eq(${user_id})`).prop('selected',true);
            $(`#permission_id_edit option:eq(${(Number(permission_id) - 1)})`).prop('selected',true);
            $('#action_edit').attr('action','/admin/permission_users/'+permission_id)
        }
        $(document).ready(function () {
            $('.js-example-basic-single').select2();
            var table = $('#table').DataTable({
                dom: 'B<"clear">Qrtlp',
                name: 'primary',
                buttons: true,
                'processing' : true,
                'serverSide' : true,
                'ajax' : {
                    'url' : '/admin/permission_users/data',
                    'type' : 'get'
                },
                "columns": [
                    {data : 'usuario_id'},
                    {data : 'permission_id'},
                    {data : 'action'}
                ]
            })

            // Event listener to the two range filtering inputs to redraw on input
            $('#user_id_s').on('change',function () {
                table.columns(0).search( $('#user_id_s').val()).draw();
            });
            $('#permission_id_s').on('change',function () {
                table.columns(1).search( $('#permission_id_s').val()).draw();
            });
        }); 
    </script>
@stop

