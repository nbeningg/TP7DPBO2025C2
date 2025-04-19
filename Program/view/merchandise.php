<!-- SECTION: Pencarian Merchandise -->
<section class="search-section">
    <h3>Search Merchandise</h3>
    <div class="search-container">
        <form method="GET" class="search-form">
            <input type="hidden" name="page" value="merchandise">
            <div class="search-input-container">
                <!-- input pencarian berdasarkan nama -->
                <input type="text" name="keyword" placeholder="Search by name..." value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>">
                <button type="submit" name="search" class="btn-search">Search</button>

                <!-- tampilkan tombol Clear jika sedang dalam mode search -->
                <?php if(isset($_GET['search']) && $_GET['keyword']): ?>
                    <a href="?page=merchandise" class="clear-search">Clear</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</section>

<!-- SECTION: daftar atau list merchandise -->
<section class="merchandise-section">
    <h3>Merchandise List</h3>
    
    <!-- tombol tambah merchandise -->
    <div class="action-buttons">
        <button onclick="showForm('formAddMerchandise')" class="btn-add">Add New Merchandise</button>
    </div>
    
    <!-- ambil data dari hasil search atau semua data -->
    <?php 
    $displayMerchandise = isset($_GET['search']) ? $search_result : $merchandise->getAllMerchandise();
    
    // tampilkan pesan jika tidak ada hasil pencarian
    if (isset($_GET['search']) && empty($displayMerchandise)): ?>
        <div class="no-results">No merchandise found</div>
    <?php else: ?>
    
    <!-- tabel daftar merchandise -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($displayMerchandise as $m): ?>
        <tr>
            <td><?= $m['id'] ?></td>
            <td><?= $m['name'] ?></td>
            <td><?= $m['category'] ?></td>
            <td>Rp <?= number_format($m['price'], 0, ',', '.') ?></td>
            <td><?= $m['stock'] ?></td>
            <td class="action-buttons-cell">
                <!-- tombol edit -->
                <button class="btn-edit" onclick="window.location='?page=merchandise&edit=<?= $m['id'] ?>'">Edit</button>
                <!-- tombol delete dengan konfirmasi -->
                <button class="btn-delete" onclick="if(confirm('Are you sure you want to delete?')) window.location='?page=merchandise&delete_merchandise=<?= $m['id'] ?>'">Delete</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>

    <!-- form tambah/edit merchandise -->
    <div id="formAddMerchandise" class="form-container" style="display: <?= isset($_GET['edit']) ? 'block' : 'none' ?>;">
        <h3><?= isset($_GET['edit']) ? 'Edit Merchandise' : 'Add New Merchandise' ?></h3>
        <?php
        $editData = null;
        if (isset($_GET['edit'])) {
            $editData = $merchandise->getMerchandiseById($_GET['edit']);
        }
        ?>
        <form method="POST">
            <?php if ($editData): ?>
                <input type="hidden" name="id" value="<?= $editData['id'] ?>">
            <?php endif; ?>
            <div>
                <label>Name:</label>
                <input type="text" name="name" value="<?= $editData ? $editData['name'] : '' ?>" required>
            </div>
            <div>
                <!-- dropdown kategori -->
                <label>Category:</label>
                <select name="category">
                    <option value="Album" <?= $editData && $editData['category'] == 'Album' ? 'selected' : '' ?>>Album</option>
                    <option value="Lightstick" <?= $editData && $editData['category'] == 'Lightstick' ? 'selected' : '' ?>>Lightstick</option>
                    <option value="Photocard" <?= $editData && $editData['category'] == 'Photocard' ? 'selected' : '' ?>>Photocard</option>
                    <option value="Poster" <?= $editData && $editData['category'] == 'Poster' ? 'selected' : '' ?>>Poster</option>
                    <option value="Accessories" <?= $editData && $editData['category'] == 'Aksesoris' ? 'selected' : '' ?>>Accessories</option>
                </select>
            </div>
            <div>
                <label>Price:</label>
                <input type="number" name="price" value="<?= $editData ? $editData['price'] : '' ?>" required>
            </div>
            <div>
                <label>Stock:</label>
                <input type="number" name="stock" value="<?= $editData ? $editData['stock'] : '' ?>" required>
            </div>
            <!-- tombol submit -->
            <button type="submit" name="<?= $editData ? 'update_merchandise' : 'add_merchandise' ?>">
                <?= $editData ? 'Update' : 'Add' ?> Merchandise
            </button>
            <!-- tombol batal -->
            <button type="button" onclick="window.location='?page=merchandise'" class="btn-cancel">Cancel</button>
        </form>
    </div>
</section>