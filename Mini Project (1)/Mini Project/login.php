<?php
include_once "koneksi.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE username='$username' && password='$password' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $dataUser = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $username;
        $_SESSION['userId'] = $dataUser['userId'];
        
        $name = $dataUser['nama'];
        $email = $dataUser['email'];
        setcookie("name", $name, time() + 3600);
        setcookie("email", $email, time() + 3600);

        header("Location: halaman_utama_sudah_login.php");
        exit();
    } else {
        $error = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        html{
            background-image: url(newbg.png);
            background-size: cover;
            background-attachment: fixed;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .loginContainer{
            width: 90%;
            max-width: 600px;
            background-color: #ffffff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid black;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        button {
            width: 100%;
            padding: 15px;
            background-color: #aeabab;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: gray;
        }
        p{
            text-align: center;
            font-size: 14px;
            a{
                text-decoration: none;
            }
            a:hover{
                text-decoration: underline;
            }
        }
    </style>
</head>
<body>
    <div class="loginContainer">
        <h1>Silahkan Login</h1>
        <form method="post" action="">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required />

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required />

            <?php if (isset($error)) { ?>
                <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
            <?php } ?>

            <button type="submit">Login</button>

            <p>Belum punya akun? <a href="signup.php">Daftar!</a></p>
        </form>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>