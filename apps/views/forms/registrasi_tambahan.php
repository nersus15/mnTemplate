<!-- <h2></h2> -->
<fieldset>
    <h2>Informasi Tambahan Anda</h2>

    <div class="form-group">
        <label for="">Ceritakan tentang dirimu</label>
        <textarea name="tentang" id="tentang" cols="30" class="form-control" placeholder="Ceritakan tentang diri atau motto hidup anda disini" rows="3"></textarea>
    </div>
    <div class="prev-pp col-md-6" style="display: none;">
        <img style="cursor: pointer;" id="pp-preview" src="" alt="Photo profile" />
    </div>
    <div class="form-group">
        <div class="col-md-4">
            <div id="pp" class="profile-img">
                <label style="cursor: pointer;" id="file" class="file btn btn-xl btn-default">
                    Upload photo (Max. 5MB)
                    <input accept="image/*" id="pp-input" type="file" name="pp" />
                </label>
            </div>
        </div>
    </div>
    <!-- <button style="float: right; margin-bottom: 30px;" id="btn-add-org" class="btn btn-sm btn-primary btn-add"><i class="simple-icon-plus"></i> Add</button><br> -->

    <button type="button" class="btn btn-previous">Sebelumnya</button>
    <button type="submit" class="btn btn-submit">Simpan</button>
</fieldset>