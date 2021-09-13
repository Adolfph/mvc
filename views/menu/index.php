<?php
/**
 *
 * @author Adolfo Jiménez <isc.adolfojimenez@gmail.com>
 * @date 11 sep. 2021
 * @time 16:36:59
 */

$menus = $this->d['all'];
$padres = $this->d['ordered'];

?>

<html>
    <head>
        <title>Menús</title>
        <?php require 'views/header.php'; ?>

    </head>
    <body>
        <div class="container">
            <div class="w-auto p-3">
                <?php $this->showMessages();?>
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <h5 class="d-inline">Menu</h5>
                            <button type="button" id="show_modal" class="d-inline ml-auto p-2 btn btn-success" data-toggle="modal" data-target="#exampleModal">
                                <i class="fas fa-plus"></i> Nuevo
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-sm table-bordered">
                            <thead>
                                <tr class="table-info">
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Menu padre</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($menus as $menu) {
                                ?>
                                <tr>
                                    <th scope="row" id="id_menu"><?= $menu->getId(); ?></th>
                                    <td><?= $menu->getNombre(); ?></td>
                                    <td><?= $menu->getNombre_menu_padre(); ?></td>
                                    <td><?= $menu->getDescripcion(); ?></td>
                                    <td class="text-center">
                                        <button class="btn-secondary" id="editar" onclick="editar(<?= $menu->getId(); ?>);"><i class="fas fa-edit"></i> Editar</button>
                                        <button class="btn-danger" id="eliminar" onclick="eliminar(<?= $menu->getId(); ?>);"><i class="fas fa-trash"></i> Eliminar</button>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="exampleModal"class="modal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card">
                                <h5 class="card-header">Formulario</h5>
                            </div>
                            <div class="card-body">
                                <form id="form_menu" name="form_menu" action="menu/crear" method="post">
                                    <div class="form-group row">
                                        <input type="hidden" id="id" name="id" value=""/>
                                        <label for="id_menu_padre" class="col-sm-2 col-form-label">Menú padre</label>
                                        <div class="col-sm-10">
                                            <select id="id_menu_padre" name="id_menu_padre" class="form-control input-sm d-inline">
                                                <option value="">Seleccione</option>
                                                <?php
                                                foreach ($padres as $padre) {
                                                    echo '<option value="'.$padre->getId().'">'.$padre->getNombre().'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="nombre" id="nombre" class="form-control input-sm" required="required" autocomplete="off"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="descripcion" class="col-sm-2 col-form-label">Descripción</label>
                                        <div class="col-sm-10">
                                            <textarea id="descripcion" name="descripcion" rows="2" class="form-control" maxlength="255" required=""></textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="cancelar" class="btn btn-secondary ml-2 mr-auto" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="guardar" name="guardar" class="btn btn-primary"><i class="fas fa-save text-white"></i> Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <?php require 'views/footer.php'; ?>
</html>
<script>
    $("#guardar").on('click', function(){
        if(!isRequired('nombre')){
            return false;
        }

        if(!isRequired('descripcion')){
            return false;
        }
        
        if(confirm("¿Desea guardar los datos?")){
            $("#form_menu").submit();
        }
    });

    $("#show_modal").on('click', function(){
        $("#id_menu_padre").val("");
        $("#nombre").val("");
        $("#descripcion").val("");
        $("#form_menu").attr('action', 'menu/crear');
    });

    function editar(id_menu){
        $("#show_modal").click();
        $.post('menu/obtenerMenuJson', {id: id_menu}, function(data){
            if(data.error){
                alert(data.message);
                $("#cancelar").click();
                return;
            }
            $("#id").val(data.id);
            $("#id_menu_padre").val(data.id_menu_padre);
            $("#nombre").val(data.nombre);
            $("#descripcion").val(data.descripcion);
            $("#form_menu").attr('action', 'menu/actualizar');
        }, 'json');
    }

    function eliminar(id_menu){
        $.post('menu/obtenerMenuJson', {id: id_menu}, function(data){
            if(data.childs != null){
                var childs = data.childs;
                if(childs.length >= 1){
                    var message = "Esté menú no se puede eliminar porque tiene las siguientes dependencias:\n";
                    for(i in childs){
                        message += "* "+ childs[i].nombre +"\n";
                    }
                    alert(message);
                }
                return false;
            }

            $("#id").val(data.id);
            $("#id_menu_padre").val(data.id_menu_padre);
            $("#nombre").val(data.nombre);
            $("#descripcion").val(data.descripcion);
            $("#form_menu").attr('action', 'menu/eliminar');
            
            if(confirm("¿Está seguro de eliminar el menú?")){
                $("#form_menu").submit();
            }
        }, 'json');
    }
</script>