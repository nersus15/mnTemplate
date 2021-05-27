<div class="wrapper">
    <form action="<?= $action ?>" id="<?= $id ?>" method="POST">

        <h2></h2>
        <section>
            <div class="inner">
                <div style="padding: 5%;" class="image-holder">
                    <img src="<?php echo STATIC_PATH . '/img/logo/hipelmas.png' ?>" alt="">
                </div>
                <div class="form-content">
                    <div class="form-header">
                        <h3>Registrasi</h3>
                    </div>
                    <p>Masukkan Data Diri anda</p>
                    <div class="form-row">
                        <div class="form-holder">
                            <input name="nama" type="text" placeholder="Nama Lengkap" class="form-control">
                        </div>
                        <div class="form-holder">
                            <textarea name="alamat" class="form-control" id="" cols="30" rows="2" placeholder="Alamat"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-holder">
                            <input type="email" name="email" placeholder="Email" class="form-control">
                        </div>
                        <div class="form-holder">
                            <input name="hp" type="text" placeholder="Nomer Hp" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-holder">
                            <label for="">Agama</label>
                            <select name="agama" id="" class="form-control">
                                <option value="islam">Islam</option>
                                <option value="hindu">Hindu</option>
                                <option value="buda">Buda</option>
                                <option value="kristen protestan">Kristen Protestan</option>
                                <option value="kristen katolik">Kristen Katolik</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-holder" style="align-self: flex-end; transform: translateY(4px);">
                            <label for="">Jenis Kelamin</label>
                            <div class="checkbox-tick row ml-2">
                                <label class="male">
                                    <input type="radio" name="kelamin" value="L" checked> Laki - Laki<br>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="female">
                                    <input type="radio" name="kelamin" value="P"> Perempuan<br>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-holder">
                            <input type="number" name="tb" id="" placeholder="Tinggi badan dalam cm" class="form-control">
                        </div>
                        <div class="form-holder">
                            <input type="number" name="bb" id="" placeholder="Berat badan dalam Kg" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-holder" style="align-self: flex-end; transform: translateY(4px);">
                            <label for="">Golongan darah</label>
                            <div class="checkbox-tick row ml-2">
                                <label class="male">
                                    <input type="radio" name="darah" value="A" checked>A<br>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="female">
                                    <input type="radio" name="darah" value="B"> B<br>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="male">
                                    <input type="radio" name="darah" value="O" checked>O<br>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="female">
                                    <input type="radio" name="darah" value="AB"> AB<br>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- SECTION 1 -->
        <h2></h2>
        <section>
            <div class="inner">
                <div class="image-holder">
                    <img src="images/form-wizard-1.jpg" alt="">
                </div>
                <div class="form-content">
                    <div class="form-header">
                        <h3>Registration</h3>
                    </div>
                    <p>Please fill with your details</p>
                    <div class="form-row">
                        <div class="form-holder">
                            <input type="text" placeholder="First Name" class="form-control">
                        </div>
                        <div class="form-holder">
                            <input type="text" placeholder="Last Name" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-holder">
                            <input type="text" placeholder="Your Email" class="form-control">
                        </div>
                        <div class="form-holder">
                            <input type="text" placeholder="Phone Number" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-holder">
                            <input type="text" placeholder="Age" class="form-control">
                        </div>
                        <div class="form-holder" style="align-self: flex-end; transform: translateY(4px);">
                            <div class="checkbox-tick">
                                <label class="male">
                                    <input type="radio" name="gender" value="male" checked> Male<br>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="female">
                                    <input type="radio" name="gender" value="female"> Female<br>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="checkbox-circle">
                        <label>
                            <input type="checkbox" checked> Nor again is there anyone who loves or pursues or desires to obtaini.
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 2 -->
        <h2></h2>
        <section>
            <div class="inner">
                <div class="image-holder">
                    <img src="images/form-wizard-2.jpg" alt="">
                </div>
                <div class="form-content">
                    <div class="form-header">
                        <h3>Registration</h3>
                    </div>
                    <p>Please fill with additional info</p>
                    <div class="form-row">
                        <div class="form-holder w-100">
                            <input type="text" placeholder="Address" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-holder">
                            <input type="text" placeholder="City" class="form-control">
                        </div>
                        <div class="form-holder">
                            <input type="text" placeholder="Zip Code" class="form-control">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="select">
                            <div class="form-holder">
                                <div class="select-control">Your country</div>
                                <i class="zmdi zmdi-caret-down"></i>
                            </div>
                            <ul class="dropdown">
                                <li rel="United States">United States</li>
                                <li rel="United Kingdom">United Kingdom</li>
                                <li rel="Viet Nam">Viet Nam</li>
                            </ul>
                        </div>
                        <div class="form-holder"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 3 -->
        <h2></h2>
        <section>
            <div class="inner">
                <div class="image-holder">
                    <img src="images/form-wizard-3.jpg" alt="">
                </div>
                <div class="form-content">
                    <div class="form-header">
                        <h3>Registration</h3>
                    </div>
                    <p>Send an optional message</p>
                    <div class="form-row">
                        <div class="form-holder w-100">
                            <textarea name="" id="" placeholder="Your messagere here!" class="form-control" style="height: 99px;"></textarea>
                        </div>
                    </div>
                    <div class="checkbox-circle mt-24">
                        <label>
                            <input type="checkbox" checked> Please accept <a href="#">terms and conditions ?</a>
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>
            </div>
        </section>
        <button class="btn btn-primary" type="submit">KIRIM</button>
    </form>
</div>