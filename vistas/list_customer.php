<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>clientes</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand">Usuario : <?php echo $_SESSION['first_name'];?> <?php echo $_SESSION['last_name'];?></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Menu
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li>
                            <form method="POST" action="Principal">
                                <input type="hidden" name="origen" value="Sign_off">
                                <input type="submit" class="dropdown-item" value="Cerrar Sesion">
                            </form>
                        </li>
                    </ul>
                    </li>
                </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row mt-3">
                <div class="col-12 ">
                    <h1 class="text-center">Lista de clientes</h1>
                    <div class="card mt-5">
                        <div class="card-header">
                            BUSQUEDA
                        </div>
                        <div class="card-body">
                            <form method="GET">
                                <input class="col-12 col-sm-2 mt-2 form-control" type="number" name="PlayerID" id="PlayerID" placeholder="PlayerID" value=<?=$parameter['PlayerID']?>>
                                <input class="col-12 col-sm-2 mt-2 form-control" type="number" name="document" id="document" placeholder="DNI" value=<?=$parameter['document']?>>
                                <input class="col-12 col-sm-3 mt-2 form-control" type="text" name="first_name" id="first_name" placeholder="NOMBRES" value=<?=$parameter['first_name']?>>
                                <input class="col-12 col-sm-3 mt-2 form-control" type="text" name="last_name" id="last_name" placeholder="APELLIDOS" value=<?=$parameter['last_name']?>>
                                <button type="submit" class="btn btn-primary col-12 col-sm-1 mt-2 btn-sm">Buscar</button>
                            </form>
                        </div>
                    </div>
                    <table class="table table-striped table-hover mt-3">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">PlayerID</th>
                            <th scope="col">DNI</th>
                            <th scope="col">NOMBRES</th>
                            <th scope="col">APELLIDOS</th>
                            <th scope="col">USUARIO MODIFICADOR</th>
                            <th scope="col">FECHA DE MODIFICACIÓN</th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $count=0;
                            foreach($data_customer as $row_customer){ 
                                $count++;
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $count;?></th>
                                    <td><?php echo $row_customer['PlayerID']; ?></td>
                                    <td><?php echo $row_customer['document']; ?></td>
                                    <td><?php echo $row_customer['first_name']; ?></td>
                                    <td><?php echo $row_customer['last_name']; ?></td>
                                    <td><?php echo $row_customer['id_users_modified']; ?></td>
                                    <td><?php echo $row_customer['timestamp_modified']; ?></td>
                                    <td><a type="button" class="btn btn-dark" href="Monedero?PlayerID=<?=$row_customer['PlayerID']?>">Monedero Electronica</a></td>
                                </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>