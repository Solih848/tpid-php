<?php
// reset_password.php
session_start();
if (!isset($_SESSION['reset_username'])) {
    header('Location: lupa_password.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="website icon" href="icon/Logo.png?v=<?php echo time(); ?>">
    <style>
        * {
            font-family: 'Poppins', sans-serif;

        }

        body {
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            border: 1px solid #ccc;
            /* Solid border dengan lebar 1px dan warna #ccc */
            border-radius: 8px;
            /* Sudut bulat hanya pada sudut atas */
            padding: 20px;
            /* Memberikan padding di dalam card */
            background-color: #fff;
            width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            height: 230px;
            /* Menambah tinggi card menjadi 350px */
        }

        h1 {
            text-align: center;
            margin-bottom: -10px;
            color: #333;
            margin-top: 10px;
        }

        form {
            margin-top: 50px;
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top:
                color: #555;
            font-weight: bold;
            font-size: 14px;
        }

        input[type="text"],
        input[type="password"] {
            padding: 10px;
            margin-bottom: 16px;
            margin-top: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            position: relative;
            width: 92%;
        }

        .password-input-container {
            position: relative;
        }

        .password-toggle-icon {
            position: absolute;
            top: 43%;
            transform: translateY(-50%);
            right: 10px;
            cursor: pointer;
            z-index: 1;
        }

        .password-toggle-icon i {
            font-size: 18px;
            color: #888;
        }

        button[type="submit"] {
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 8px;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        #show-password {
            margin-top: 10px;
        }

        .card footer {
            text-align: center;
            margin-top: 20px;
            color: #888;
        }
    </style>

</head>

<body>
    <div class="card">
        <h1>Reset Password</h1>
        <form method="post" action="proses_reset_password.php">
            <label for="new_password">Password Baru:</label>
            <input type="password" class="form-control" id="new_password" name="new_password" autocomplete="off" placeholder="Masukkan Password Baru" required>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>

</html>