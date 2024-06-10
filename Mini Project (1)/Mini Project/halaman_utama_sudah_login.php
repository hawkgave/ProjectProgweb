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

$sql = "SELECT konserId, nama_konser, nama_penyanyi, tanggal_konser, lokasi_konser, gambar_konser FROM halaman_utama";
$result = mysqli_query($conn, $sql);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="test.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

        #boxsearch, #tombol{
            float: left;
            padding: 8px;
            border-radius: 5px;
            margin-top: 10px;
            background-color: rgb(186, 186, 186);
        }

        #boxsearch{
            
            color: #291801;
            padding: 8px;
            font-size: 15px;
            border: none;
            margin-right: 5px;
            width: 400px;
        }

        #tombol{
            cursor: pointer;
            margin-top: 6px;
            margin-right: 15px;
            border: none;
            background: transparent;
        }


        .fullscreen-gif {
            margin-top: -50px;
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
            margin-left: 85px;
            margin-bottom: 0px;
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
        button.w3-button.w3-teal.w3-xlarge {
            float: right;
            margin-right: 20px;
            margin-top: 10px;
            font-size: 20px;
        }

        #namaSidebar{
            margin-top: 60px;
        }

        .w3-sidebar.w3-bar-block.w3-border-right {
            height: 100%; 
            width: 300px; 
            position: fixed; 
            z-index: 1; 
            top: 0; 
            right: 0;
            background-color: lightgray; 
            overflow-x: hidden; 
            padding-top: 20px;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
            display: none;
        }

        .w3-sidebar a {
            text-decoration: none;
            font-size: 20px;
            color: black;
            display: block;
            padding: 10px 15px;
        }

        a.dashboard{
            font-size: 18px;
            padding: 0;
        }

        a.logout:hover {
            text-decoration: underline;
            color: black;
        }

        .w3-sidebar {
            padding: 16px;
            font-size: 20px;
            color: black;
            display: block;
        }

        .w3-sidebar button {
            border: none;
            outline: none;
            /* color: black; */
            cursor: pointer;
            padding: 10px 15px;
            width: 100%;
            text-align: left;
            font-size: 20px;
            /* transition: 0.4s; */
        }

        /* Accordion button styling */
        button.w3-button.w3-block.w3-left-align {
            width: 100%;
            text-align: left;
            border: none;
            outline: none;
            transition: 0.4s;
            cursor: pointer;
            padding: 10px 15px;
            font-size: 18px;
            color: black;
            background-color: transparent;
        }


        /* Accordion content styling */
        #demoAcc {
            display: none;
            /* background-color: white; */
            overflow: hidden;
            transition: max-height 0.2s ease-out;
            padding-left: 15px;
            padding-right: 15px;
            border-top: 1px solid #ccc;
        }

        #demoAcc a.w3-bar-item.w3-button {
            padding: 10px 15px;
            text-decoration: none;
            color: black;
            display: block;
        }

        /* Show class for the accordion */
        .w3-show {
            display: block !important;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="w3-sidebar w3-bar-block w3-border-right" style="display:none" id="mySidebar">
        <p class="w3-bar-item" id="namaSidebar">Halo, <?php echo $name; ?></p>
        <button class="w3-button w3-block w3-left-align" onclick="myAccFunc()"><i class="fa fa-user-circle"></i>
        Profile <i class="fa fa-caret-down"></i>
        </button>
        <div id="demoAcc" class="w3-hide w3-white w3-card">
            <p class="w3-bar-item w3-button">Nama : <?php echo $name ?></p>
            <p class="w3-bar-item w3-button">Email : <?php echo $email ?></p>
        </div>
        <button class="w3-button w3-block w3-left-align"></i><a href="halaman_utama_sudah_login.php" class="dashboard"><i class="fa fa-home"></i> Dashboard</a></button>
        <a href="logout.php" class="logout">Logout</a>
    </div>
    <header>
        <div class="topnav">
            <a href="halaman_utama_sudah_login.php" id="logo"><img src="logosilver.png" alt="logo" width="80px"></a>
            <form method="GET" action="search_update.php">
                <input type="search" placeholder="Search.." name="search" id="boxsearch">
                <button type="submit" id="tombol"><img src="search.png" alt="searchlogo" width="25px"></button>
            </form>
            <button class="w3-button w3-teal w3-xlarge" id="sidebarToggle""><i class="fa fa-bars"></i></button>
        </div>
    </header>
    <hr>
    <main>
        <div class="fullscreen-gif"> <img src="logogerak.gif" alt="GIF" width="1300px"/> </div>
        <table class="tiketbaru">
            <tbody>
            <?php 
            if (mysqli_num_rows($result) > 0){
                echo "<tr>";
                while ($row = mysqli_fetch_assoc($result)){
                    echo "<td class='concert-cell'>";
                    echo "<a href='deskripsi.php?konserId={$row['konserId']}'><img src='{$row['gambar_konser']}' alt='Gambar Konser' class='concert-image' width='400px'></a>";
                    echo "<div class='concert-info'>";
                    echo "<p class= 'namaKonser'> {$row['nama_konser']}</p>";
                    echo "<p class= 'namaPenyanyi'> {$row['nama_penyanyi']}</p>";
                    echo "<p class= 'tanggal'> {$row['tanggal_konser']}</p>";
                    echo "<p class= 'lokasi'> {$row['lokasi_konser']}</p>";
                    echo "</div>";
                    echo "</td>";
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
        window.addEventListener('scroll', function() {
            var header = document.querySelector('header');
            if (window.scrollY > 0) {
                header.classList.add('header-scrolled');
            } else {
                header.classList.remove('header-scrolled');
            }
        });

        // function w3_open() {
        // document.getElementById("mySidebar").style.display = "block";
        // }

        // function w3_close() {
        // document.getElementById("mySidebar").style.display = "none";
        // }
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            var sidebar = document.getElementById('mySidebar');
            if (sidebar.style.display === 'block') {
                sidebar.style.display = 'none';
                this.innerHTML = '<i class="fa fa-bars"></i>';
            } else {
                sidebar.style.display = 'block';
                this.innerHTML = '<i class="fa fa-times"></i>';
            }
        });

        function myAccFunc() {
            var x = document.getElementById("demoAcc");
            if (x.className.indexOf("w3-show") == -1) {
                x.className += " w3-show";
                x.previousElementSibling.className += " w3-green";
            } else { 
                x.className = x.className.replace(" w3-show", "");
                x.previousElementSibling.className = 
                x.previousElementSibling.className.replace(" w3-green", "");
            }
        }
    </script>
</body>
</html>
<?php
mysqli_close($conn);
?>