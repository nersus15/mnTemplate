<?php
$data_head = array(
    'resource' => $resource,
    'extra_js' => isset($extra_js) ? $extra_js : null,
    'extra_css' => isset($extra_css) ? $extra_css : null,
    'includeTiny' => isset($includeTiny) ? $includeTiny : null,
    'thumb' => isset($data_content['thumb']) ? $data_content['thumb'] : null,
    'konten' => isset($data_content['konten']) ? $data_content['konten'] : null,
    'desc' => isset($data_content['desc']) ? $data_content['desc'] : null,
    'loadingAnim' => isset($loadingAnim) ? $loadingAnim : null,
    
);
include_view('header/main', $data_head);
?>
<div class="landing-page">
    <?php include_view('compui/navbar/dore.navbar-client-mobile') ?>
    <div class="main-container">
        <?php include_view('compui/navbar/dore.navbar-client') ?>
        <div class="content-container">
            <div class="section home subpage">
                <div class="container">
                    <div class="row home-row">
                        <div class="col-12 col-xl-5 col-lg-12 col-md-12">
                            <div class="home-text">
                                <div class="display-1">
                                    Tentang Hipelmas
                                </div>
                                <p class="white mb-5">
                                    Organisasi ini bernama Himpunan Pelajar & Mahasiswa Sukarara “HIPELMAS”
                                    Berdiri tahun 1998 di bentuk oleh sekelompok mahasiswa yang berasal dari
                                    Desa Sukarara Kecamatan Sakra Barat Kabupaten Lombok Timur -NTB,
                                    namun sempat vakum beberapa tahun hingga ahirnya berdiri kembali pada 28 Oktober 2014 di Pejeruk,
                                    Ampenan – Kota Mataram.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="btn btn-circle btn-outline-semi-light hero-circle-button scrollTo" href="#content" id="homeCircleButton"><i class="simple-icon-arrow-down"></i></a>
            </div>
            <?php
            if (isset($content) && !empty($content)) {
                if (is_array($content)) {
                    foreach ($content as $c) {
                        include_view($c, $data_content);
            ?>
                        <br>
            <?php }
                } else
                    include_view($content, $data_content);
            }
            ?>
             <div class="section background background-no-bottom mb-0">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 offset-0 col-lg-8 offset-lg-2 text-center">
                                <h1>Newsletter</h1>
                                <p>
                                    To receive our newsletter please complete the form below. We take your privacy
                                    seriously and we will not share your information with others. You can unsubscribe
                                    at any time.
                                </p>
                            </div>

                            <div class="col-12 offset-0 col-lg-6 offset-lg-3 newsletter-input-container">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="E-mail address">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary btn-xl" type="button">JOIN</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            <div class="section footer mb-0">
                <div class="container">
                    <div class="row footer-row">
                        <div class="col-12 text-right">
                            <a class="btn btn-circle btn-outline-semi-light footer-circle-button scrollTo" href="#home" id="footerCircleButton"><i class="simple-icon-arrow-up"></i></a>
                        </div>
                        <div class="col-12 text-center footer-content">
                            <a href="<?php echo BASEURL ?>">
                                <img class="footer-logo" alt="footer logo" src="<?php echo STATIC_PATH . 'img/logo/hipelmas.png' ?>" />
                            </a>
                        </div>
                    </div>
                </div>
                <div class="separator mt-5"></div>
                <div class="container copyright pt-5 pb-5">
                    <div class="row">
                        <div class="col-12"></div>
                        <div class="col-6">
                            <p class="mb-0">2020 © <?php echo str_replace('/', '', str_replace('https://', '', BASEURL)) ?></p>
                        </div>
                        <div class="col-6 text-right social-icons">
                            <ul class="list-unstyled list-inline">
                                <li class="list-inline-item">
                                    <a href="#"><i class="simple-icon-social-facebook"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#"><i class="simple-icon-social-twitter"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#"><i class="simple-icon-social-instagram"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
include_view('footer/main', array('resource' => $resource, 'extra_js' => isset($extra_js) ? $extra_js : null, 'extra_css' => isset($extra_css) ? $extra_css : null));
