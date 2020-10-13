<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <h4 class="my-4">Form Tambah About</h4>
            <form action="/pages/save" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input id="nama" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : '' ?>" type="text" name="nama" value="<?= old('nama') ?>" autofocus required>
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="nama">Bio</label>
                    <input id="nama" class="form-control" type="text" name="bio" value="<?= old('bio') ?>" required>
                </div>
                <div class="form-group">
                    <label for="gambar">Gambar</label>
                    <input id="gambar" class="form-control-file <?= ($validation->hasError('gambar')) ? 'is-invalid' : '' ?>" type="file" name="gambar" value="">
                    <div class="invalid-feedback">
                        <?= $validation->getError('gambar') ?>
                    </div>
                </div>
                <button class="btn btn-primary btn-block" type="submit">Save Data</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>