<div class="section">
    <div class="container" id="content">
        <div class="row">
            <?php if(isset($artikels) && !empty($artikels)):
                 foreach ($artikels as $artikel) : ?>
                <div class="col-12 col-lg-6 mb-4">
                    <div class="card flex-row mb-5 listing-card-container">
                        <div class="w-40 position-relative">
                            <a href="LandingPage.Blog.Image.html">
                                <img class="card-img-left" src="<?php echo base_url('public/img/thumbnail/' . $artikel['thumb']) ?>" alt="Thumbnail konten">
                            </a>
                        </div>
                        <div class="w-60 d-flex align-items-center">
                            <div class="card-body">
                                <a href="<?php echo base_url('artikel/baca/' . $artikel['id']) ?>">
                                    <h3 class="mb-4 listing-heading ellipsis"><?php echo $artikel['judul'] ?></h3>
                                </a>
                                <p class="listing-desc ellipsis"><?php echo $artikel['overview'] ?>
                                </p>
                                <footer>
                                    <p class="text-muted text-small mb-0 font-weight-light"><?php echo substr($artikel['created'], 0, 10) ?></p>
                                </footer>
                            </div>
                        </div>
                    </div>
                </div>
                 <?php endforeach; else: ?>
                    <h1>Tidak ada artikel</h1>
            <?php endif ?>
        </div>

    </div>
</div>