<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>LOGIN</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
    <body class="container">
        <div class="row mt-3">
            <form method="POST">
                <div class="col-12 text-center">
                    <h1>INICIO DE SESIÓN</h1>
                </div>
                <div class="form-group col-12">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Correo">
                </div>
                <div class="form-group col-12">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="Password" name="Password" placeholder="Password">
                </div>
                <input type="hidden" name="origen" value="login">
                <button type="submit" class="btn btn-primary col-12 mt-3">INICIAR SESIÓN</button>
            </form>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>