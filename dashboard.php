<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    // Si el usuario no ha iniciado sesión, redirige al formulario de inicio de sesión
    header("Location: index.php");
    exit();
}

include_once("Conexion.php");
include_once("funciones.php");

$vuelos = FuncionesBD::obtenerVuelos();

// Manejo de formularios
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['crear'])) {
        // Procesar formulario de creación
        $datos = array(
            'numero_vuelo' => isset($_POST['numero_vuelo']) ? $_POST['numero_vuelo'] : '',
            'fecha_vuelo' => isset($_POST['fecha_vuelo']) ? date('Y-m-d', strtotime($_POST['fecha_vuelo'])) : '',
            'empresa' => isset($_POST['empresa']) ? $_POST['empresa'] : '',
            'h_salida' => isset($_POST['h_salida']) ? $_POST['h_salida'] : '',
            'h_llegada' => isset($_POST['h_llegada']) ? $_POST['h_llegada'] : '',
            'aeropuerto_salida' => isset($_POST['aeropuerto_salida']) ? $_POST['aeropuerto_salida'] : '',
            'aeropuerto_llegada' => isset($_POST['aeropuerto_llegada']) ? $_POST['aeropuerto_llegada'] : '',
        );
        FuncionesBD::crearVuelo($datos);
        header("Location: dashboard.php");
        exit();
    } elseif (isset($_POST['actualizar'])) {
        // Procesar formulario de actualización
        $id = $_POST['id_actualizar'];
        $datos = array(
            'numero_vuelo' => $_POST['numero_vuelo'],
            'fecha_vuelo' => $_POST['fecha_vuelo'],
            'empresa' => $_POST['empresa'],
            'h_salida' => $_POST['h_salida'],
            'h_llegada' => $_POST['h_llegada'],
            'aeropuerto_salida' => $_POST['aeropuerto_salida'],
            'aeropuerto_llegada' => $_POST['aeropuerto_llegada']
        );
        FuncionesBD::actualizarVuelo($id, $datos);
        header("Location: dashboard.php");
        exit();
    } elseif (isset($_POST['eliminar'])) {
        // Procesar formulario de eliminación
        $id = $_POST['id_eliminar'];
        FuncionesBD::eliminarVuelo($id);
        header("Location: dashboard.php");
        exit();
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> -->
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>


    <!-- para exportar documentos -->
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" rel="stylesheet" />



</head>

<body>




    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">Prueba Técnica</a>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="#"> <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
            </ul>
            <form action="index.php" method="post">
                <button type="submit" name="cerrar_sesion" class="btn btn-outline-danger">Cerrar sesión</button>
            </form>
        </div>
    </nav>

    <div class="container mt-5">

        <div class="alert alert-dark" role="alert">
            <h4>Bienvenido, <?php echo $_SESSION['usuario']; ?>! Perfil de usuario : <?php echo $_SESSION['rol']; ?></p>
            </h4>

        </div>

        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#crearModal">
            Crear Vuelo
        </button>
        <br>
        <!-- Contenido del panel de control -->

        <h2 class="mt-4">Información de Vuelos</h2>
        <table class="table table-striped table-bordered" id="mtable">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Número de Vuelo</th>
                    <th scope="col">Fecha de Vuelo</th>
                    <th scope="col">Empresa</th>
                    <th scope="col">Hora de Salida</th>
                    <th scope="col">Hora de Llegada</th>
                    <th scope="col">Aeropuerto de Salida</th>
                    <th scope="col">Aeropuerto de Llegada</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vuelos as $vuelo) : ?>
                    <tr>
                        <td><?php echo $vuelo['numero_vuelo']; ?></td>
                        <td><?php echo $vuelo['fecha_vuelo']; ?></td>
                        <td><?php echo $vuelo['empresa']; ?></td>
                        <td><?php echo $vuelo['h_salida']; ?></td>
                        <td><?php echo $vuelo['h_llegada']; ?></td>
                        <td><?php echo $vuelo['aeropuerto_salida']; ?></td>
                        <td><?php echo $vuelo['aeropuerto_llegada']; ?></td>
                        <td>
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <input type="hidden" name="id_eliminar" value="<?php echo $vuelo['id']; ?>">
                                <button type="submit" name="eliminar" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary editar-btn" data-toggle="modal" data-target="#editarModal<?php echo $vuelo['id']; ?>" data-id="<?php echo $vuelo['id']; ?>">
                                Editar
                            </button>
                        </td>
                    </tr>
                    <!-- EDITAR VUELO -->
                    <div class="modal fade" id="editarModal<?php echo $vuelo['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editarModalLabel">Editar Vuelo</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Formulario de edición -->
                                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <input type="hidden" name="id_actualizar" value="<?php echo $vuelo['id']; ?>">

                                        <label for="numero_vuelo">Número de Vuelo:</label>
                                        <input type="text" name="numero_vuelo" value="<?php echo isset($vuelo['numero_vuelo']) ? $vuelo['numero_vuelo'] : ''; ?>" required>

                                        <label for="fecha_vuelo">Fecha de Vuelo:</label>
                                        <input type="text" name="fecha_vuelo" value="<?php echo isset($vuelo['fecha_vuelo']) ? $vuelo['fecha_vuelo'] : ''; ?>" required>

                                        <label for="empresa">Empresa:</label>
                                        <input type="text" name="empresa" value="<?php echo isset($vuelo['empresa']) ? $vuelo['empresa'] : ''; ?>" required>

                                        <label for="h_salida">Hora de Salida:</label>
                                        <input type="time" name="h_salida" value="<?php echo isset($vuelo['h_salida']) ? $vuelo['h_salida'] : ''; ?>" required>

                                        <label for="h_llegada">Hora de Llegada:</label>
                                        <input type="time" name="h_llegada" value="<?php echo isset($vuelo['h_llegada']) ? $vuelo['h_llegada'] : ''; ?>" required>

                                        <label for="aeropuerto_salida">Aeropuerto de Salida:</label>
                                        <input type="text" name="aeropuerto_salida" value="<?php echo isset($vuelo['aeropuerto_salida']) ? $vuelo['aeropuerto_salida'] : ''; ?>" required>

                                        <label for="aeropuerto_llegada">Aeropuerto de Llegada:</label>
                                        <input type="text" name="aeropuerto_llegada" value="<?php echo isset($vuelo['aeropuerto_llegada']) ? $vuelo['aeropuerto_llegada'] : ''; ?>" required>

                                        <button type="submit" name="actualizar" class="btn btn-primary">Guardar Cambios</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>



