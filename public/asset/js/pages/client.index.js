$(document).ready(async function () {
    var data = await persiapan_data();

    add_eventlistener(data);
    inisialisasi(data);
});

async function persiapan_data() {
    var data = {};

    data.products = await fetch(path + 'barang/lists', { method: 'GET' }).then(res => res.json()).then(res => {
        var cards = '';
        res.data.forEach(data => {
            var images = data.thumb.split(',');
            var card = {
                id: data.id,
                title: data.nama,
                class: 'h-100 product',
                titleClass: 'text-primary',
                subtitle: 'Rp. ' + data.harga.toString().rupiahFormat() + ' / ' + data.satuan, 
                subtitleClass: 'text-muted',
                images: [
                    { src: path + 'public/assets/img/barang/' + images[0], alt: 'thumbnail product', position: 'top', styles: 'margin: 0 0 15px 0' },
                ],

            }
            cards += '<div class="col mb-4">' +
                generateCard(card) +
                '</div></div>';

        });
        $('#products').append(cards);
        $(".product .card-body").css('cursor', 'pointer').click(function () {
            const idProduct = $(this).parent().attr('id');
            window.location.href = path + 'barang/' + idProduct;
        });


        return res.data;
    });


}
function add_eventlistener(data) { }

function inisialisasi(data) { }


