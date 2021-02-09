$(document).ready(function () {
    var data = persiapan_data()
    add_EventListener(data);
    inisialisasi(data);
});

function persiapan_data() {
    var data = {};
    data.toasCofig = {
        wrapper: '.navbar',
        id: 'toast-siswa',
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
        "import-data": {
            modalId: 'modal-form-tambah-user',
            wrapper: 'body',
            opt: {
                type: 'custom',
                kembali: false,
                destroy: true,
                size: 'modal-lg',
                open: true,
                ajax: true,
                modalTitle: 'Import data siswa dari excel',
                modalPos: 'def',
                sebelumSubmit: function () {
                    $('#submit').prop('disabled', true);
                    showLoading();
                },
                saatBuka: function () {
                    $('.dropzone').dropzone({
                        url: path + 'helper/import',
                        addRemoveLinks: true,
                        error: function (res) {
                            var configToast = data.toasCofig;
                            var res = JSON.parse(res.xhr.responseText);
                            configToast.id = "upload-err";
                            configToast.toastId = "upload-err";
                            configToast.message = res.err;
                            configToast.title = res.message;
                            configToast.wrapper = '.modal';
                            makeToast(configToast);

                        },
                        success: function(res){
                            var configToast = data.toasCofig;
                            var res = JSON.parse(res.xhr.responseText);
                            configToast.id = "upload-success";
                            configToast.toastId = "upload-success";
                            configToast.bg = 'bg-success';
                            configToast.message = res.message;
                            configToast.title = 'Berhasil';
                            configToast.wrapper = '.modal';
                            makeToast(configToast);
                        },
                        
                    });
                },
                formOpt: {
                    formId: "form-user",
                    formAct: path + "user/pos",
                    formMethod: 'POST',
                    formAttr: ''
                },
                modalBody: {
                    customBody:
                     '<div class="alert alert-warning alert-dismissible fade show" role="alert">' +
                        '<strong>Perhatian: Ketika di drop atau dipilih, file akan langsung di upload</strong>' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                            '<span aria-hidden="true">&times;</span>'+
                        '</button>'+
                    '</div>' +
                    '<h5 class="mb-4">Pilih atau drop file excel</h5><form action="' + path + 'helper/"><div style="height:auto" class="dropzone"></div></form>' +
                    '<div class="form-group"> <p class="text-info">Untuk contoh format file excel silahkan download <a target="_blank" href="'+ path + 'public/docs/formatdatasiswa.xlsx' +'">disini</a></div>'
                    ,
                },
            }
        },
        "tambah-siswa": {
            modalId: 'modal-form-tambah-siswa',
            wrapper: 'body',
            opt: {
                type: 'form',
                kembali: false,
                destroy: true,
                open: true,
                ajax: true,
                modalTitle: 'Tmbah data siswa',
                modalPos: 'right',
                saatBuka: function(){
                    if(!$('body').hasClass('modal-open'))
                        $('body').addClass('modal-open');
                },
                submitSuccess: function (res) {
                    $('#submit').prop('disabled', false);
                    $('#modal-form-tambah-siswa').modal('hide');
                    endLoading();

                    res = JSON.parse(res);
                    var toastOpt = data.toasCofig;

                    toastOpt.bg = 'bg-success';
                    toastOpt.title = 'Berhasil';
                    toastOpt.message = res.message;
                    makeToast(toastOpt);
                },
                submitError: function (res) {
                    $('#submit').prop('disabled', false);
                    $('#modal-form-tambah-siswa').modal('hide');
                    endLoading();

                    res = JSON.parse(res.responseText);
                    var toastOpt = data.toasCofig;

                    toastOpt.bg = 'bg-danger';
                    toastOpt.title = res.message;
                    toastOpt.message = res.err;
                    makeToast(toastOpt);
                },
                sebelumSubmit: function () {
                    $('#submit').prop('disabled', true);
                    showLoading();
                },
                formOpt: {
                    formId: "form-siswa",
                    formAct: path + "siswa/add",
                    formMethod: 'POST',
                    formAttr: ''
                },
                modalBody: {
                    input: [
                        {
                            label: 'Nama Nomer Induk Siswa (NIS)',attr: 'autocomplete="off" required', placeholder: 'Masukkan NIS',
                            type: 'text', name: 'nis', id: 'nis',
                        },
                        {
                            label: 'Nama Lengkap', placeholder: 'Masukkan Lengkap',
                            type: 'text', name: 'nama', id: 'nama', attr: 'required'
                        },
                        {
                            label: 'Alamat', placeholder: "Alamat lengkap", id: "alamat",
                            name: 'alamat', type: 'textarea'
                        },
                        {
                            label: 'Angkatan', placeholder: 'Masukkan Angkatan',
                            type: 'text', name: 'angkatan', id: 'angkaten', attr: 'required'
                        },

                        {
                            label: 'Kelas', attr: 'autocomplete="off"', placeholder: 'Masukkan kelas',
                            type: 'text', name: 'kelas', id: 'kelas'
                        },
                        {
                            label: 'Pilih Kelamin', type: 'select', name: 'kelamin', id: 'kelamin',
                            options: {
                                'P': { text: 'Perempuan' },
                                'L': { text: 'Laki-laki' },
                            }
                        },
                        
                    ],
                    buttons: [
                        { type: 'reset', data: 'data-dismiss="modal"', text: 'Batal', id: "batal", class: "btn btn btn-warning" },
                        { type: 'submit', text: 'Simpan', id: "submit", class: "btn btn btn-primary" }
                    ]
                },
            }
        }
    };
    data.load_data = async function (url = null) {
        showLoading();
        var url = !url ? path + 'helper/siswa' : url;
        var siswa = await fetch(url, { method: 'GET' }).then(res => res.json()).then(res => {
            if (!res.data)
                return;
            if ($.fn.DataTable.isDataTable('#tbl-siswa')) {
                $('#tbl-siswa').DataTable().clear();
                $('#tbl-siswa').DataTable().destroy();
            }

            var rows = '';
            var data = res.data;
            var column = ['nomerInduk', 'nama', 'alamat', 'kelas', 'angkatan', 'kelamin'];

            data.forEach((d, i) => {
                column.forEach(c => {
                    if (!d[c])
                        d[c] = '-';
                });
                if (d.kelamin != '-')
                    d.kelamin = d.kelamin == 'P' ? 'Perempuan' : 'Laki-laki';
                rows += '<tr>' +
                    '<td>' + d.nomerInduk + '</td>' +
                    '<td>' + d.nama + '</td>' +
                    '<td>' + d.alamat + '</td>' +
                    '<td>' + d.kelas + '</td>' +
                    '<td>' + d.angkatan + '</td>' +
                    '<td>' + d.kelamin + '</td>' +
                    '</tr>';
            });
            $('#tbl-siswa tbody').html(rows);
            endLoading();
            return res.data;
        });
        var options = {
            search: true,
            info: true,
            order: true,
            select: true,
            changeMenu: false,
            change: false,
            responsive: true,
            dom: 'Bfrtip',
            dom: 'Bfrtip',
            buttons: [
                {
                    text: 'Tambah',
                    action: async function (e, dt, node, config) {
                        $(node).prop('disabled', true);
                        await tambahHandler(data);
                        $(node).prop('disabled', false);
                    }
                },
                {
                    text: 'Import data',
                    action: async function (e, dt, node, config) {
                        $(node).prop('disabled', true);
                        await importHandler(data);
                        $(node).prop('disabled', false);
                    }
                }
            ],
        };
        initDatatable('#tbl-siswa', options);
        // data.siswa = siswa;
    }
    return data;
}
function tambahHandler(data) {
    var configModal = data.modalConf['tambah-siswa'];
    generateModal(configModal.modalId, configModal.wrapper, configModal.opt);
}

function importHandler(data) {
    var configModal = data.modalConf['import-data'];
    generateModal(configModal.modalId, configModal.wrapper, configModal.opt);

}
function add_EventListener(data) {
    $('#kelas').change(function () {
        var ini = $(this);
        var kelas = ini.val();
        var angkatan = $('#angkatan').val();
        var url = path + 'helper/siswa?k=' + kelas + '&a=' + angkatan;
        data.load_data(url);
    });

    $('#angkatan').change(function () {
        var ini = $(this);
        var angkatan = ini.val();
        var kelas = $('#kelas').val();
        var url = path + 'helper/siswa?k=' + kelas + '&a=' + angkatan;
        data.load_data(url);
    });
}
function inisialisasi(data) {
    data.load_data();
}