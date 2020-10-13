<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-8 mx-auto">
            <div class="card shadow my-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= $about['nama'] ?></h6>
                </div>

                <div class="card-body">
                    <div class="text-center">
                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4 profile" src="asset/img/<?= $about['gambar'] ?>" alt="">
                        <p><?= $about['bio'] ?></p>
                        <a href="/edit/<?= $about['slug'] ?>" class="btn btn-warning btn-sm text-center">Edit Author <i class="fas fa-edit"></i></a>
                        <form action="/<?= $about['id'] ?>" method="post" class="d-inline">
                            <?= csrf_field() ?>
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Apakah anda yakin ?');">Delete Author <i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>