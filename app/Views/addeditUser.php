<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <h2 class="text-center mb-4"><?= isset($user) ? 'Edit User' : 'Add User' ?></h2>
                <form method="post" action="<?= base_url('admin/addedit' . (isset($user) ? '/' . $user['user_id'] : '')) ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="username" class="form-label">Name</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= isset($user) ? esc($user['username']) : '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= isset($user) ? esc($user['email']) : '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="<?= isset($user) ? esc($user['phone']) : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="url" class="form-label">URL</label>
                        <input type="url" class="form-control" id="url" name="url" value="<?= isset($user) ? esc($user['url']) : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value= 1 <?= isset($user) && $user['status'] === 1 ? 'selected' : '' ?>>Active</option>
                            <option value= 0 <?= isset($user) && $user['status'] === 0 ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary"><?= isset($user) ? 'Update User' : 'Add User' ?></button>
                </form>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>