</body>

</html>









<!-- CREAR VUELO-->
<div class="modal fade" id="crearModal" tabindex="-1" role="dialog" aria-labelledby="crearModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearModalLabel">Crear Vuelo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario para Crear Vuelo -->
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="form-group">
                        <label for="numero_vuelo">Número de Vuelo:</label>
                        <input type="text" class="form-control" name="numero_vuelo" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_vuelo">Fecha de Vuelo:</label>
                        <input type="date" class="form-control" name="fecha_vuelo" required>
                    </div>
                    <!-- Agrega los campos adicionales aquí -->
                    <div class="form-group">
                        <label for="empresa">Empresa:</label>
                        <input type="text" class="form-control" name="empresa" required>
                    </div>
                    <div class="form-group">
                        <label for="h_salida">Hora de Salida:</label>
                        <input type="time" class="form-control" name="h_salida" required>
                    </div>
                    <div class="form-group">
                        <label for="h_llegada">Hora de Llegada:</label>
                        <input type="time" class="form-control" name="h_llegada" required>
                    </div>
                    <div class="form-group">
                        <label for="aeropuerto_salida">Aeropuerto de Salida:</label>
                        <input type="text" class="form-control" name="aeropuerto_salida" required>
                    </div>
                    <div class="form-group">
                        <label for="aeropuerto_llegada">Aeropuerto de Llegada:</label>
                        <input type="text" class="form-control" name="aeropuerto_llegada" required>
                    </div>
                    <button type="submit" name="crear" class="btn btn-primary">Crear Vuelo</button>
                </form>

            </div>
        </div>
    </div>
</div>




<script>
    $(document).ready(function() {
        $('.editar-btn').click(function() {
            var vueloId = $(this).data('id');
            $('#editarModal' + vueloId).modal('show');
        });
    });
</script>



<!-- Inicio DataTable -->
<script type="text/javascript">
    $(document).ready(function() {
        var lenguaje = $('#mtable').DataTable({
            info: false,
            select: true,
            destroy: true,
            jQueryUI: true,
            paginate: true,
            iDisplayLength: 30,
            searching: true,
            dom: 'Bfrtip',
            buttons: [
                'excel'
                // 'copy', 'csv', 'excel'
            ],
            language: {
                lengthMenu: 'Mostrar _MENU_ registros por página.',
                zeroRecords: 'Lo sentimos. No se encontraron registros.',
                info: 'Mostrando: _START_ de _END_ - Total registros: _TOTAL_',
                infoEmpty: 'No hay registros aún.',
                infoFiltered: '(filtrados de un total de _MAX_ registros)',
                search: 'Búsqueda',
                LoadingRecords: 'Cargando ...',
                Processing: 'Procesando...',
                SearchPlaceholder: 'Comience a teclear...',
                paginate: {
                    previous: 'Anterior',
                    next: 'Siguiente',
                }
            }
        });
    });
</script>
<!-- Fin DataTable -->



<!-- Modifica tu script JavaScript -->
<script>
    $(document).ready(function() {
        $('.editar-btn').click(function() {
            var vueloId = $(this).data('id');

            // Abre la ventana de confirmación SweetAlert2
            Swal.fire({
                title: "¿Desea guardar los cambios?",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Guardar",
                denyButtonText: "No guardar"
            }).then((result) => {
                /* Lee más sobre isConfirmed, isDenied a continuación */
                if (result.isConfirmed) {
                    // Si el usuario confirma, muestra el modal de edición
                    $('#editarModal' + vueloId).modal('show');
                } else if (result.isDenied) {
                    // Si el usuario no confirma, muestra un mensaje informativo
                    Swal.fire("Cambios no guardados", "", "info");
                }
            });
        });
    });
</script>