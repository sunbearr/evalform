<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<main>
        <section class="py-5">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Admin Panel</h2>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-lg-0">
                        <form method="get" action="<?= base_url('admin/'); ?>">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Enter your search..." name="search">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <a href="<?= base_url('admin/addedit/');?>" class="btn btn-primary">Add User</a>
                    </div>
                </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= esc($user['user_id']) ?></td>
                            <td><?= esc($user['username']) ?></td>
                            <td><?= esc($user['email']) ?></td>
                            <td><?= esc($user['phone']) ?></td>
                            <td><?= $user['status'] == 1 ? 'Active' : 'Inactive' ?></td> <!-- if status is 1 then user is active -->
                            <td>
                                <a class="btn btn-sm btn-info me-2" href="<?= base_url('surveys/'.$user['user_id']);?>"><i class="bi bi-eye-fill"></i></a>
                                <a class="btn btn-sm btn-primary me-2" href="<?= base_url('admin/addedit/'.$user['user_id']);?>"><i class="bi bi-pencil-fill"></i></a>
                                <a class="btn btn-sm btn-danger me-2" href="<?= base_url('admin/delete/' . $user['user_id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')"><i class="bi bi-trash-fill"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>        
                    </tbody>
                </table>
        
            </div>
        </section>

      </main>

<?= $this->endSection() ?>