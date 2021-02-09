$(document).ready(function () {
    addEventListener();
    inisialisasi();
});

function addEventListener() {
    $('#jenis-transaksi').change(function () {
        var ini = $(this);
        var value = ini.val();
        var jenisTr = ['M01', 'M02', 'M03'];
        var sumber = $('#sumber');
        var siswa = $('#siswa');

        if (jenisTr.includes(value)) {
            sumber.hide();
            siswa.show();
            siswa.next().show();
            sumber.prop('required', false);
            siswa.prop('required', true);
        } else {
            sumber.show();
            siswa.hide();
            siswa.next().hide();
            sumber.prop('required', true);
            siswa.prop('required', false);
        }

    });
}

function inisialisasi() {
    var toastConfig = {
        wrapper: '.navbar',
        id: 'toast-error-login',
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
    var options = {
        sebelumSubmit: function () {
            showLoading();
            $('#btn-simpan').prop('disabled', true);
        },

        submitSuccess: function (res) {
            endLoading();
            $('#btn-simpan').prop('disabled', false);
            res = JSON.parse(res);
            var options = toastConfig;
            options.id = 'success-transaksi-masuk';
            options.message = res.message;
            options.bg = 'bg-success';
            options.title = 'Berhasil'
            makeToast(options);

            var saldo = $('#saldo-sekarang').text();
            saldo = saldo.replace('Rp. ', '')
            saldo = saldo.replaceAll('.', '');
            saldo = saldo.replace(',00', '');
            var saldoSekarang = $('input[name="_jenis"]').val() == 'masuk' ? parseInt(saldo) + parseInt(res.data) : parseInt(saldo) - parseInt(res.data);

            $('#saldo-sekarang').text('Rp. ' + saldoSekarang.toString().rupiahFormat() + ',00');

        },

        submitError: function (err) {
            endLoading();
            var response = JSON.parse(err.responseText);
            var options = toastConfig;
            options.toastId = 'err-transaksi-masuk';
            options.message = response.message;
            options.bg = 'bg-danger';
            options.title = response.type;


            $('#btn-simpan').prop('disabled', false);

            makeToast(options);
        },
    }
    $('.select2').select2({
        minimumInputLength: 3,
        ajax: {
            url: path + 'helper/siswa/select2',
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
                    hasil.push({ id: d.nomerInduk, text: d.nomerInduk + ' - ' + d.nama + '(' + d.angkatan + ' - ' + d.kelas + ')' });
                });
                console.log(hasil);
                return {
                    results: hasil
                }
            }
        },
    });
    $('.datepicker').datepicker({
        'format': 'yyyy-mm-dd',
        'defaultDate': waktu(null, 'YYYY-MM-DD ')
    })
    $('.datepicker').val(waktu(null, 'YYYY-MM-DD'))
    $('#bqn-form-transaksi-masuk').initFormAjax(options);
    $('#jenis-transaksi option[value="M01"]').prop('selected', true).parent().trigger('change');

}