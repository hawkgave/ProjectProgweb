<?php
include_once "koneksi.php";

$sql = "SELECT nama_konser, nama_penyanyi, tanggal_konser, lokasi_konser, kota_konser, gambar_konser FROM halaman_utama";
$result = mysqli_query($conn, $sql);

// $list_konser = array();

// if (mysqli_num_rows($result) > 0) {
//     while ($row = mysqli_fetch_assoc($result)) {
//         $list_konser[] = array($row['nama_konser'], $row['nama_penyanyi'], $row['tanggal_konser'], $row['lokasi_konser'], $row['gambar_konser']);
//     }
// }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="test.css"> -->
    <style>
        html {
            background-image: url(newbg.png);
            background-size: cover;
            background-attachment: fixed;
        }

        body {
            margin: 0;
        }

        header {
            position: sticky;
            top: 0;
            padding: 5px 0;
            z-index: 1000; /* Pastikan header berada di atas elemen lainnya */
            color: #aeabab;
            overflow: hidden;
        }

        .fullscreen-gif{
            margin-top: -10px;
        }
        .header-scrolled {
            background-color: #7469B6; /* Warna latar belakang header saat di-scroll */
            transition: background-color 0.3s ease; /* Efek transisi perubahan warna latar belakang */
        }

        hr {
            clear: both;
            margin: 0;
        }

        #logo {
            float: left;
            margin: 5px 15px 10px 15px;
        }

        .login {
            float: right;
            margin-right: 50px;
            margin-top: 5px;
            color: #291801;
            text-decoration: none;
            background-color: rgb(186, 186, 186);
            padding: 10px;
            border-radius: 5px;
        }

        .login:hover {
            text-decoration: underline;
            border: 1px solid black;
        }

        #boxsearch {
            float: left;
            padding: 8px;
            border-radius: 5px;
            margin-top: 10px;
            background-color: white;
            color: #291801;
            font-size: 15px;
            border: none;
            margin-right: 5px;
            width: 400px;
        }

        #tombol {
            float: left;
            margin-top: 13px;
            cursor: pointer;
            margin-right: 15px;
            background: transparent;
            border: none;
        }

        /* .fullscreen-gif {
            margin-top: 50px;
            text-align: center;
        } */

        footer {
            clear: both;
            text-align: center;
            font-weight: bold;
            background: white;
            opacity: 0.6;
            padding-top: 10px;
            padding-bottom: 20px;
            margin-top: 100px;
        }

        footer #pt1 {
            font-size: 16px;
        }

        footer #pt2 {
            text-decoration: underline;
        }

        footer #pt3 {
            font-size: 7px;
            line-height: 0.2px;
        }

        table.tiketbaru {
            width: 100%;
        }

        table.tiketbaru tr {
            display: flex;
            flex-wrap: wrap;
        }

        table.tiketbaru td {
            width: 25%;
            margin: 40px;
            position: relative;
        }

        table.tiketbaru p {
            color: #ffffffff;
            margin-left: 85px;
            margin-bottom: 0;
        }

        table.tiketbaru p.namaKonser {
            text-align: center;
            margin-top: -220px;
            font-size: 20px;
            margin-left: 85px;
        }

        .concert-cell {
            text-align: center;
            vertical-align: top;
        }

        .concert-image {
            width: 400px;
            height: auto;
            border-radius: 10px;
        }

    </style>
</head>
<body>
    <header>
        <div class="topnav">
            <a href="halaman_utama.php" id="logo"><img src="logosilver.png" alt="logo" width="80px"></a>
            <form method="GET" action="search.php">
                <input type="search" placeholder="Search.." name="search" id="boxsearch">
                <button type="submit" id="tombol"><img src="search.png" alt="searchlogo" width="25px"></button>
            </form>
            <!-- <button id="tombol">Explore</button> -->
            <a href="login.php" class="login">Login</a>
        </div>
    </header>
    <script>
        window.addEventListener('scroll', function() {
            var header = document.querySelector('header');
            if (window.scrollY > 0) {
                header.classList.add('header-scrolled');
            } else {
                header.classList.remove('header-scrolled');
            }
        });
    </script>


    <main>
        <!-- <div class="logo1">
            <img src="logo1.png" alt="Logo" width="500px">
        </div>
        <div class="logo2">
            <img src="logo2.png" alt="logo2" width="650px">
        </div> -->

        <div class="fullscreen-gif"> <img src="logogerak.gif" alt="GIF" width="1300px"/> </div>
        <table class="tiketbaru">
            <tbody>
            <?php 
            if (mysqli_num_rows($result) > 0){
                echo "<tr>";
                $counter = 0;
                while ($row = mysqli_fetch_assoc($result)){
                    $counter++;
                    
                    echo "<td class='concert-cell'>";
                    echo "<a href='#'><img src='{$row['gambar_konser']}' alt='Gambar Konser' class='concert-image' width='400px'></a>";
                    echo "<div class='concert-info'>";
                    echo "<p class= 'namaKonser'>       {$row['nama_konser']}  </p>";
                    echo "<p>       {$row['nama_penyanyi']}  </p>";
                    echo "<p>       {$row['tanggal_konser']}  </p>";
                    echo "<p>       {$row['lokasi_konser']}, {$row['kota_konser']}  </p>";
                    echo "</div>";
                    echo "</td>";
                    if ($counter % 3 == 0){
                        echo "</tr><tr>";
                    }
                }
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
    </main>
    <footer>
        <p id="pt1">&copy; 2024 PALS Productions | Official Store. All Rights Reserved.</p>
        <p id="pt2">Help Terms Privacy Do Not Sell My Personal Information Cookie Choices</p>
        <p id="pt3">IF YOU ARE USING A SCREEN READER AND ARE HAVING PROBLEMS USING THIS WEBSITE, PLEASE CALL 866-682-4413 FOR ASSISTANCE.</p>
    </footer>
</body>
</html>