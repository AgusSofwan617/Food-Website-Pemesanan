<?php
// Koneksi ke database
$servername = "localhost"; // Sesuaikan dengan server MySQL kamu
$username = "root";        // Sesuaikan dengan username MySQL kamu
$password = "";            // Sesuaikan dengan password MySQL kamu
$dbname = "toko_online";   // Nama database

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form filter jika ada
$product_filter = isset($_GET['product_filter']) ? $_GET['product_filter'] : '';
$payment_filter = isset($_GET['payment_filter']) ? $_GET['payment_filter'] : '';

// Query untuk mengambil semua data dari tabel orders
$sql = "SELECT id, name, address, product, quantity, payment_method, order_date FROM orders WHERE 1=1";

// Tambahkan filter produk jika ada
if (!empty($product_filter)) {
    $sql .= " AND product = '$product_filter'";
}

// Tambahkan filter metode pembayaran jika ada
if (!empty($payment_filter)) {
    $sql .= " AND payment_method = '$payment_filter'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin - Pantau Pesanan</title>
   <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    </head>
<body>
    <header class="d-flex align-items-center bg-dark text-white p-3">
        <img
        src="asset/ChefAlyaa.jpeg"
        alt="Chef Alyaa"
        class="rounded-circle me-3"
        style="width: 50px; height: 50px"
      />
      <h1 class="h3">Admin - Toko Pizza Online Chef Alyaa</h1>
    </header>

    <main class="container mt-4">
        <h2 class="mb-4">Daftar Pesanan</h2>

        <!-- Form Filter -->
        <form class="row g-3 mb-4">
            <div class="col-md-4">
                <label for="product_filter" class="form-label">Filter Produk</label>
                <select id="product_filter" name="product_filter" class="form-select">
                    <option value="">Semua Produk</option>
                    <option value="product1" <?php if ($product_filter == 'product1') echo 'selected'; ?>>Produk 1</option>
                    <option value="product2" <?php if ($product_filter == 'product2') echo 'selected'; ?>>Produk 2</option>
                    <!-- Tambahkan opsi untuk produk lainnya -->
                </select>
            </div>

            <div class="col-md-4">
                <label for="payment_filter" class="form-label">Filter Metode Pembayaran</label>
                <select id="payment_filter" name="payment_filter" class="form-select">
                    <option value="">Semua Metode</option>
                    <option value="bank" <?php if ($payment_filter == 'bank') echo 'selected'; ?>>Transfer Bank</option>
                    <option value="cod" <?php if ($payment_filter == 'cod') echo 'selected'; ?>>Cash on Delivery (COD)</option>
                </select>
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Terapkan Filter</button>
            </div>
        </form>

        <!-- Tabel Daftar Pesanan -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Metode Pembayaran</th>
                    <th>Tanggal Pesanan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Loop melalui hasil dan tampilkan di tabel
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td>" . $row['product'] . "</td>";
                        echo "<td>" . $row['quantity'] . "</td>";
                        echo "<td>" . $row['payment_method'] . "</td>";
                        echo "<td>" . $row['order_date'] . "</td>";
                        echo "<td>";
                        echo "<a href='edit_order.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a> ";
                        echo "<a href='delete_order.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus pesanan ini?\");'>Hapus</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center'>Tidak ada pesanan masuk</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>

    <footer class="bg-dark text-white text-center p-3 mt-4">
        <p>&copy; 2024 Toko Online Sederhana</p>
    </footer>

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script></body>
</html>

<?php
// Tutup koneksi
$conn->close();
?>

