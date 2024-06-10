<?php 
include 'koneksi.php'; 
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: halaman_utama.php");
    exit();
}

$name = isset($_COOKIE['name']) ? $_COOKIE['name'] : "";
$email = isset($_COOKIE['email']) ? $_COOKIE['email'] : "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $konserId = $_POST['konserId'];
    $userId = $_SESSION['userId'];
    $tiketId = 1;

    $jumlah_tiketVIP = $_POST['qty-vip'];
    $jumlah_tiketVVIPA = $_POST['qty-vvipa'];
    $jumlah_tiketVVIPB = $_POST['qty-vvipb'];
    $jumlah_tiketFestA = $_POST['qty-festa'];
    $jumlah_tiketFestB = $_POST['qty-festb'];
    $jumlah_tiketCatA = $_POST['qty-cata'];
    $jumlah_tiketCatB = $_POST['qty-catb'];

    $waktu_pemesanan = date("Y-m-d H:i:s");

    $stmt = $conn->prepare("INSERT INTO pemesanan (tiketId, konserId, userId, jumlah_tiketVIP, jumlah_tiketVVIPA, jumlah_tiketVVIPB, jumlah_tiketFestA, jumlah_tiketFestB, jumlah_tiketCatA, jumlah_tiketCatB, waktu_pemesanan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiiiiiiiss", $tiketId, $konserId, $userId, $jumlah_tiketVIP, $jumlah_tiketVVIPA, $jumlah_tiketVVIPB, $jumlah_tiketFestA, $jumlah_tiketFestB, $jumlah_tiketCatA, $jumlah_tiketCatB, $waktu_pemesanan);

    if ($stmt->execute()) {
        header("Location: test2.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$konserId = $_GET['konserId'];

$query = $conn->prepare("SELECT * FROM halaman_utama WHERE konserId = ?");
$query->bind_param("i", $konserId);
$query->execute();
$result = $query->get_result();
$data = $result->fetch_assoc();

// Fetch ticket data
$ticketQuery = $conn->prepare("SELECT * FROM tiket WHERE konserId = ?");
$ticketQuery->bind_param("i", $konserId);
$ticketQuery->execute();
$ticketResult = $ticketQuery->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($data['nama_konser']); ?></title>
    <link rel="stylesheet" href="test.css">
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
        /* Sidebar styling */
        button.w3-button.w3-teal.w3-xlarge {
            float: right;
            margin-right: 20px;
            margin-top: 10px;
            font-size: 20px;
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
        }

        .w3-bar-item.w3-large{
            background-color: transparent;
            font-size: 30px;
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

        .w3-sidebar {
            padding: 16px;
            font-size: 20px;
            color: black;
            display: block;
        }

        .w3-sidebar button {
            border: none;
            outline: none;
            cursor: pointer;
            padding: 10px 15px;
            width: 100%;
            text-align: left;
            font-size: 20px;
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
            background-color: white;
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

        .eventDetail {
            width: 400px;
        }
        #tombol{
            cursor: pointer;
            margin-right: 15px;
        }
        
        button.w3-button.w3-teal.w3-xlarge {
            float: right;
            margin-right: 20px;
            margin-top: 10px;
            font-size: 20px;
        }

        /* Style for the Buy Now button */
        .tombol {
            background-color: #ff4500;
            color: white;
            padding: 15px 30px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .tombol:hover {
            background-color: #ff6347;
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

    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="w3-sidebar w3-bar-block w3-border-right" style="display:none" id="mySidebar">
        <button onclick="w3_close()" class="w3-bar-item w3-large">&times;</button>
        <p class="w3-bar-item">Halo, <?php echo htmlspecialchars($name); ?></p>
        <button class="w3-button w3-block w3-left-align" onclick="myAccFunc()">
        Profile <i class="fa fa-caret-down"></i>
        </button>
        <div id="demoAcc" class="w3-hide w3-white w3-card">
            <p class="w3-bar-item w3-button">Nama : <?php echo htmlspecialchars($name); ?></p>
            <p class="w3-bar-item w3-button">Email : <?php echo htmlspecialchars($email); ?></p>
        </div>
        <button class="w3-button w3-block w3-left-align"></i><a href="halaman_utama_sudah_login.php" class="dashboard"><i class="fa fa-home"></i> Dashboard</a></button>
        <a href="logout.php">Logout</a>
    </div>
    <header>
        <div class="topnav">
            <a href="halaman_utama_sudah_login.php" id="logo"><img src="logosilver.png" alt="logo" width="80px"></a>
            <button class="w3-button w3-teal w3-xlarge" onclick="w3_open()">☰</button>
        </div>
    </header>
    <hr>
    <main>
        <div class="kembali">
            <a href="halaman_utama_sudah_login.php">&larr; Kembali</a>
        </div>
        <aside>
            <div class="eventDetail">
                <div class="infoTitle">
                    <h1><?php echo htmlspecialchars($data['nama_konser']); ?></h1>
                </div>
                <div class="infoTambahan">
                    <div class="infoTanggal">
                        <ul>
                            <li><?php echo htmlspecialchars($data['tanggal_konser']); ?></li>
                        </ul>
                    </div>
                    <div class="infoJam">
                        <ul>
                            <li><?php echo htmlspecialchars($data['jam_konser']); ?></li>
                        </ul>
                    </div>
                    <div class="infoLokasi">
                        <ul>
                            <li><?php echo htmlspecialchars($data['lokasi_konser']); ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </aside>
        <div class="poster">
            <img src="<?php echo htmlspecialchars($data['poster']); ?>" alt="poster1" width="700px" height="400px">
        </div>
        <div class="deskripsiTiket">
            <h2>Deskripsi</h2>
            <p><?php echo nl2br(htmlspecialchars($data['deskripsi'])); ?></p>
        </div>
        <div class="syarat">
            <h2>Syarat dan Ketentuan</h2>
            <ol>
                <?php 
                $syarat = explode("\n", $data['syarat']);
                foreach ($syarat as $item) {
                    echo "<li>" . htmlspecialchars($item) . "</li>";
                }
                ?>
            </ol>
        </div>
        <div class="ticket-section">
            <div class="ticket-container">
                <div class="venue-image">
                    <h2 class="section-title">Venue</h2>
                    <img src="STAGE.png" alt="Venue Image">
                </div>
                <div class="ticket-info">
                    <h2 class="section-title">Ticket</h2>
                    <form action="deskripsi.php?konserId=<?php echo htmlspecialchars($konserId); ?>" method="POST">
                        <?php 
                        while ($ticketData = $ticketResult->fetch_assoc()) {
                            $ticketTypes = [
                                'VIP' => ['jumlah' => $ticketData['jumlah_tiketVIP'], 'harga' => $ticketData['harga_tiketVIP'], 'ket' => $ticketData['ket_tiketVIP']],
                                'VVIPA' => ['jumlah' => $ticketData['jumlah_tiketVVIPA'], 'harga' => $ticketData['harga_tiketVVIPA'], 'ket' => $ticketData['ket_tiketVVIPA']],
                                'VVIPB' => ['jumlah' => $ticketData['jumlah_tiketVVIPB'], 'harga' => $ticketData['harga_tiketVVIPB'], 'ket' => $ticketData['ket_tiketVVIPB']],
                                'FestA' => ['jumlah' => $ticketData['jumlah_tiketFestA'], 'harga' => $ticketData['harga_tiketFestA'], 'ket' => $ticketData['ket_tiketFestA']],
                                'FestB' => ['jumlah' => $ticketData['jumlah_tiketFestB'], 'harga' => $ticketData['harga_tiketFestB'], 'ket' => $ticketData['ket_tiketFestB']],
                                'CatA' => ['jumlah' => $ticketData['jumlah_tiketCatA'], 'harga' => $ticketData['harga_tiketCatA'], 'ket' => $ticketData['ket_tiketCatA']],
                                'CatB' => ['jumlah' => $ticketData['jumlah_tiketCatB'], 'harga' => $ticketData['harga_tiketCatB'], 'ket' => $ticketData['ket_tiketCatB']]
                            ];
                        
                            foreach ($ticketTypes as $type => $info) {
                                echo "
                                <div class='ticket-item'>
                                    <h3 class='item-title'>" . htmlspecialchars($type) . "</h3>
                                    <p class='item-desc'>" . htmlspecialchars($info['ket']) . "</p>
                                    <p class='item-price'>IDR " . number_format($info['harga'], 2, ',', '.') . "</p>
                                    <div class='quantity-input'>
                                        <label for='qty-" . strtolower($type) . "'>Quantity:</label>
                                        <input type='number' id='qty-" . strtolower($type) . "' name='qty-" . strtolower($type) . "' value='0' min='0' max='" . htmlspecialchars($info['jumlah']) . "'>
                                        <span class='available-tickets'>Available: " . htmlspecialchars($info['jumlah']) . "</span>
                                    </div>
                                </div>";
                            }
                        }
                        ?>
                        <input type="hidden" name="konserId" value="<?php echo htmlspecialchars($konserId); ?>">
                        <button type="submit" name="submit" class="tombol">Buy Now</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <p id="pt1">&copy; 2024 PALS Productions | Official Store. All Rights Reserved.</p>
        <p id="pt2">Help Terms Privacy Do Not Sell My Personal Information Cookie Choices</p>
        <p id="pt3">IF YOU ARE USING A SCREEN READER AND ARE HAVING PROBLEMS USING THIS WEBSITE, PLEASE CALL 866-682-4413 FOR ASSISTANCE.</p>
    </footer>

    <script>
        function w3_open() {
        document.getElementById("mySidebar").style.display = "block";
        }

        function w3_close() {
        document.getElementById("mySidebar").style.display = "none";
        }

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

        window.addEventListener('scroll', function() {
            var header = document.querySelector('header');
            if (window.scrollY > 0) {
                header.classList.add('header-scrolled');
            } else {
                header.classList.remove('header-scrolled');
            }
        });
    </script>
</body>
</html>
<?php
$conn->close();
?>
