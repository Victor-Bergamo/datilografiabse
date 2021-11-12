<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/login_adm.css">
    <title>Administração</title>
</head>

<body>
    <script src="../assets/js/jquery.min.js"></script>
    <main>
        <div class="card-admin-login">
            <form action="source/validalogin.php" method="POST">
                <div class="form-group">
                    <h3>Faça seu Login <i class="fas fa-lock"></i> </h3>
                </div>
                <div class="form-group">
                    <input type="password" autocomplete="off" placeholder="Senha" id="senha" name="senha">
                </div>
                <div class="form-group">
                    <button type="submit">Login</button>
                </div>
            </form>
        </div>
    </main>
</body>
<script>
    $(function() {
        $("#senha").focus();
    })
</script>

</html>