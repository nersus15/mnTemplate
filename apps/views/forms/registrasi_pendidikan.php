<!-- <h2></h2> -->
<fieldset>
    <h2>Riwayat Pendidikan Anda</h2>
    <div id="wrapper-pend">
        <div class="template row">
            <div class="form-group pend template-pend col-sm-4">
                <label for="sekolah">Nama sekolah</label>
                <input type="text" name="sekolah[]" id="sekolah-1" class="form-control input-pend">
            </div>
            <div class="form-group pend template-pend col-sm-4">
                <label for="jurusan">Jurusan</label>
                <input type="text" name="jurusan[]" id="jurusan-1" placeholder="Opsional" class="input-pend form-control">
            </div>
            <div class="form-group pend template-pend col-sm-4">
                <label for="tipe">Jenis</label>
                <select name="tipe[]" id="jenis" class="form-control input-pend">
                    <option value="formal">Formal</option>
                    <option value="non formal">Non Formal</option>
                </select>
            </div>
            <div class="form-group pend template-pend col-sm-4">
                <label for="tahun">Tahun masuk</label>
                <input type="text" name="masuk[]" maxlength="4" minlength="4" id="masuk-1" data-date-yearonly="true" class="input-pend form-control datepicker">
            </div>
            <div class="form-group pend template-pend col-sm-4">
                <label for="tahun">Tahun keluar</label>
                <input type="text" placeholder="opsional"  name="keluar[]" maxlength="4" minlength="4" id="keluar-1" data-date-yearonly="true" class="form-control datepicker input-pend">
            </div>
        </div>
        <hr>
    </div>
    <button type="button" style="float: right; margin-bottom: 30px;" id="btn-add-pend" class="btn btn-sm btn-primary btn-add"><i class="simple-icon-plus"></i> Add</button><br>

    <div class="f1-buttons">
        <button type="button" class="btn btn-previous">Sebelumnya</button>
        <button type="button" class="btn btn-next">Selanjutnya</button>
    </div>
</fieldset>