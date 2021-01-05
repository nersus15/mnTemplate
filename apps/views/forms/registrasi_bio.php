<!-- <h2></h2> -->
<fieldset>
    <h2>Biodata Anda</h2>
    <div class="form-group">
        <label for="nama">Nama lengkap</label>
        <input type="text" required name="nama" id="nama" class="form-control">
    </div>
    <div class="form-group">
        <label for="alamat">Alamat</label>
        <textarea name="alamat" required class="form-control" id="almat" cols="30" rows="2"></textarea>
    </div>
    <div class="form-group">
        <label for="emal">Email</label>
        <input type="email" required name="email" id="email" class="form-control">
    </div>
    <div class="form-group">
        <label for="hp">No. HP</label>
        <input type="text" required name="hp" id="hp" data-rule-number="true" class="form-control">
    </div>
    <div class="" style="display: flex; width: 100%">
        <div class="form-group">
            <label for="bb">Berat Badan</label>
            <input type="number" name="bb" min="1" placeholder="Berat badan dalam Kg" id="bb" class="form-control">
        </div>
        <div class="form-group" style="margin-left: 2%">
            <label for="tb">Tinggi Badan</label>
            <input type="number" name="tb" min="1" placeholder="Tinggi badan dalam cm" id="tb" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <label for="agama">Agama</label>
        <select required name="agama" id="agama" class="form-control">
            <option value="islam">Islam</option>
            <option value="hindu">Hindu</option>
            <option value="katolik">Kristen Katolik</option>
            <option value="protestan">Kristen Protestan</option>
        </select>
    </div>
    <div class="form-group">
        <label for="tl">Tempat Kelahiran</label>
        <input required type="text" name="tl" id="tl" class="form-control">
    </div>
    <div class="form-group">
        <label for="tgll">Tanggal Lahir</label>
        <input required placeholder="format: yyyy-mm-dd" type="text" name="tgll" class="form-control datepicker" id="tgl">
    </div>
    <!-- <div class="form-group"> -->
    <label for="kelamin">Jenis Kelamin</label><br>
    <div class="form-check-inline">
        <label class="form-check-label">
            <input type="radio" name="kelamin" class="form-check-input" value="L" checked>Laki-laki
        </label>
    </div>

    <div class="form-check-inline">
        <label class="form-check-label">
            <input type="radio" name="kelamin" class="form-check-input" value="P">Perempuan
        </label>
    </div>
    <!-- </div> -->
    <div class="form-group">
        <label for="darah">Golongan Darah</label>
        <select name="darah" id="darah" class="form-control">
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="O">O</option>
            <option value="AB">AB</option>
        </select>
    </div>
    <div class="f1-buttons">
        <button type="button" class="btn btn-next">Selanjutnya</button>
    </div>
</fieldset>