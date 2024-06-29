<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Login</title>
    <!-- Tautan CSS Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        h1 {
            text-align: center;
        }
        .card {
            max-width: 300px;
            padding: 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .card a {
            margin-top: 10px;
        }
        .card .buttons {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            width: 100%;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Login</h1>
        <a href="http://localhost/sembako/login.php" class="btn btn-primary btn-block">OPERATOR</a>
        <a href="http://localhost/sembako/login_admin.php" class="btn btn-primary btn-block">ADMIN</a>
    </div>
</body>
</html>
