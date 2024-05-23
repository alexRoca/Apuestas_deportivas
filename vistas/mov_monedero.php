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
                        <li class="nav-item">
                            <a class="nav-link" href="./Principal">Lista de Clientes</a>
                        </li>
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
            <div class="row justify-content-center mt-5">
                <div class="col-12 ">
                    <h1 class="text-center">Monedero</h1>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            Datos del Cliente
                        </div>
                        <div class="card-body row">
                            <div class="form-floating mb-3 col-12 col-sm-4">
                                <input placeholder=" " type="text" name="document" class="form-control" value="<?=$resultado_customer[0]['document']?>" disabled>
                                <label for="document">DNI</label>
                            </div>

                            <div class="form-floating mb-3 col-12 col-sm-4">
                                <input placeholder=" " type="text" name="first_name" class="form-control" value="<?=$resultado_customer[0]['first_name']?>" disabled>
                                <label for="first_name">Nombres</label>
                            </div>

                            <div class="form-floating mb-3 col-12 col-sm-4">
                                <input placeholder=" " type="text" name="last_name" class="form-control" value="<?=$resultado_customer[0]['last_name']?>" disabled>
                                <label for="last_name">Apellidos</label>
                            </div>

                            <div class="form-floating mb-3 col-12">
                                <input placeholder=" " type="text" name="amount" class="form-control" value="<?=$resultado_walet[0]['amount']?>" disabled>
                                <label for="amount">Saldo</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-5 mb-5">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            Lista de recargas
                            <button class="btn btn-dark btn-sm ms-1" data-bs-toggle="modal" data-bs-target="#modalregister">Realizar recarga</button></div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive rounded-top">
                                <table class="table table-striped mb-0">
                                    <thead>
                                    <tr>
                                        <th>ID Recarga</th>
                                        <th>Estado</th>
                                        <th>Monto</th>
                                        <th>Imagen</th>
                                        <th>Banco</th>
                                        <th>Usuario modificador</th>
                                        <th>Canal</th>
                                        <th>Fecha Creación</th>
                                        <th>Fecha modificación</th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-nowrap">
                                        <?php foreach($recharges as $row_recharges){?>
                                            <tr>
                                                <td><?php echo $row_recharges['id_recharge']; ?></td>
                                                <td><?php echo $row_recharges['status']; ?></td>
                                                <td><?php echo $row_recharges['amount']; ?></td>
                                                <td><?php echo $row_recharges['image']; ?></td>
                                                <td><?php echo $row_recharges['bank']; ?></td>
                                                <td><?php echo $row_recharges['name_user']; ?></td>
                                                <td><?php echo $row_recharges['channel']; ?></td>
                                                <td><?php echo $row_recharges['timestamp_created']; ?></td>
                                                <td><?php echo $row_recharges['timestamp_modified']; ?></td>
                                                <td>
                                                    <?php if($row_recharges['id_status'] == 1){?>
                                                        <form method="POST">
                                                            <input type="hidden" name="PlayerID" value="<?=$parameter['PlayerID']?>">
                                                            <input type="hidden" name="id_recharge" value="<?=$row_recharges['id_recharge']?>">
                                                            <input type="hidden" name="origen" value="asignar">
                                                            <button type="submit" class="btn btn-success">Asignar</button>
                                                        </form>
                                                    <?php }else{ ?>
                                                        <button type="button" class="btn btn-success" disabled>Asignar</button>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if($row_recharges['id_status'] <> -1){?>
                                                        <form method="POST">
                                                            <input type="hidden" name="PlayerID" value="<?=$parameter['PlayerID']?>">
                                                            <input type="hidden" name="id_recharge" value="<?=$row_recharges['id_recharge']?>">
                                                            <input type="hidden" name="origen" value="anular">
                                                            <button type="submit" class="btn btn-danger">Anular</button>
                                                        </form>
                                                    <?php }else{ ?>
                                                        <button type="button" class="btn btn-danger" disabled>Anular</button>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if($row_recharges['id_status'] <> -1){?>
                                                        <button type="button" data-idbank=<?=$row_recharges['id_bank']?> data-idchannel=<?=$row_recharges['id_channel']?> data-amount=<?=$row_recharges['amount']?> data-idrecarga=<?=$row_recharges['id_recharge']?> data-playerid=<?=$parameter['PlayerID']?> class="btn btn-primary recharge_edit">Editar</button>
                                                    <?php }else{ ?>
                                                        <button type="button" class="btn btn-primary" disabled>Editar</button>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-5 mb-3">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            Lista de Movimientos en el monedero
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive rounded-top">
                                <table class="table table-striped mb-0">
                                    <thead>
                                    <tr>
                                        <th>Tipo de movimiento</th>
                                        <th>ID recarga</th>
                                        <th>Monto</th>
                                        <th>Usuario modificador</th>
                                        <th>Fecha Creación</th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-nowrap">
                                        <?php foreach($customer_wallets_movements as $row_customer_wallets_movements){?>
                                            <tr>
                                                <td><?php echo $row_customer_wallets_movements['customer_wallet_movement_type']; ?></td>
                                                <td><?php echo $row_customer_wallets_movements['id_recharge']; ?></td>
                                                <td><?php echo $row_customer_wallets_movements['amount']; ?></td>
                                                <td><?php echo $row_customer_wallets_movements['name_user']; ?></td>
                                                <td><?php echo $row_customer_wallets_movements['timestamp_created']; ?></td>
                                            </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalregister" tabindex="-1" aria-labelledby="modalregisterLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="Monedero" method="POST">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalregisterLabel">Registrar una recarga</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <select name="id_bank" class="form-select detail-input-edit" required="">
                                    <?php foreach($bank as $row_bank){?>
                                        <option value="<?=$row_bank['id_bank']?>"><?=$row_bank['bank']?></option>
                                    <?php }?>
                                </select>
                                <label for="id_bank">Banco</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select name="id_channel" class="form-select detail-input-edit" required="">
                                    <?php foreach($channel as $row_channel){?>
                                        <option value="<?=$row_channel['id_channel']?>"><?=$row_channel['channel']?></option>
                                    <?php }?>
                                </select>
                                <label for="id_channel">Canal</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input placeholder=" " type="decimal" name="amount" class="form-control" value="0.00">
                                <label for="amount">Monto</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Recargar</button>
                        </div>
                    </div>
                    <input type="hidden" name="origen" value="recarga">
                    <input type="hidden" name="id_customer" value="<?=$parameter['PlayerID']?>">
                </form>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modaleditar" tabindex="-1" aria-labelledby="modaleditarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="Monedero" method="POST">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modaleditarLabel">Editar recarga <div id="id_label_recarga"></div></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <select name="id_bank_edit" id="id_bank_edit" class="form-select detail-input-edit" required="">
                                    <?php foreach($bank as $row_bank){?>
                                        <option value="<?=$row_bank['id_bank']?>"><?=$row_bank['bank']?></option>
                                    <?php }?>
                                </select>
                                <label for="id_bank_edit">Banco</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select name="id_channel_edit" id="id_channel_edit"class="form-select detail-input-edit" required="">
                                    <?php foreach($channel as $row_channel){?>
                                        <option value="<?=$row_channel['id_channel']?>"><?=$row_channel['channel']?></option>
                                    <?php }?>
                                </select>
                                <label for="id_channel_edit">Canal</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input placeholder=" " type="decimal" name="amount_edit" id="amount_edit" class="form-control" value="0.00">
                                <label for="amount_edit">Monto</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Editar</button>
                        </div>
                    </div>
                    <input type="hidden" name="origen" value="editar">
                    <input type="hidden" name="id_recharge_edit" id="id_recharge_edit">
                    <input type="hidden" name="id_customer" value="<?=$parameter['PlayerID']?>">
                </form>
            </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="js/monedero.js"></script>
    </body>
</html>