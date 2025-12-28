<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Coffe</title>
    <style>
        body { 
           font-family: Arial, sans-serif;
            background-image: url('bgkopi.jpg');
            background-position: center;
            background-repeat: repeat;
            background-size: cover;   /* stretch proporsional */
            text-align: center;
            padding-top: 100px;
        }
        form {
            background: white;
            width: 300px;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
        }
        input, select {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
        }
        button {
            width: 95%;
            padding: 10px;
            background: brown;
            color: white;
            border: none;
            border-radius: 5px;
        }
        h2 {
            width: 95%;
            padding: 10px;
            color: white;
            border: none;
            border-radius: 5px;
        }

    </style>
</head>
<body>

<h2>Login Coffe</h2>

<form action="cek_login.php" method="POST">
    <input type="text" name="username" placeholder="Username" required>

    <input type="password" name="password" placeholder="Password" required>

    <select name="level" required>
        <option value="">Pilih Level</option>
        <option value="admin">Admin</option>
        <option value="kasir">Kasir</option>
    </select>

    <button type="submit">Login</button>
</form>

</body>
</html>
