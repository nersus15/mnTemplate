$(document).ready(async function () {
    var data = await persiapan_data();

    add_eventlistener(data);
    inisialisasi(data);
});

async function tambahHandler(data) {
    var form = await fetch(path + 'uihelper/form?f=forms/form-barang').then(res => {
        if (res.status != 200)
            return;
        else
            return res.text()
    }).then(res => {
        if (!res)
            return;
        else {
            var opt = {
                type: 'form',
                clickToClose: false,
                kembali: false,
                destroy: true,
                open: true,
                ajax: true,
                size: 'modal-lg',
                modalTitle: 'Tambah data barang',
                modalPos: 'right',
                saatBuka: function () {
                    if (!$('body').hasClass('modal-open'))
                        $('body').addClass('modal-open');

                    data.modal_buka();
                },
                submitSuccess: function (res) {
                    $('#submit').prop('disabled', false);
                    $('#modal-form-tambah-siswa').modal('hide');
                    endLoading();

                    res = JSON.parse(res);
                    var toastOpt = data.toasCofig;
                    console.log(res);
                    console.log(data.toasCofig);
                    toastOpt.bg = 'bg-success';
                    toastOpt.title = 'Berhasil';
                    toastOpt.message = res.message;
                    makeToast(toastOpt);

                    data.loadData();

                    setTimeout(function () {
                        $('#batal').trigger('click');
                    }, 2000);
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
                    formId: "form-barang",
                    formAct: path + "barang/add",
                    formMethod: 'POST',
                    formAttr: ''
                },
                modalBody: {
                    input: [
                        {
                            type: 'custom', text: res,
                        },
                    ],
                    buttons: [
                        { type: 'reset', data: 'data-dismiss="modal"', text: 'Batal', id: "batal", class: "btn btn btn-warning" },
                        { type: 'button', text: 'kembali', id: "kembali", class: "btn btn btn-secondary" },
                        { type: 'submit', text: 'Simpan', id: "submit", class: "btn btn btn-primary" }
                    ]
                },
            }
            generateModal('form-modal-barang', 'body', opt)
        }
    });


}
async function persiapan_data() {
    var data = {
        thumb:{},
    };
    data.toasCofig = {
        wrapper: '#form-modal-barang',
        id: 'toast-barang',
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
    data.modal_buka = function (data) {
        $('#kembali').hide();

        $('#thumb').initDropzone({
            url: path + 'uihelper/upload',
            size: 160,
            eventListener: [
                {
                    "event": "success",
                    "func": function(file, res){
                        res = JSON.parse(res);
                        var thumb = $('#tlist').val();
                        var key = $('#tkey').val();
                        if(!thumb){
                            $('#tlist').val(res.img);
                            $('#tkey').val(res.key)                       
                        }
                        else{
                            $('#tlist').val(thumb + ',' + res.img);
                            $('#tkey').val(key + ',' + res.key);
                        }
                    }
                },
                {
                    "event": "removedfile",
                    func: function(file){
                        var thumb = $('#tlist').val();
                        var arrayThumb = thumb.split(',');
                        var key = $('#tkey').val();
                        var arrayKey = key.split(',');
                        var index = arrayKey.indexOf(file.name);

                        if(arrayThumb.length == 1){
                            $('#tlist').val(thumb.replace(arrayThumb[index], ''));
                            $('#tkey').val(key.replace(file.name, ''));
                        }
                        else if(arrayThumb.length > 1 && index > 0){
                            $('#tlist').val(thumb.replace(',' + arrayThumb[index], ''));
                            $('#tkey').val(key.replace(',' + file.name, ''));
                        }
                        else if(arrayThumb.length > 1 && index == 0){
                            $('#tlist').val(thumb.replace(arrayThumb[index] + ',', ''));
                            $('#tkey').val(key.replace(file.name + ',', ''));
                        }
                            
                        fetch(path + 'uihelper/delete_file/thumb/' + arrayThumb[index]);                      
                    }
                },
               
            ]
        }
        );
        $('#form-modal-barang').removeAttr('tabindex');
        $('#penjual').change(function () {
            if (!$(this).val())
                $('#tambah-penjual').prop('disabled', false)
            else
                $('#tambah-penjual').prop('disabled', true)

        });

        $('#tambah-penjual').click(function () {
            $('#halaman-2').show();
            $('#halaman-1').animate({ height: 'toggle' });

            setTimeout(function () {
                $('#halaman-1').hide();
            }, 500)

            if ($('#halaman-2').is(':visible'))
                $('#kembali').show();

            setTimeout(function () {
                $('body').addClass('modal-open');
            }, 500);
        });

        $('#kembali').click(function () {
            $('#halaman-1').show();
            $('#halaman-2').animate({ height: 'toggle' });


            setTimeout(function () {
                $('#halaman-2').hide();
            }, 500)

            if ($('#halaman-1').is(':visible'))
                $('#kembali').hide();

            setTimeout(function () {
                $('body').addClass('modal-open');
            }, 500);
        });

        $('.select2').select2({
            minimumInputLength: 3,
            ajax: {
                url: path + 'penjual/select2',
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: params.term
                    }
                    return query;
                },
                processResults: function (data) {
                    var hasil = [];
                    data.data.forEach(d => {
                        hasil.push({ id: d.id, text: d.nama_lengkap + ' - ' + d.alamat.substr(0, 20) + '...' });
                    });
                    return {
                        results: hasil
                    }
                }
            },
        });
    }

    data.loadData = async function (url = null) {
        showLoading();
        var url = !url ? path + 'barang/lists' : url;
        var barang = await fetch(url, { method: 'GET' }).then(res => res.json()).then(res => {
            if (!res.data)
                return;
            if ($.fn.DataTable.isDataTable('#dt-barang')) {
                $('#dt-barang').DataTable().clear();
                $('#dt-barang').DataTable().destroy();
            }

            var rows = '';
            var data = res.data;
            data.forEach((d, i) => {
                rows += '<tr>' +
                    '<td>' + d.nama.capitalize('first') + '</td>' +
                    '<td>' + d.kategori + '</td>' +
                    '<td>Rp. ' + d.harga.rupiahFormat() + '/ ' + d.satuan + '</td>' +
                    '<td>' + d.upenjual.capitalize('all') + '</td>' +
                    '</tr>';
            });
            $('#dt-barang tbody').html(rows);
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
                    attr: { 'class': 'btn btn-primary' },
                    text: 'Tambah',
                    action: async function (e, dt, node, config) {
                        $(node).prop('disabled', true);
                        await tambahHandler(data);
                        $(node).prop('disabled', false);
                    }
                },
                {
                    attr: { 'class': 'btn btn-primary' },
                    text: 'Import data',
                    action: async function (e, dt, node, config) {
                        $(node).prop('disabled', true);
                        await importHandler(data);
                        $(node).prop('disabled', false);
                    }
                }
            ],
        };
        initDatatable('#dt-barang', options);

    }
    return data;
}


function add_eventlistener(data) {

}


function inisialisasi(data) {
    data.loadData();
}