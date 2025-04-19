<section>
    <h3>Purchase List</h3>

    <!-- tombol tambah pembelian -->
    <div class="action-buttons">
        <button onclick="showForm('formAddPurchase')">Add New Purchase</button>
    </div>

    <!-- tabel daftar atau list pembelian -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Merchandise</th>
            <th>Date</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
        <?php foreach ($purchase->getAllPurchases() as $p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= $p['customer_name'] ?></td>
            <td><?= $p['merchandise_name'] ?></td>
            <td><?= $p['purchase_date'] ?></td>
            <td><?= $p['quantity'] ?></td>
            <td>Rp <?= number_format($p['price'] * $p['quantity'], 0, ',', '.') ?></td>
            <td class="action-buttons-cell">
                <?php if (!isset($p['return_date']) || !$p['return_date']): ?>
                    <button class="btn-edit" onclick="window.location='?page=purchases&edit=<?= $p['id'] ?>'">Edit</button>
                    <button class="btn-delete" onclick="if(confirm('Are you sure you want to delete?')) window.location='?page=purchases&delete_purchase=<?= $p['id'] ?>'">Delete</button>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- form tambah/edit pembelian -->
    <div id="formAddPurchase" class="form-container" style="display: <?= isset($_GET['edit']) ? 'block' : 'none' ?>;">
        <h3><?= isset($_GET['edit']) ? 'Edit Purchase' : 'Add New Purchase' ?></h3>
        <?php
        $editData = null;
        if (isset($_GET['edit'])) {
            $editData = $purchase->getPurchaseById($_GET['edit']);
        }
        ?>
        <form method="POST">
            <?php if ($editData): ?>
                <input type="hidden" name="id" value="<?= $editData['id'] ?>">
            <?php endif; ?>
            <!-- dropdown pembeli dari tabel customer -->
            <div>
                <label>Customer:</label>
                <select name="customer_id">
                    <?php foreach ($customer->getAllCustomers() as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= $editData && $editData['customer_id'] == $c['id'] ? 'selected' : '' ?>><?= $c['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- dropdown merchandise dari tabel merchandise -->
            <div>
                <label>Merchandise:</label>
                <select name="merchandise_id">
                    <?php foreach ($merchandise->getAllMerchandise() as $m): ?>
                        <option value="<?= $m['id'] ?>" <?= $editData && $editData['merchandise_id'] == $m['id'] ? 'selected' : '' ?>><?= $m['name'] ?> (Stok: <?= $m['stock'] ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- tanggal hanya untuk mode edit, jika tambah langsung ambil dari hari saat daftar -->
            <?php if ($editData): ?>
                <div>
                    <label>Purchase Date:</label>
                    <input type="date" name="purchase_date" value="<?= $editData['purchase_date'] ?>" required>
                </div>
            <?php endif; ?>
            <div>
                <label>Quantity:</label>
                <input type="number" name="quantity" min="1" value="<?= $editData ? $editData['quantity'] : '1' ?>" required>
            </div>
            <!-- tombol submit -->
            <button type="submit" name="<?= $editData ? 'update_purchase' : 'add_purchase' ?>">
                <?= $editData ? 'Update' : 'Add' ?> Purchase
            </button>
            <!-- tombol batal -->
            <button type="button" onclick="window.location='?page=purchases'"class="btn-cancel">Cancel</button>
        </form>
    </div>
</section>
