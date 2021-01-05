<div class="tab-pane fade" id="org" role="tabpanel" aria-labelledby="org-tab">
    <?php foreach ($riwayatorg as $organissasi) : ?>
        <div class="row">
            <div class="col-md-3">
               <label for=""><?php echo $organissasi['tahun']?></label>
            </div>
            <div class="col-md-6">
                <p class="text-info"><?php echo $organissasi['organisasi'] . " " ?></p>
            </div>
        </div>
        <hr>
    <?php endforeach ?>
</div>