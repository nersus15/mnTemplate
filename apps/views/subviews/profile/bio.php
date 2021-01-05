<div class="tab-pane fade show active" id="bio" role="tabpanel" aria-labelledby="bio-tab">
    <div class="row">
        <div class="col-md-6">
            <label>Nama Lengkap</label>
        </div>
        <div class="col-md-6">
            <p class="text-info"><?php echo $user['nama'] ?></p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <label>Alamat</label>
        </div>
        <div class="col-md-6">
            <p class="text-info"><?php echo $user['alamat'] ?></p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <label>Tempat, tanggal lahir</label>
        </div>
        <div class="col-md-6">
            <p class="text-info"><?php echo $user['tgl_lahir'] ==  '0000-00-00' ? $user['tempat_lahir'] . ', -' :  $user['tempat_lahir'] . ", " .  $user['tgl_lahir'] ?></p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <label>email</label>
        </div>
        <div class="col-md-6">
            <p class="text-info"><?php echo $user['email'] ?></p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <label>No Hp</label>
        </div>
        <div class="col-md-6">
            <p class="text-info"><?php echo $user['nohp'] ?></p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <label for="">Agama</label>
        </div>
        <div class="col-md-6">
            <p class="text-info"><?php echo $user['agama'] ?></p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <label for="">Golongan darah</label>
        </div>
        <div class="col-md-6">
            <p class="text-info"><?php echo $user['darah'] ?></p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <label for="">Berat/ Tinggi Badan</label>
        </div>
        <div class="col-md-6">
            <p class="text-info"><?php echo $user['bb'] . ' Kg/ ' . $user['tinggi'] . ' cm' ?></p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <label>Jenis Kelamin</label>
        </div>
        <div class="col-md-6">
            <p class="text-info"><?php echo  $user['kelamin'] == 'L' ? "Laki-laki" : "Perempuan" ?></p>
        </div>
    </div>
    <hr>
</div>