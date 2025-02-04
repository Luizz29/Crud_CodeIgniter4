<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h2>Registrasi Pengguna</h2>
    
    <?php if (isset($validation)): ?>
        <div class="alert alert-danger">
            <?= $validation->listErrors() ?>
        </div>
    <?php endif; ?>

    <form method="post" action="/register/register">
        <?= csrf_field() ?>
        
        <div class="form-group">
            <label for="username">Nama Pengguna</label>
            <input type="text" name="username" id="username" class="form-control" value="<?= old('username') ?>" required>
        </div>

        <div class="form-group">
            <label for="password">Kata Sandi</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Daftar</button>
    </form>
</div>
<?= $this->endSection() ?>
