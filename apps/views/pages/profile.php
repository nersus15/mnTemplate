<div class="container emp-profile">
    <div class="row">
        <div class="col-md-4">
            <div id="pp" class="profile-img">
                <a data-lightbox="pp" data-title="Tekan tombol esc untuk keluar" href="<?php echo STATIC_PATH . 'img/anggota/' . $user['photo'] ?>"><img style="cursor: pointer;" id="pp-preview" src="<?php echo STATIC_PATH . 'img/anggota/' . $user['photo'] ?>" alt="Photo profile" /></a>
                <label style="cursor: pointer;" id="file" class="file btn btn-lg btn-primary">
                    Change Photo (Max. 5MB)
                    <input accept="image/*" id="n-pp" type="file" name="pp" />
                </label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="profile-head">
                <h5>
                    <?php echo $user['nama'] ?> <small style="font-size: 60%;"><?php echo substr($user['created'], 0, 10) ?></small>
                </h5>
                <h6>
                    <?echo !empty($user['tentang']) ? $user['tentang'] : $user['status'] ?>
                </h6>
                <ul class="nav nav-tabs mt-4" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="bio-tab" data-toggle="tab" href="#bio" role="tab" aria-controls="bio" aria-selected="true">Data Pribadi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pend-tab" data-toggle="tab" href="#pend" role="tab" aria-controls="pend" aria-selected="false">Pendidikan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="org-tab" data-toggle="tab" href="#org" role="tab" aria-controls="org" aria-selected="false">Organisasi</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content bio-tab" id="myTabContent">
                <?php
                include_view('subviews/profile/bio', array('user' => $user));
                include_view('subviews/profile/pendidikan', array('riwayatPend' => $user['riwayat pendidikan']));
                include_view('subviews/profile/organisasi', array('riwayatorg' => $user['pengalaman organisasi']))
                ?>
            </div>
        </div>
    </div>
</div>