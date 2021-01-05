<div class="row">
    <form id="form-create-content" class="col-12" action="<?php echo base_url('ws/content/post') ?>" method="post">
        <input type="hidden" name="judul" id="judul">
        <input type="hidden" name="overview" id="overview">
        <div class="row form-group col-12">
            <div class="form-group col-sm-4">
                <label for="">Jenis konten</label>
                <select name="jenis" id="jenis" class="form-control">
                    <option value="materi">Materi</option>
                    <option value="artikel">Artikel</option>
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="">Kategori</label>
                <input type="text" data-role="tagsinput" class="form-control" name="kategori" id="kategori">
            </div>
        </div>
        <div class="form-group">
            <label for="">Isi konten</label>
            <?php include_view('compui/utils/tiny-editor', array('tinyname' => $tinyname)) ?>
        </div>

        <div class="form-group">
            <label for="">Thumbnail konten</label>
            <div id="pp" class="profile-img">
                <label style="cursor: pointer;" id="file" class="file btn btn-xl btn-default">
                    Upload photo (Max. 5MB)
                    <input accept="image/*" id="pp-input" type="file" name="thumb" />
                </label>
            </div>
        </div>
        <div class="prev-pp form-group" style="display: none;">
            <img class="col-6" style="cursor: pointer;" id="pp-preview" src="" alt="Photo profile" />
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-sm mt-3 ml-3">Simpan</button>
        </div>
    </form>
</div>