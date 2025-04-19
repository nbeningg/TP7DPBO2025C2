<?php
// memanggil file class
require_once 'class/Customer.php';
require_once 'class/Merchandise.php';
require_once 'class/Purchase.php';

// membuat objek dari masing-masing class
$customer = new Customer();
$merchandise = new Merchandise();
$purchase = new Purchase();

$display_page = true; // default-nya halaman akan ditampilkan


// proses aksi CRUD untuk customer
if (isset($_POST['add_customer'])) {
    $customer->addCustomer($_POST['name'], $_POST['email'], $_POST['phone']);
    header("Location: index.php?page=customers");
    $display_page = false;
} else if (isset($_POST['update_customer'])) {
    $customer->updateCustomer($_POST['id'], $_POST['name'], $_POST['email'], $_POST['phone']);
    header("Location: index.php?page=customers");
    $display_page = false;
} else if (isset($_GET['delete_customer'])) {
    $customer->deleteCustomer($_GET['delete_customer']);
    header("Location: index.php?page=customers");
    $display_page = false;
}
// proses aksi CRUD untuk merchandise
else if (isset($_POST['add_merchandise'])) {
    $merchandise->addMerchandise($_POST['name'], $_POST['category'], $_POST['price'], $_POST['stock']);
    header("Location: index.php?page=merchandise");
    $display_page = false;
} else if (isset($_POST['update_merchandise'])) {
    $merchandise->updateMerchandise($_POST['id'], $_POST['name'], $_POST['category'], $_POST['price'], $_POST['stock']);
    header("Location: index.php?page=merchandise");
    $display_page = false;
} else if (isset($_GET['delete_merchandise'])) {
    $merchandise->deleteMerchandise($_GET['delete_merchandise']);
    header("Location: index.php?page=merchandise");
    $display_page = false;
}
// proses aksi CRUD untuk purchase
else if (isset($_POST['add_purchase'])) {
    $purchase->addPurchase($_POST['customer_id'], $_POST['merchandise_id'], $_POST['quantity']);
    header("Location: index.php?page=purchases");
    $display_page = false;
} else if (isset($_POST['update_purchase'])) {
    $purchase->updatePurchase($_POST['id'], $_POST['customer_id'], $_POST['merchandise_id'], $_POST['purchase_date'], $_POST['quantity']);
    header("Location: index.php?page=purchases");
    $display_page = false;
} else if (isset($_GET['delete_purchase'])) {
    $purchase->deletePurchase($_GET['delete_purchase']);
    header("Location: index.php?page=purchases");
    $display_page = false;
}

// proses pencarian merchandise
$search_result = [];
if (isset($_GET['search'])) {
    $search_result = $merchandise->searchMerchandise($_GET['keyword']);
}

// jika tidak ada halaman yang dipilih, tampilkan halaman merchandise secara default
$page = isset($_GET['page']) ? $_GET['page'] : 'merchandise';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>KPOP STORE</title>
    <link rel="stylesheet" href="style.css">
    <script>
        // fungsi untuk menampilkan form berdasarkan id
        function showForm(formId) {
            document.getElementById(formId).style.display = 'block';
        }
    </script>
</head>
<body>
    <?php include 'view/header.php'; ?>
    <main>
        <nav>
            <!-- Navigasi menu utama -->
            <a href="?page=customers">Customers</a> |
            <a href="?page=merchandise">Merchandises</a> |
            <a href="?page=purchases">Purchases</a>
        </nav>
        <!-- Menampilkan tampilan halaman sesuai pilihan -->
        <?php
        if ($page == 'customers') include 'view/customers.php';
        elseif ($page == 'merchandise') include 'view/merchandise.php';
        elseif ($page == 'purchases') include 'view/purchases.php';
        ?>
    </main>
    <?php include 'view/footer.php'; ?>
</body>
</html>
