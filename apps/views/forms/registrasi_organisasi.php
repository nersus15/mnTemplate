<!-- <h2></h2> -->
<fieldset>
    <h2>Pengalaman Organisasi Anda</h2>
    <div id="wrapper-organisasi">
        <div class="template row">
            <div class="form-group org template-organisasi col-sm-4">
                <label for="organisasi">Nama organisasi</label>
                <input type="text" name="organisasi[]" id="organisasi-1" class="form-control">
            </div>
            <div class="form-group org template-organisasi col-sm-4">
                <label for="tahun">Tahun masuk</label>
                <input type="text" name="tahun[]" maxlength="4" minlength="4" id="tahun-1" data-date-yearonly="true" class="form-control datepicker">
            </div>
        </div>
    </div>
    <button type="button" style="float: right; margin-bottom: 30px;" id="btn-add-org" class="btn btn-sm btn-primary btn-add"><i class="simple-icon-plus"></i> Add</button><br>

    <button type="button" class="btn btn-previous">Sebelumnya</button>
    <button type="button" class="btn btn-next">Selanjutnya</button>

</fieldset>