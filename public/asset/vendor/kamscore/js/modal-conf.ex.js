var modalConf = {
    "formlogin": {
        modalId: "modal-form-login",
        wrapper: ".generated-modals",
        opt: {
            type: 'form',
            ajax: true,
            rules: [
                {
                    name: 'noSpace',
                    method: function (value, element) { return value.indexOf(" ") < 0; },
                    message: "No space please",
                    field: 'user'
                }
            ],
            sebelumSubmit: function () {
                $('body').addClass('show-spinner');
                $('#login').prop('disabled', true);
            },
            submitSuccess: function (res) {
                $('body').removeClass('show-spinner');
                $('#login').prop('disabled', false);
                if (!res.data)
                    $('#' + modalConf.formlogin.opt.formOpt.formId + ' #alert_danger').html(res.massage).show();
                else {
                    if (res.data.role == 'pembeli' || res.data.role == 'pedagang')
                        window.location.reload();
                    else if (res.data.role == 'admin')
                        window.location.replace(path + '/admin');
                }
            },
            open: true,
            destroy: true,
            modalPos: 'right',
            saatBuka: () => {
                var token = $('meta[name="_token"]').attr('content');
                $("#" + modalConf.formregister.opt.formOpt.formId + " #token").val(token);
                $('#daftar').click(function () {
                    const { modalId, wrapper, opt } = modalConf.formregister;
                    UiHelper.generateModal(modalId, wrapper, opt);
                });


            },
            saatTutup: () => {
                $("#daftar").off('click');
            },
            formOpt: {
                enctype: 'multipart/form-data',
                formId: "form-login",
                formAct: "/api/login",
                formMethod: 'POST',
            },
            modalTitle: "Login",
            modalBody: {
                input: [
                    {
                        label: 'Username atau Email', placeholder: 'Masukkan Username atau Email',
                        type: 'text', name: 'user', id: 'user', attr: 'required'
                    },
                    {
                        label: 'Password', placeholder: 'Masukkan Password',
                        type: 'password', name: 'pass', id: 'pass', attr: 'required'
                    },
                    {
                        type: 'hidden', name: '_token', id: 'token'
                    }
                ],
                buttons: [
                    { type: 'button', text: 'Daftar', id: "daftar", class: "btn btn-empty" },
                    { type: 'submit', text: 'Masuk', id: "login", class: "btn btn btn-primary" }
                ],
            },
        }
    },
    "form_tambah_barang": {
        modalId: "modal-form-add-barang",
        wrapper: ".generated-modals",
        instance: {},
        opt: {
            rules: [
                {
                    name: 'batas',
                    method: function (value, element) { return value <= $('#stok').val(); },
                    message: "Batas beli harus kurang atau sama dengan stok",
                    field: 'batas_beli'
                }
            ],
            type: 'form',
            open: true,
            destroy: true,
            ajax: true,
            modalPos: 'right',
            saatBuka: () => {
                var token = $('meta[name="_token"]').attr('content');
                $("#" + modalConf.form_tambah_barang.opt.formOpt.formId + " #token").val(token);
                $("#stok").change(function () {
                    if (!$('#batas_beli').val())
                        $('#batas_beli').val($(this).val());
                });
            },
            sebelumSubmit: function () {
                $('#add').prop('disabled', true)
                $('body').addClass('show-spinner');
            },
            submitSuccess: (res) => {
                $('#add').prop('disabled', false);
                $('body').removeClass('show-spinner');
                if (res.err)
                    $('#' + modalConf.formlogin.opt.formOpt.formId + ' #alert_danger').html(`<p>${res.massage}</p>`).show();
                else
                    window.location.reload();
            },
            saatTutup: () => {
                $('body').removeClass('modal-open');
            },
            formOpt: {
                enctype: 'multipart/form-data',
                formId: "form-add-barang",
                formAct: "/api/product",
                formMethod: 'POST',
                formAttr: ''
            },
            modalTitle: "Tambah Barang",
            modalBody: {
                input: [
                    {
                        label: 'Nama Barang', placeholder: 'Masukkan Nama Barang',
                        type: 'text', name: 'nama_barang', id: 'nama_barang', attr: 'required'
                    },
                    {
                        label: 'Deskripsi', placeholder: 'Masukkan Deskripsi',
                        type: 'textarea', name: 'deskripsi', id: 'deskripsi'
                    },
                    {
                        label: 'Harga', placeholder: 'Masukkan harga',
                        type: 'number', name: 'harga', id: 'harga', attr: 'required'
                    },
                    {
                        label: 'Stok', placeholder: 'Masukkan stok',
                        type: 'number', name: 'stok', id: 'stok', attr: 'required'
                    },
                    {
                        label: 'Berat', placeholder: 'Masukkan berat dalam gram',
                        type: 'number', name: 'berat', id: 'berat'
                    },
                    {
                        label: 'Kategori', placeholder: 'Masukkan Kategori',
                        type: 'text', name: 'kategori', id: 'kategori',
                    },
                    {
                        label: 'Kondisi', type: 'select', name: 'kondisi', id: 'kondisi',
                        options: {
                            'baru': { text: 'Baru' },
                            'bekas': { text: 'Bekas' },
                        }
                    },
                    {
                        label: 'Batas Pembelian', placeholder: 'Masukkan Batas pembelian',
                        type: 'number', name: 'batas_beli', id: 'batas_beli'
                    },
                    {
                        type: 'hidden', name: '_token', id: 'token'
                    }
                ],
                buttons: [
                    { type: 'reset', data: 'data-dismiss="modal"', text: 'Batal', id: "batal", class: "btn btn btn-warning" },
                    { type: 'submit', text: 'Tambah', id: "add", class: "btn btn btn-primary" }
                ]
            },
        }
    },
    "formregister": {
        modalId: "modal-form-register",
        wrapper: ".generated-modals",
        instance: {},
        opt: {
            type: 'form',
            open: true,
            destroy: true,
            ajax: true,
            modalPos: 'right',
            saatBuka: () => {
                $('#' + modalConf.formlogin.modalId).modal('hide');
                setTimeout(function () {
                    $('body').addClass('modal-open');
                }, 1000);
            },
            sebelumSubmit: function () {
                $('body').addClass('show-spinner');
                $('#register').prop('disabled', true);
            },
            submitSuccess: function () {
                $('#register').prop('disabled', false);
                $('body').removeClass('show-spinner');
            },
            saatTutup: () => { },
            formOpt: {
                enctype: 'multipart/form-data',
                formId: "form-register",
                formAct: "/api/register",
                formMethod: 'POST',
                formAttr: ''
            },
            modalTitle: "Register",
            modalBody: {
                input: [
                    {
                        label: 'Nama lengkap', placeholder: 'Masukkan Nama lengkap',
                        type: 'text', name: 'nama_lengkap', id: 'nama_lengkap', attr: 'required'
                    },
                    {
                        label: 'Username', placeholder: 'Masukkan Username',
                        type: 'text', name: 'username', id: 'username', attr: 'required'
                    },
                    {
                        label: 'Email', placeholder: 'Masukkan Email',
                        type: 'email', name: 'email', id: 'email', attr: 'required'
                    },
                    {
                        label: 'Password', placeholder: 'Masukkan Password',
                        type: 'password', name: 'pass', id: 'pass', attr: 'required'
                    },
                    {
                        type: 'hidden', name: '_token', id: 'token'
                    }
                ],
                buttons: [
                    { type: 'reset', data: 'data-dismiss="modal"', text: 'Batal', id: "batal", class: "btn btn btn-warning" },
                    { type: 'submit', text: 'Daftar', id: "register", class: "btn btn btn-primary" }
                ]
            },
        }
    },
    "editkeranjang": {
        modalId: "modal-form-edit-tr",
        wrapper: ".generated-modals",
        instance: {},
        opt: {
            type: 'form',
            open: true,
            destroy: true,
            ajax: true,
            modalPos: 'right',
            saatTutup: () => { },
            submitSuccess: (res) => {
                UiHelper.addNotifItem('#notificationDropdown', [res.data]);
                $("#" + modalConf.keranjang.modalId).modal('hide');
                window.location.reload();
            },
            formOpt: {
                enctype: 'multipart/form-data',
                formId: "form-edit-tr",
                formAct: "/api/transaksi",
                formMethod: 'POST',
                formAttr: ''
            },
            modalBody: {
                buttons: [
                    { type: 'reset', data: 'data-dismiss="modal"', text: 'Batal', id: "batal", class: "btn btn btn-empty" },
                    { type: 'submit', text: 'Simpan', id: "simpan", class: "btn btn btn-outline-primary" }
                ]
            },
        }
    },
    'keranjang': {
        modalId: "keranjang",
        wrapper: ".generated-modals",
        opt: {
            size: 'modal-lg',
            type: 'custom',
            kembali: false,
            open: true,
            destroy: true,
            saatBuka: () => { },
            saatTutup: (e) => { },
            modalTitle: "Keranjang belanjaan anda",
            modalBody: {

            },
        }
    },
    "country-detail": {
        modalId: "country-detail",
        wrapper: ".generated-modals",
        opt: {
            size: 'modal-lg',
            type: 'card group',
            kembali: true,
            saatBuka: () => { },
            saatTutup: (e) => { },
            modalTitle: "Detail Country",
            modalBody: {
                cardDisplay: 'grid',
                card: [

                    {
                        id: 'total_tests',
                        styles: "background-color: #f2d411; color: white;",
                        images: [
                            { src: '/src/images/blood-test.svg', alt: 'total test icon', position: 'left', styles: 'width: 70px;' },
                        ]
                    },
                    {
                        id: 'total_cases',
                        styles: "background-color: #f74114; color: white",
                        images: [
                            { src: '/src/images/patient.svg', alt: 'total cases icon', position: 'left', styles: 'width: 70px;' },
                        ]
                    },
                    {
                        id: 'active_cases',
                        styles: "background-color: #eb265a; color: white",
                        images: [
                            { src: '/src/images/hospital-bed.svg', alt: 'active cases icon', position: 'left', styles: 'width: 70px;' },
                        ]
                    },
                    {
                        id: 'total_recovered',
                        styles: "background-color: #32cf0a; color: white",
                        images: [
                            { src: '/src/images/recovered.svg', alt: 'total recovered icon', position: 'left', styles: 'width: 70px;' },
                        ]
                    },
                    {
                        id: 'serious_critical',
                        styles: "background-color:#046e91; color: white",
                        images: [
                            { src: '/src/images/critical.svg', alt: 'serious critical icon', position: 'left', styles: 'width: 70px;' },
                        ]
                    },
                    {
                        id: 'total_deaths',
                        styles: "background-color: #910404; color: white",
                        images: [
                            { src: '/src/images/death.svg', alt: 'total deaths icon', position: 'left', styles: 'width: 70px;' },
                        ]
                    }
                ]
            }
        }
    }
}
// export default modalConf;




// Script Penting
// $(document).on('change', '.btn-file :file', function() {
//     var input = $(this),
//         label = input.val().replace(/\\/g, '/').replace(/.*\//, '');

//     input.trigger('fileselect', [label]);
//     });

//     $('.btn-file :file').on('fileselect', function(event, label) {

//     var input = $(this).parents('.input-group').find(':text'),
//         log = label;

//     if( input.length ) {
//         input.val(log);
//     } else {
//         if( log ) alert(log);
//     }

// });
// function readURL(input) {
//     window.file = input.files;
//         var reader = new FileReader();
//         reader.onloadend = function (e) {
//             console.log(e.target.result)
//         }
// }

// $("#inputFile").change(function(){
//     readURL(this);

// }); 