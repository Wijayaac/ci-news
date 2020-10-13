<?= $this->extend('layout/template') ?>


<?= $this->section('content') ?>
<div class="container mx-5">
    <h2 class="text-center mt-5">Author Board</h2>
    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="alert alert-success text-center" role="alert">
            <?= session()->getFlashdata('pesan') ?>
        </div>
    <?php endif; ?>
    <div class="row ">

        <?php foreach ($about as $a) : ?>
            <div class="col-3">
                <div class="card shadow my-4">

                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><?= $a['nama'] ?></h6>
                    </div>

                    <div class="card-body">
                        <div class="text-center">
                            <img class="img-fluid px-3 px-sm-4 mt-3 mb-4 profile" src="asset/img/<?= $a['gambar'] ?>" alt="">
                        </div>
                        <a href="/<?= $a['slug'] ?>" class="btn btn-success btn-block btn-sm">Lihat Detail</a>

                    </div>


                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection() ?>