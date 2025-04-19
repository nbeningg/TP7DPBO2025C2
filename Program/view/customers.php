<section>
    
    <h3>Customer List</h3>

    <!-- tombol untuk menampilkan form tambah data -->
    <div class="action-buttons">
        <button onclick="showForm('formAddCustomer')">Add New Customer</button>
    </div>

    <!-- tabel daftar atau list customer -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Telephone</th>
            <th>Action</th>
        </tr>
        <?php foreach ($customer->getAllCustomers() as $c): ?>
        <tr>
            <td><?= $c['id'] ?></td>
            <td><?= $c['name'] ?></td>
            <td><?= $c['email'] ?></td>
            <td><?= $c['phone'] ?></td>
            <td class="action-buttons-cell">
                <!-- tombol edit -->
                <button class="btn-edit" onclick="window.location='?page=customers&edit=<?= $c['id'] ?>'">Edit</button>
                <!-- tombol hapus dengan konfirmasi -->
                <button class="btn-delete" onclick="if(confirm('Are you sure you want to delete?')) window.location='?page=customers&delete_customer=<?= $c['id'] ?>'">Delete</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- form tambah/edit customer -->
    <div id="formAddCustomer" class="form-container" style="display: <?= isset($_GET['edit']) ? 'block' : 'none' ?>;">
        <h3><?= isset($_GET['edit']) ? 'Edit Customer' : 'Add New Customer' ?></h3>
        <?php
        $editData = null;
        if (isset($_GET['edit'])) {
            $editData = $customer->getCustomerById($_GET['edit']);
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
                <label>Email:</label>
                <input type="email" name="email" value="<?= $editData ? $editData['email'] : '' ?>" required>
            </div>
            <div>
                <label>Telephone:</label>
                <input type="text" name="phone" value="<?= $editData ? $editData['phone'] : '' ?>">
            </div>
            <!-- tombol submit -->
            <button type="submit" name="<?= $editData ? 'update_customer' : 'add_customer' ?>">
                <?= $editData ? 'Update' : 'Add' ?> Customer
            </button>
            <!-- tombol batal -->
            <button type="button" onclick="window.location='?page=customers'"class="btn-cancel">Cancel</button>
        </form>
    </div>
</section>