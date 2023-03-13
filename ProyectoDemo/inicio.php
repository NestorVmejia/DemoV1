<!DOCTYPE html>
<html lang="en">

<?php
session_start();
include("conexion.php");
$sql = "SELECT * FROM paciente";
if (isset($_POST['buscar'])) {
    $nss = $_POST['nss'];
    $sql = "SELECT*FROM paciente WHERE NSS LIKE '%$nss%'";
}
$query = mysqli_query($con, $sql);
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/378d6c7b46.js" crossorigin="anonymous"></script>
    <title>Demo Inicio</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <img src="IMSS.png" width="100" height="50" alt="Logo">
                <a class="navbar-brand">Bienvenido, Matricula: <?php echo $_SESSION['usuario'] ?></a>
                <span class="navbar-text">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <div class="btn-group dropstart">
                                    <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-bars"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-dark">
                                        <li>
                                            <center><a href="CambiarContraseña.php" class="text-light">Cambiar Contrasña</a></center>
                                        </li>
                                        <br>
                                        <li>
                                            <center><a href="CerrarSesion.php" class="btn btn-outline-danger">Cerrar Sesion</a></center>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </span>
            </div>
        </nav>
    </header>
    <br>
    <main>
        <div class="container py-4 text-center">
            <div class="row g-4">
                <div class="col-auto">
                    <label for="num_registros" class="col-form-label">Mostrar: </label>
                </div>
                <div class="col-auto">
                    <select name="num_registros" id="num_registros" class="form-select">

                        <option value="10">
                            <center>10</center>
                        </option>
                        <option value="25">
                            <center>25</center>
                        </option>
                        <option value="50">
                            <center>50</center>
                        </option>
                        <option value="100">
                            <center>100</center>
                        </option>
                    </select>
                </div>
                <div class="col-auto">
                </div>
                <div class="col-5"></div>
                <div class="col-auto">
                    <label for="campo" class="col-form-label"><i class="fa-solid fa-magnifying-glass"></i>: </label>
                </div>
                <div class="col-auto">
                    <input type="text" name="campo" id="campo" class="form-control">
                </div>
            </div>
            <div class="row py-4">
                <div class="col">
                    <table class="table table-sm table-bordered table-striped">
                        <thead >
                            <tr class="table-dark">
                            <th class="sort asc">NSS</th>
                            <th class="sort asc">Nombre</th>
                            <th class="sort asc">Enfermedad</th>
                            <th class="sort asc">Clinica</th>
                            <th class="sort asc">Consultorio</th>
                            <th class="sort asc">Turno</th>
                            <th class="sort asc">Celular</th>
                            <th class="sort asc">Vigencia</th>
                            <th class="sort asc">Riesgo</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                            </tr>
                        </thead>
                        <!-- El id del cuerpo de la tabla. -->
                        <tbody id="content">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <label id="lbl-total"></label>
                </div>
                <div class="col-6" id="nav-paginacion"></div>
                <input type="hidden" id="pagina" class="btn btn-outline-dark" value="1">
                <input type="hidden" id="orderCol" class="btn btn-outline-dark" value="0">
                <input type="hidden" id="orderType" class="btn btn-outline-dark" value="asc">
            </div>
        </div>
    </main>
    <script>
        /* Llamando a la función getData() */
        getData()
        /* Escuchar un evento keyup en el campo de entrada y luego llamar a la función getData. */
        document.getElementById("campo").addEventListener("keyup", function() {
            getData()
        }, false)
        document.getElementById("num_registros").addEventListener("change", function() {
            getData()
        }, false)
        /* Peticion AJAX */
        function getData() {
            let input = document.getElementById("campo").value
            let num_registros = document.getElementById("num_registros").value
            let content = document.getElementById("content")
            let pagina = document.getElementById("pagina").value
            let orderCol = document.getElementById("orderCol").value
            let orderType = document.getElementById("orderType").value
            if (pagina == null) {
                pagina = 1
            }
            let url = "load.php"
            let formaData = new FormData()
            formaData.append('campo', input)
            formaData.append('registros', num_registros)
            formaData.append('pagina', pagina)
            formaData.append('orderCol', orderCol)
            formaData.append('orderType', orderType)
            fetch(url, {
                    method: "POST",
                    body: formaData
                }).then(response => response.json())
                .then(data => {
                    content.innerHTML = data.data
                    document.getElementById("lbl-total").innerHTML = 'Mostrando ' + data.totalFiltro +
                        ' de ' + data.totalRegistros + ' registros'
                    document.getElementById("nav-paginacion").innerHTML = data.paginacion
                }).catch(err => console.log(err))
        }

        function nextPage(pagina) {
            document.getElementById('pagina').value = pagina
            getData()
        }
        let columns = document.getElementsByClassName("sort")
        let tamanio = columns.length
        for (let i = 0; i < tamanio; i++) {
            columns[i].addEventListener("click", ordenar)
        }

        function ordenar(e) {
            let elemento = e.target
            document.getElementById('orderCol').value = elemento.cellIndex
            if (elemento.classList.contains("asc")) {
                document.getElementById("orderType").value = "asc"
                elemento.classList.remove("asc")
                elemento.classList.add("desc")
            } else {
                document.getElementById("orderType").value = "desc"
                elemento.classList.remove("desc")
                elemento.classList.add("asc")
            }
            getData()
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>