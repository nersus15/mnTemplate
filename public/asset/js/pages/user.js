$(document).ready(function () {
    var data = persiapan_data();
    inisialisasi(data);
    eventHandler(data);
});

function persiapan_data() {
    var data = {};
    data.toastConfig = {
        wrapper: '.navbar',
        id: 'toast-form-user',
        delay: 3000,
        autohide: true,
        show: true,
        bg: 'bg-danger',
        textColor: 'text-white',
        time: waktu(null, 'HH:mm'),
        toastId: 'logout-error',
        title: 'Gagal, Terjadi kesalahan',
        type: 'danger',
        hancurkan: true
    }
    data.modalConf = {
        'detail-user': {
            modalId: "detail-user",
            wrapper: "body",
            opt: {
                size: 'modal-lg',
                type: 'custom',
                kembali: false,
                open: true,
                destroy: true,
                saatBuka: () => { },
                saatTutup: (e) => { },
                modalTitle: "Detail User",
                modalBody: {
                },
                modalFooter: [
                    // { type: 'button', text: 'Hapus', id: "btn-hapus", class: "btn btn-outline-danger" },
                    { type: 'button', text: 'Non aktifkan', id: "btn-nonaktif", class: "btn btn-outline-warning" },
                    { type: 'button', text: 'Edit', id: "btn-edit", class: "btn btn-primary" }
                ]
            }
        },

        "form-user": {
            modalId: 'modal-form-user',
            wrapper: 'body',
            opt: {
                type: 'form',
                kembali: false,
                destroy: true,
                open: true,
                ajax: true,
                modalTitle: '',
                modalPos: 'right',
                submitSuccess: function (res) {
                    $('#submit').prop('disabled', false);
                    $('#modal-form-user').modal('hide');
                    endLoading();

                    res = JSON.parse(res);
                    var toastOpt = data.toastConfig;

                    toastOpt.bg = 'bg-success';
                    toastOpt.title = 'Berhasil';
                    toastOpt.message = res.message;
                    makeToast(toastOpt);

                    inisialisasi(data);
                },
                submitError: function (res) {
                    $('#submit').prop('disabled', false);
                    $('#modal-form-user').modal('hide');
                    endLoading();

                    res = JSON.parse(res.responseText);
                    var toastOpt = data.toastConfig;

                    toastOpt.bg = 'bg-danger';
                    toastOpt.title = res.message;
                    toastOpt.message = res.err;
                    makeToast(toastOpt);
                    inisialisasi(data);
                },
                sebelumSubmit: function () {
                    $('#submit').prop('disabled', true);
                    showLoading();
                },
                rules: [
                    {
                        name: 'noSpace',
                        method: function (value, element) { return value.indexOf(" ") < 0; },
                        message: "Tidak boleh ada spasi",
                        field: 'username'
                    }
                ],
                formOpt: {
                    formId: "form-user",
                    formAct: path + "user/pos",
                    formMethod: 'POST',
                    formAttr: ''
                },
                modalBody: {
                    input: [
                        {
                            type: 'hidden', name: '_username', id: "_username"
                        },
                        {
                            type: 'hidden', name: 'id_info', id: 'id_info'
                        },
                        {
                            type: 'hidden', name: 'active', id: 'active', value: '1'
                        },
                        {
                            type: 'hidden', name: '_mode', id: '_mode', value: 'edit'
                        },
                        {
                            label: 'Nama Lengkap', placeholder: 'Masukkan nama lengkap',
                            type: 'text', name: 'nama_lengkap', id: 'nama_lengkap', attr: 'required'
                        },
                        {
                            label: 'Username', placeholder: 'Masukkan Username tanpa spasi',
                            type: 'text', name: 'username', id: 'username', attr: 'required'
                        },
                        {
                            label: 'Email', placeholder: 'Masukkan Email',
                            type: 'email', name: 'email', id: 'email', attr: 'required'
                        },

                        {
                            label: 'No Hp', placeholder: 'Masukkan Nomer Hp (Opsional)',
                            type: 'text', name: 'nohp', id: 'nohp'
                        },
                        {
                            label: 'Jabatan', placeholder: 'Masukkan jabatan (opsional)',
                            type: 'text', name: 'jabatan', id: 'jabatan'
                        },
                        {
                            label: 'Pilih Role', type: 'select', name: 'role', id: 'role',
                            options: {
                                'bendahara 1': { text: 'Bendahara 1' },
                                'bendahara 2': { text: 'Bendahara 2' },
                                'kepala sekolah': { text: 'Kepala Sekolah' },
                            }
                        }
                    ],
                    buttons: [
                        { type: 'reset', data: 'data-dismiss="modal"', text: 'Batal', id: "batal", class: "btn btn btn-warning" },
                        { type: 'submit', text: 'Simpan', id: "submit", class: "btn btn btn-primary" }
                    ]
                },
            }
        }
    }
    return data;
}
async function inisialisasi(data) {

    showLoading();
    await loaddata();
    options = {
        search: true,
        info: true,
        order: true,
        select: true,
        changeMenu: true,
        change: true,
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            {
                text: 'Tambah',
                action: function (e, dt, node, config) {
                    var configModal = data.modalConf['form-user'];
                    configModal.opt.modalTitle = 'Tambah data user';
                    configModal.opt.saatBuka = function () {
                        $('#_mode').val('baru');
                    }

                    generateModal(configModal.modalId, configModal.wrapper, configModal.opt);
                }
            },
            {
                text: 'Non aktifkan semua',
                action: function (e, dt, node, config) {
                    if (!confirm('Yakin ingin non aktifkan semua akun ?'))
                        return;

                    var ini = $(node);
                    ini.prop('disabled', true);
                    showLoading();
                    $.post(path + 'user/nonaktif/', function (res) {
                        $('#detail-user').modal('hide');
                        endLoading();

                        res = JSON.parse(res);
                        var toastOpt = data.toastConfig;

                        toastOpt.bg = 'bg-success';
                        toastOpt.title = 'Berhasil';
                        toastOpt.message = res.message;
                        makeToast(toastOpt);

                        inisialisasi(data);
                    }).fail(function (res) {
                        $('#detail-user').modal('hide');
                        endLoading();

                        res = JSON.parse(res.responseText);
                        var toastOpt = data.toastConfig;

                        toastOpt.bg = 'bg-danger';
                        toastOpt.title = res.message;
                        toastOpt.message = res.err;
                        makeToast(toastOpt);
                        inisialisasi(data);
                    });
                }
            }
        ],
        addCallback: true,
        callback: [
            {
                el: '#tbl-user tbody',
                evt: 'click',
                filterEL: 'tr',
                func: async function (evt) {
                    var params = evt.data;
                    var tabel = params.tabel;
                    var row = tabel.row(this).data();
                    var username = row[0];
                    var sanitasi = ['alamat', 'nama_lengkap', 'nohp'];


                    var user = await fetch(path + 'user/data/' + username).then(res => res.json()).then(res => {
                        return { 'user': res.users[0], 'permission': res.permission };
                    });

                    sanitasi.forEach(s => {
                        if (!user.user[s])
                            user.user[s] = '-';
                    });

                    configModal = data.modalConf['detail-user'];
                    configModal.opt.modalSubtitle = "Username: " + user.user.username;
                    configModal.opt.saatBuka = function () {
                        var text = user.user.isActive == '1' ? 'Non aktifkan' : 'Aktifkan';
                        $('#btn-nonaktif').text(text)
                        $('#btn-nonaktif').on('click', { 'user': user.user, 'text': text }, function (e) {
                            if (!confirm('Yakin ingin ' + e.data.text + ' akun ini?'))
                                return;

                            var ini = $(this);
                            ini.prop('disabled', true);
                            var username = e.data.user.username;
                            var mode = e.data.user.isActive == '1' ? 'nonaktif' : 'aktif';
                            showLoading();
                            $.post(path + 'user/aktif/' + username, { 'email': e.data.user.email, 'mode': mode }, function (res) {
                                $('#detail-user').modal('hide');
                                endLoading();

                                res = JSON.parse(res);
                                var toastOpt = data.toastConfig;

                                toastOpt.bg = 'bg-success';
                                toastOpt.title = 'Berhasil';
                                toastOpt.message = res.message;
                                makeToast(toastOpt);

                                inisialisasi(data);
                            }).fail(function (res) {
                                $('#detail-user').modal('hide');
                                endLoading();

                                res = JSON.parse(res.responseText);
                                var toastOpt = data.toastConfig;

                                toastOpt.bg = 'bg-danger';
                                toastOpt.title = res.message;
                                toastOpt.message = res.err;
                                makeToast(toastOpt);
                                inisialisasi(data);
                            });

                        })

                        $('#btn-edit').on('click', {}, function () {
                            var configModal = data.modalConf['form-user'];
                            configModal.opt.modalTitle = 'Edit data user';
                            configModal.opt.modalSubtitle = user.user.username;
                            configModal.opt.saatBuka = function () {
                                $('#_username').val(user.user.username);
                                $('#id_info').val(user.user.id);
                                $('#detail-user').modal('hide');
                                setTimeout(function () {
                                    $('body').addClass('modal-open');
                                }, 500);

                                var sanitasi = ['alamat', 'nama_lengkap', 'nohp', 'jabatan'];
                                sanitasi.forEach(s => {
                                    if (!user.user[s] || user.user[s] == '-')
                                        user.user[s] = '';
                                });

                                console.log($('#nama').val(user.user.nama_lengkap));
                                $('#nama_lengkap').val(user.user.nama_lengkap);
                                $('#username').val(user.user.username);
                                $('#email').val(user.user.email);
                                $('#nohp').val(user.user.nohp);
                                $('#jabatan').val(user.user.jabatan);
                                $('#role option[value="' + user.user.role + '"]').prop('selected', true).parent().trigger('change')
                            }

                            generateModal(configModal.modalId, configModal.wrapper, configModal.opt);
                        });
                    }
                    configModal.opt.modalBody.customBody = '<div class="row">' +
                        '<div class="col-md-5 img" id="wrapper-img">' +
                        '<img id="image" src="' + path + "/public/assets/img/profile/" + user.user.photo + '"  alt="" class="img-rounded">' +
                        '</div>' +
                        '<div class="col-md-6 details">' +
                        '<blockquote>' +
                        '<h5 id="nama">' + user.user.nama_lengkap.capitalize('all') + '</h5>' +
                        '<small><cite title="Source Title" id="alamat">' + user.user.alamat.capitalize('all') + '<i class="icon-map-marker"></i></cite></small><hr>' +
                        '</blockquote>' +
                        '<p id="detail">' +
                        'Email: ' + user.user.email + '<br>' +
                        'No Hp: ' + user.user.nohp + '<br>' +
                        'Role: ' + user.user.role + '<br>' +
                        '</p>' +
                        '</div>' +
                        '</div>';
                    generateModal(configModal.modalId, configModal.wrapper, configModal.opt)
                }
            }
        ]
    };
    initDatatable('#tbl-user', options);
}


function eventHandler() {

}

async function loaddata() {
    await fetch(path + 'user/list').then(res => res.json()).then(res => {

        if (!res.users)
            return;

        var rows = '';
        var data = res.users;
        var column = ['email', 'nohp', 'nama_lengkap', 'alamat'];

        data.forEach((d, i) => {
            column.forEach(c => {
                if (!d[c])
                    d[c] = '-';
            });
            rows += '<tr>' +
                '<td>' + d.username + '</td>' +
                '<td>' + d.email + '</td>' +
                '<td>' + d.nohp + '</td>' +
                '<td>' + d.nama_lengkap + '</td>' +
                '<td>' + d.alamat + '</td>' +
                '<td>' + d.role + '</td>' +
                '</tr>';
        });
        $('#tbl-user tbody').html(rows);
        endLoading();
    });
}