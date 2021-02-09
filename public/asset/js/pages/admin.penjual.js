$(document).ready(async function () {
    var data = await persiapan_data();
    add_eventlistener(data);
    inisialisasi(data);
});

async function tambahHandler(data) {
    var form = await fetch(path + 'uihelper/form?f=forms/sub/penjual').then(res => {
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
                modalTitle: 'Tambah data penjual',
                modalPos: 'right',
                saatBuka: function () {
                    if (!$('body').hasClass('modal-open'))
                        $('body').addClass('modal-open');

                    data.modal_buka();
                },
                submitSuccess: function (res) {
                    $('#submit').prop('disabled', false);
                    $('#form-modal-penjual').modal('hide');
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
                    $('#form-modal-penjual').modal('hide');
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
                    formId: "form-penjual",
                    formAct: path + "penjual/tambah",
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
                        { type: 'submit', text: 'Simpan', id: "submit", class: "btn btn btn-primary" }
                    ]
                },
            }
            generateModal('form-modal-penjual', 'body', opt)
        }
    });


}
async function persiapan_data() {
    var data = {
        thumb:{},
    };
    data.toasCofig = {
        wrapper: '#form-modal-penjual',
        id: 'toast-penjual',
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
    data.addModalOpen = function(){
        $('.modal, button, label').click(function(e){
            e.preventDefault();
            console.log("O2K");
            setTimeout(function(){
                if (!$('body').hasClass('modal-open'))
                    $('body').addClass('modal-open');
            }, 50);
        });
    };
    data.modal_buka = function (data) {
        $('#pp').initDropzone({
            url: path + 'uihelper/upload/gambar/profile',
            size: 160,
            eventListener: [
                {
                    "event": "success",
                    "func": function(file, res){
                        res = JSON.parse(res);
                        var thumb = $('#plist').val();
                        var key = $('#pkey').val();
                        if(!thumb){
                            $('#plist').val(res.img);
                            $('#pkey').val(res.key)                       
                        }
                        else{
                            $('#plist').val(thumb + ',' + res.img);
                            $('#pkey').val(key + ',' + res.key);
                        }
                    }
                },
                {
                    "event": "removedfile",
                    func: function(file){
                        var thumb = $('#plist').val();
                        var arrayThumb = thumb.split(',');
                        var key = $('#pkey').val();
                        var arrayKey = key.split(',');
                        var index = arrayKey.indexOf(file.name);

                        if(arrayThumb.length == 1){
                            $('#plist').val(thumb.replace(arrayThumb[index], ''));
                            $('#pkey').val(key.replace(file.name, ''));
                        }
                        else if(arrayThumb.length > 1 && index > 0){
                            $('#plist').val(thumb.replace(',' + arrayThumb[index], ''));
                            $('#pkey').val(key.replace(',' + file.name, ''));
                        }
                        else if(arrayThumb.length > 1 && index == 0){
                            $('#plist').val(thumb.replace(arrayThumb[index] + ',', ''));
                            $('#pkey').val(key.replace(file.name + ',', ''));
                        }
                            
                        fetch(path + 'uihelper/delete_file/profile/' + arrayThumb[index]);                      
                    }
                },
               
            ]
        });
        $('#form-modal-penjual').removeAttr('tabindex');
        $('#penjual').change(function () {
            if (!$(this).val())
                $('#tambah-penjual').prop('disabled', false)
            else
                $('#tambah-penjual').prop('disabled', true)

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
        var url = !url ? path + 'penjual/lists' : url;
        var penjual = await fetch(url, { method: 'GET' }).then(res => res.json()).then(res => {
            if (!res.data)
                return;
            if ($.fn.DataTable.isDataTable('#dt-penjual')) {
                $('#dt-penjual').DataTable().clear();
                $('#dt-penjual').DataTable().destroy();
            }

            var rows = '';
            var data = res.data;
            data.forEach((d, i) => {
                rows += '<tr>' +
                    '<td>' + d.username.capitalize('first') + '</td>' +
                    '<td>' + d.nama_lengkap.capitalize('first') + '</td>' +
                    '<td>. ' + d.alamat + '</td>' +
                    '<td>. ' + d.nohp + '</td>' +
                    '<td>' + d.email + '</td>' +
                    '<td>' + d.keterangan + '</td>' +
                    '<td>' + d.photo + '</td>' +
                    '</tr>';
            });
            $('#dt-penjual tbody').html(rows);
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
        initDatatable('#dt-penjual', options);
        data.penjual = penjual;
    }
    return data;
}


function add_eventlistener(data) {

}


function inisialisasi(data) {
    data.loadData();
}