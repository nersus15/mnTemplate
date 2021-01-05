<nav class="landing-page-nav">
    <div class="container d-flex align-items-center justify-content-between">
        <a class="navbar-logo pull-left" href="LandingPage.Home.html">
            <span class="white"></span>
            <span class="dark"></span>
        </a>
        <ul class="navbar-nav d-none d-lg-flex flex-row">
            <li class="nav-item">
                <a href="<?php echo base_url('artikel') ?>">Artikel</a>
            </li>
            <li class="nav-item ">
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Materi
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="LandingPage.Docs.html">Programming</a>
                        <a class="dropdown-item" href="LandingPage.Videos.html">Teknik Sipil</a>
                        <a class="dropdown-item" href="LandingPage.Contact.html">Hukum</a>
                    </div>
                </div>
            </li>
            <li class="nav-item mr-3">
                <a id="login-d" href="">SIGN IN</a>
            </li>
        </ul>
        <a href="#" class="mobile-menu-button">
            <i class="simple-icon-menu"></i>
        </a>
    </div>
</nav>