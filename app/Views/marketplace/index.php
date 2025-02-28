<?= view('template/pages'); ?>

<div class="container">
    <div id="carouselExampleFade" class="carousel slide carousel-fade mt-5">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="<?= base_url('public/assets/images/1.png') ?>" class="d-block w-100" alt="Carousel 1">
            </div>
            <div class="carousel-item">
                <img src="<?= base_url('public/assets/images/2.png') ?>" class="d-block w-100" alt="Carousel 2">
            </div>
            <div class="carousel-item">
                <img src="<?= base_url('public/assets/images/3.png') ?>" class="d-block w-100" alt="Carousel 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<div class="container mt-4">
    <div class="row text-center kategori-menu">
        <div class="col-3 col-md-2">
            <a href="#" class="kategori-item">
                <img src="<?= base_url('public/assets/images/Food.png') ?>" alt="Makanan">
                <p>Makanan</p>
            </a>
        </div>
        <div class="col-3 col-md-2">
            <a href="#" class="kategori-item">
                <img src="<?= base_url('public/assets/images/Sneakers.png') ?>" alt="Sepatu">
                <p>Sepatu</p>
            </a>
        </div>
        <div class="col-3 col-md-2">
            <a href="#" class="kategori-item">
                <img src="<?= base_url('public/assets/images/accessories.png') ?>" alt="Aksesoris">
                <p>Aksesoris</p>
            </a>
        </div>
        <div class="col-3 col-md-2">
            <a href="#" class="kategori-item">
                <img src="<?= base_url('public/assets/icons/electronics.png') ?>" alt="Elektronik">
                <p>Elektronik</p>
            </a>
        </div>
        <div class="col-3 col-md-2">
            <a href="#" class="kategori-item">
                <img src="<?= base_url('public/assets/icons/groceries.png') ?>" alt="Makanan">
                <p>Makanan</p>
            </a>
        </div>
        <div class="col-3 col-md-2">
            <a href="#" class="kategori-item">
                <img src="<?= base_url('public/assets/icons/furniture.png') ?>" alt="Furniture">
                <p>Furniture</p>
            </a>
        </div>
    </div>
</div>