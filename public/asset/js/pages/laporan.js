$(document).ready(function () {
    inisialisasi();
    eventHandler();
});

function persiapan_data() {

}
async function inisialisasi() {

    showLoading();
    await loaddata('masuk', 'Semua', 'Semua');
    await loaddata('keluar', 'Semua', 'Semua');
    await loaddata('kaskecil', 'Semua', 'Semua');

    var message = 'Data pengeluaran';
    var options = {
        search: true,
        info: false,
        order: true,
        select: true,
        changeMenu: false,
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'copy',
            {
                extend: 'excel',
                messageTop: message
            },
            {
                extend: 'csv',
                messageTop: message
            },
            {
                extend: 'print',
                messageTop: message
            }
        ]
    };
    initDatatable('#tbl-transaksi-keluar', options);

    message = 'Data pemasukan';
    options = {
        search: true,
        info: false,
        order: true,
        select: true,
        changeMenu: false,
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'copy',
            {
                extend: 'excel',
                messageTop: message
            },
            {
                extend: 'csv',
                messageTop: message
            },
            {
                extend: 'print',
                messageTop: message
            }
        ]
    };
    initDatatable('#tbl-transaksi-masuk', options);
}


function eventHandler() {
    $('p.tahun-masuk').click(async function () {
        showLoading();
        var jenis = $('#jenis-masuk').val();
        var tahun = $(this).text();
        $('#btn-tahun-masuk').text(tahun);

        $('#tbl-transaksi-masuk').DataTable().clear();
        $('#tbl-transaksi-masuk').DataTable().destroy();
        $('#tbl-transaksi-masuk tbody').empty();

        await loaddata('masuk', tahun, jenis);

        var message = 'Data pemasukan';
        var options = {
            search: true,
            info: false,
            order: true,
            select: true,
            changeMenu: false,
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                'copy',
                {
                    extend: 'excel',
                    messageTop: message
                },
                {
                    extend: 'csv',
                    messageTop: message
                },
                {
                    extend: 'print',
                    messageTop: message
                }
            ]
        };
        initDatatable('#tbl-transaksi-masuk', options);
    });

    $('p.tahun-keluar').click(async function () {
        showLoading();
        var jenis = $('#jenis-keluar').val();
        var tahun = $(this).text();
        var kelompok = 'keluar';

        $('#btn-tahun-keluar').text(tahun);

        $('#tbl-transaksi-keluar').DataTable().clear();
        $('#tbl-transaksi-keluar').DataTable().destroy();
        $('#tbl-transaksi-keluar tbody').empty();

        if (kas_kecil.includes(jenis))
            kelompok = 'kaskecil'
        await loaddata(kelompok, tahun, jenis);
        if (jenis == 'Semua')
            await loaddata('kaskecil', tahun, jenis);


        var message = 'Data pengeluaran';
        var options = {
            search: true,
            info: false,
            order: true,
            select: true,
            changeMenu: false,
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                'copy',
                {
                    extend: 'excel',
                    messageTop: message
                },
                {
                    extend: 'csv',
                    messageTop: message
                },
                {
                    extend: 'print',
                    messageTop: message
                }
            ]
        };
        initDatatable('#tbl-transaksi-keluar', options);
    });

    $('#jenis-masuk, #jenis-keluar').change(async function () {
        showLoading();
        var jenis = $(this).val();
        var tahun = $('#btn-tahun-masuk').text();
        var id = $(this).attr('id');
        var kelompok = id.replace('jenis-', '');
        tahun = tahun.replace(/\s/g, '');
        $('#tbl-transaksi-' + kelompok).DataTable().clear();
        $('#tbl-transaksi-' + kelompok).DataTable().destroy();
        $('#tbl-transaksi-' + kelompok + ' tbody').empty();

        if (kelompok == 'keluar' && kas_kecil.includes(jenis))
            kelompok = 'kaskecil'
        await loaddata(kelompok, tahun, jenis);
        if (kelompok == 'keluar' && jenis == 'Semua')
            await loaddata('kaskecil', tahun, jenis);


        var message = kelompok == 'masuk' ? 'Data pemasukan' : 'Data pengeluaran';
        var idTable = kelompok == 'masuk' ? '#tbl-transaksi-masuk' : '#tbl-transaksi-keluar';
        var options = {
            search: true,
            info: false,
            order: true,
            select: true,
            changeMenu: false,
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                'copy',
                {
                    extend: 'excel',
                    messageTop: message
                },
                {
                    extend: 'csv',
                    messageTop: message
                },
                {
                    extend: 'print',
                    messageTop: message
                }
            ]
        };
        initDatatable(idTable, options)
    })
}

async function loaddata(kelompok = 'masuk', tahun, jenis) {
    await fetch(path + 'laporan/data/' + kelompok + '/' + tahun + '/' + jenis).then(res => res.json()).then(res => {

        if (!res.data){
            endLoading();
            return;
        }

        var rows = '';
        var data = res.data;

        data.forEach((d, i) => {
            if (!d.sumber)
                d.sumber = d.nama_siswa;
            if (!d.nama_lengkap)
                d.nama_lengkap = d.pencatat;

            rows += '<tr>' +
                '<td>' + waktu(d.tanggal_catat, 'DD MMM YYYY HH:mm') + '</td>' +
                '<td>' + waktu(d.tanggal, 'DD MMM YYYY') + '</td>' +
                '<td>' + d.jenis_transaksi + '</td>' +
                '<td>' + 'Rp. ' + d.saldo_sebelum.rupiahFormat() + '</td>' +
                '<td>' + 'Rp. ' + d.jumlah.rupiahFormat() + '</td>' +
                '<td>' + d.sumber + '</td>' +
                '<td>' + d.nama_lengkap + '</td>' +
                '<td>' + d.catatan + '</td>' +
                '</tr>';
        });
        // $('#tbl-transaksi-masuk tbody').empty();
        if (kelompok == 'kaskecil')
            $('#tbl-transaksi-keluar tbody').append(rows);
        else
            $('#tbl-transaksi-' + kelompok + ' tbody').html(rows);
        endLoading();
    });
}