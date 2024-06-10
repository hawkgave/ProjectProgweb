<?php
include_once "koneksi.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: halaman_utama.php");
    exit();
}

// Ambil nama pengguna dari session
$username = $_SESSION['username'];
$userId = $_SESSION['userId'];

// Ambil nama dan email dari cookies
$name = isset($_COOKIE['name']) ? $_COOKIE['name'] : "";
$email = isset($_COOKIE['email']) ? $_COOKIE['email'] : "";

$sql = "SELECT nama_konser, nama_penyanyi, tanggal_konser, lokasi_konser, gambar_konser FROM halaman_utama";
$result = mysqli_query($conn, $sql);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="test.css"> -->
    <style>
        html{
            background-image: url(newbg.png);
            background-size: cover;
            background-attachment: fixed;
        }

        body{
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

        hr{
            clear: both;
            /* position: sticky; */
            top: 61px;
            margin: 0;
        }

        #logo{
            float: left;
            margin: 5px 15px 10px 15px;
        }

        /* .login{
            float: right;
            margin-right: 50px;
            margin-top: 5px;
            color: #291801;
            text-decoration: none;
            background-color: rgb(186, 186, 186);
            padding: 10px;
            border-radius: 5px;
        }

        .login:hover{
            text-decoration: underline;
            border: 1px solid black;
        } */

        button.w3-button.w3-teal.w3-xlarge {
            float: right;
            margin-right: 20px;
            margin-top: 10px;
            font-size: 20px;
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
            border: none;
            background: transparent;
        }

        .logo1{
            float: left;
            margin-left: 75px;
            margin-top: 50px;
            margin-right: 30px;
        }

        .logo2{
            margin-top: -30px;
        }

        footer{
            clear: both;
            text-align: center;
            font-weight: bold;
            background: white;
            opacity: 0.6;
            padding-top: 10px;
            padding-bottom: 20px;
            margin-top: 100px;
            #pt1{
                font-size: 16px;
            }
            #pt2{
                text-decoration: underline;
            }
            #pt3{
                font-size: 7px;
                line-height: 0.2px;
            }
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

        table.tiketbaru p{
            color: #ffffffff;
            margin-bottom: 0px;
            margin-left: 85px;
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

        /* Sidebar styling */
        .w3-sidebar {
            height: 100%; 
            width: 250px; 
            position: fixed; 
            z-index: 1; 
            top: 0; 
            right: 0;
            background-color: lightgray; 
            overflow-x: hidden; 
            padding-top: 20px;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .w3-sidebar a {
            text-decoration: none;
            font-size: 20px;
            color: black;
            display: block;
        }

        .w3-sidebar a:hover {
            color: #f1f1f1;
        }

        .w3-sidebar {
            padding: 16px;
            font-size: 20px;
            color: black;
            display: block;
        }

        .w3-sidebar {
            font-size: 25px;
            font-weight: bold;
            color: black;
            cursor: pointer;
        }

        .w3-sidebar.w3-bar-block.w3-border-left {
            border-left: 1px solid #818181;
        }


    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="w3-sidebar w3-bar-block w3-border-right" style="display:none" id="mySidebar">
        <button onclick="w3_close()" class="w3-bar-item w3-large">&times;</button>
        <!-- <a href="#" class="w3-bar-item w3-button">Link 1</a>
        <a href="#" class="w3-bar-item w3-button">Link 2</a>
        <a href="#" class="w3-bar-item w3-button">Link 3</a> -->
        <p>Halo, <?php echo $name; ?></p>
        <a href="logout.php"">Logout</a>
    </div>
    <header>
        <div class="topnav">
            <a href="halaman_utama_sudah_login.php" id="logo"><img src="logosilver.png" alt="logo" width="80px"></a>
            <form method="GET" action="search_update.php">
                <input type="search" placeholder="Search.." name="search" id="boxsearch">
                <button type="submit" id="tombol"><img src="search.png" alt="searchlogo" width="25px"></button>
            </form>
            <!-- <button id="tombol">Explore</button> -->
            <button class="w3-button w3-teal w3-xlarge" onclick="w3_open()">☰</button>
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
    <hr>
    <main>
        <!-- <div class="logo1">
            <img src="logo1.png" alt="Logo" width="500px">
        </div>
        <div class="logo2">
            <img src="logo2.png" alt="logo2" width="650px"> -->
        <!-- </div> -->
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
                    echo "<p class= 'namaKonser'> {$row['nama_konser']}</p>";
                    echo "<p class= 'namaPenyanyi'> {$row['nama_penyanyi']}</p>";
                    echo "<p class= 'tanggal'> {$row['tanggal_konser']}</p>";
                    echo "<p class= 'lokasi'> {$row['lokasi_konser']}</p>";
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
    <script>
        function searchConcerts() {
            var input, filter, table, cells, concertName, i, j;
            input = document.getElementById("boxsearch");
            filter = input.value.toUpperCase();
            table = document.getElementById("concertTable");
            cells = table.getElementsByClassName("concert-cell");
            for (i = 0; i < cells.length; i++) {
                concertName = cells[i].getElementsByClassName("namaKonser")[0];
                if (concertName.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    cells[i].style.display = "";
                } else {
                    cells[i].style.display = "none";
                }
            }
        }

        function w3_open() {
        document.getElementById("mySidebar").style.display = "block";
        }

        function w3_close() {
        document.getElementById("mySidebar").style.display = "none";
        }
    </script>
</body>
</html>