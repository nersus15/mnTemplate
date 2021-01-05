<div class="tab-pane fade" id="pend" role="tabpanel" aria-labelledby="pend-tab">
    <?php foreach ($riwayatPend as $sekolah) : ?>
        <div class="row">
            <div class="col-md-3">
               <label for=""><?php echo $sekolah['tahun_masuk']?> - <?php echo !empty($sekolah['tahun_keluar']) && $sekolah['tahun_keluar'] != '0000' && $sekolah['tahun_keluar'] != $sekolah['tahun_masuk'] ? $sekolah['tahun_keluar'] : 'Sekarang'  ?></label>
            </div>
            <div class="col-md-6">
                <p class="text-info"><?php echo $sekolah['tempat'] . " " ?><sup><?php echo $sekolah['tipe'] ?></sup><?php echo !empty($sekolah['jurusan']) ? ", " . $sekolah['jurusan'] . " " : ", " . null ?></p>
            </div>
        </div>
        <hr>
    <?php endforeach ?>
</div>