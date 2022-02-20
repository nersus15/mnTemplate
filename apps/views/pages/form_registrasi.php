<style>
    .wrapper {
        padding-bottom: 2%;
        width: 90%;
        margin-left: 5%;
        display: flex;
        justify-content: center;
        background-color: #976D7E;
    }

    .wizard-content {
        justify-content: center;
        width: 100%;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }
</style>
<div class="wrapper">
    <div class="row wizard-content">
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2 form-box">
            <form id="hipelmas-registrasi" role="form" action="<?php echo BASEURL . 'ws/auth/register' ?>" method="post" class="f1">
                <h3>Register To Our App</h3>
                <p><?php echo empty($tokenCheckerMessage) ? 'Fill in the form to get instant access' : $tokenCheckerMessage  ?></p>
                <div class="f1-steps">
                    <div class="f1-progress">
                        <div class="f1-progress-line" data-now-value="16.66" data-number-of-steps="3" style="width: 16.66%;"></div>
                    </div>
                    <div class="f1-step active">
                        <div class="f1-step-icon"><i class="simple-icon-user"></i></div>
                        <p></p>
                    </div>
                    <div class="f1-step">
                        <div class="f1-step-icon"><i class="simple-icon-notebook"></i></div>
                        <p></p>
                    </div>
                    <div class="f1-step">
                        <div class="f1-step-icon"><i class="simple-icon-organization"></i></div>
                        <p></p>
                    </div>
                    <div class="f1-step">
                        <div class="f1-step-icon"><i class="simple-icon-user-follow"></i></div>
                        <p></p>
                    </div>
                </div>
                <?php
                    include_view('forms/registrasi_bio');
                    include_view('forms/registrasi_pendidikan');
                    include_view('forms/registrasi_organisasi');
                    include_view('forms/registrasi_tambahan');
                ?>
            </form>
        </div>
    </div>
</div>


<div class="section footer" style="background: transparent;z-index: 99;width: 100%;margin-top: 39px;margin-bottom: 0px;bottom: 100%;position: static;">
    <div class="separator mt-5 mb-2"></div>
    <h6 class="mt-2"> 2020 © <?php echo str_replace('/', '', str_replace('https://', '', BASEURL)) ?> </h6>
    <!-- <p> <strong> develop by fathurrahman@kamscode.tech </strong></p> -->
</div>