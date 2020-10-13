<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <h4 class="my-4">Form Edit About</h4>
            <form action="/pages/update/<?= $about['id'] ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <input type="hidden" name="slug" value="<?= $about['slug'] ?>">
                <input type="hidden" name="gambarLama" value="<?= $about['gambar'] ?>">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input id="nama" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : '' ?>" type="text" name="nama" value="<?= (old('nama')) ? old('nama') : $about['nama'] ?>" autofocus required>
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="nama">Bio</label>
                    <input id="nama" class="form-control" type="text" name="bio" value="<?= (old('bio')) ? old('bio') : $about['bio'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="gambar">Gambar</label>
                    <input id="gambar" class="form-control-file" type="file" name="gambar" value="">
                </div>
                <button class="btn btn-primary btn-block" type="submit">Ubah Data</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>