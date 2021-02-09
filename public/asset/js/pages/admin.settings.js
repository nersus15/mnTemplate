$(document).ready( async function(){
    var data = await persiapan_data();
    add_eventlistener(data);
    inisialisasi(data);
});

async function persiapan_data(){
    var data = {};

    data.carouselItem = await fetch(path + 'uihelper/carousel/get').then(res => res.json()).then(res => res.data);
    data.toasCofig = {
        wrapper: '.modal',
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
    data.atur_carousel = function(){
        var gambar = $("#gambar-carousel").val();
        var arrayGambar = gambar.split(';');

        var carousel = '';
        arrayGambar.forEach((e, i) => {
            carousel += '<div class="col-12">' +
                '<input type="hidden" name="carousel_img[]" value="'+e+'">'+
                '<div class="col-xxl-4 col-xl-6 col-12">' +
                    '<div class="card d-flex flex-row mb-4 media-thumb-container">' +
                            '<img src="'+ path + 'public/assets/img/barang/' + e +'" alt="gambar barang" class="col-6 list-media-thumbnail responsive border-0" />' +                       
                            '<div class="d-flex flex-grow-1 min-width-zero">' +
                            '<div class="card-body align-self-center d-flex flex-column justify-content-between min-width-zero">' +
                                '<div class="form-group">' +
                                    '<label for="">Pilih badge</label>' +
                                    '<select name="carousel_badge[]" id="" class="form-control">' +
                                        '<option value="">Pilih ..</option>' +
                                       '<option value="baru">Baru</option>' +
                                        '<option value="terlaris">Terlaris</option>' +
                                    '</select>' +
                                '</div>' +
                                '<div class="form-group">' +
                                    '<label for="">Berikan text</label>' +
                                    '<input type="text"  name="carousel_text[]" placeholder="Kosongkan jika tidak ada" class="form-control">' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
               '</div>' +
            '</div>';
        });

        $('#carousel-img').html(carousel)
    }
    data.setCarousel = function(){
        var cardCarousel = '';
        var footer = '';
        if(data.carouselItem){
            data.carouselItem.forEach(el => {
                var params = ['text', 'foot1', 'foot2', 'foot3', 'badge1', 'badge2'];
                params.forEach(p => {
                    if(!el[p])
                        el[p] = '';
                })
                cardCarousel += '<div class="card card d-flex flex-row mb-3">' +
                    '<div class="position-relative">' +
                        '<img class="card-img-top" src="'+ path + 'public/assets/img/barang/' + el.img +'" alt="gambar produk">' +
                        '<span class="badge badge-pill badge-theme-1 position-absolute badge-top-left">'+ el.badge + '</span>' +
                        '<span class="badge badge-pill badge-secondary position-absolute badge-top-left-2">'+ el.badge2 +'</span>' +
                    '</div>' +
                    '<div class="card-body">' +
                        '<h1 class="mb-4">'+ el.text +'</h1>' +
                       ' <footer>' +
                            '<h2 class="text-muted mb-0 font-weight-light">'+ el.foot1 +'</h2>' +
                            '<h3 class="text-muted mb-0 font-weight-light">'+ el.foot2 +'</h3>' +
                            '<h4 class="text-muted mb-0 font-weight-light">'+ el.foot3 +'</h4>' +
                        '</footer>' +
                    '</div>' +
                '</div>';
            });
    
            footer = '<div class=" slider-nav text-center">' +
            '<a href="#" class="left-arrow owl-prev">' +
                '<i class="simple-icon-arrow-left"></i>' +
            '</a>'+
            '<div class="slider-dot-container"></div>' +
            '<a href="#" class="right-arrow owl-next">' +
                '<i class="simple-icon-arrow-right"></i>' +
            '</a>' +
            '</div>';
        }else{          
            cardCarousel = '<center><h3 class="text-muted">Tidak ada carousel aktif</h3> </center>';
        }
        $('#carousel-body').html(cardCarousel).after(footer);
    }

    data.modal_buka =  async function(){
        var img = '';
        showLoading();
        var ids = await fetch(path + 'uihelper/get_files?p=public/assets/img/barang').then(res => res.json()).then(res =>{
            if(!res)
                return;
            var data = res.data;
            var idw = [];
            var idck = [];
            var keys = Object.keys(res.data);
            keys.forEach((el, i) => {
               img += '<div class="col-4">'+
                '<div id="wrapper-'+i+'" class="card card-select d-flex flex-row mb-4 media-thumb-container">' +
                    '<img style="width: 80%" class="thumb-lib" src="' + path + '/public/assets/img/barang/' + data[el] +'" alt="uploaded image" class="list-media-thumbnail responsive border-0" />' +
                    '<label style="position: absolute; left: 90%" class="custom-control custom-checkbox mb-0">' +
                        '<input data-img="'+ data[el] +'" id="checkbox-'+i+'" type="checkbox" class="custom-control-input select-img">' +
                        '<span class="custom-control-label"></span>' +
                    '</label>' +
                '</div> ' +
                '</div>';
                idw.push('#wrapper-' + i);
                idck.push('#checkbox-' + i);
            });
            if(!img)
                return;
            $('#galery-body').html(img);
            return {'wrapper': idw, 'checkbox': idck};
        });
        endLoading();
        addModalOpen(true);
        $(ids.checkbox.join()).click(function(){
            var ini = $(this);
            var gambar = ini.data('img');
            var gambarTerpilih = $("#gambar-carousel").val();
            if(ini.is(':checked')){
                if(!gambarTerpilih)
                    $('#gambar-carousel').val(gambar);
                else    
                    $('#gambar-carousel').val(gambarTerpilih + ";" + gambar );
            }else{
                if(!gambarTerpilih)
                    return;
                
                var arrayGambar = gambarTerpilih.split(';');
                if(arrayGambar.length > 1){
                    var index = arrayGambar.indexOf(gambar);

                    if(index < 0)
                        return; 
                    arrayGambar.splice(index, 1);
                    $('#gambar-carousel').val(arrayGambar.join(';'))
                }else if(arrayGambar.length == 0)
                    $('#gambar-carousel').val('');
            }
        });

        $(ids.wrapper.join()).click(function(){
            var ini = $(this);
            var id = ini.attr('id');
            var index = id.split('-')[1];
            $('#checkbox-' + index).trigger('click')
        });

        $('#selanjutnya').click(function () {
            if(!$("#gambar-carousel").val()){
                var toastOpt = data.toasCofig;
                toastOpt.bg = 'bg-danger';
                toastOpt.title = 'Err';
                toastOpt.message = "Anda belum memilih gambar, pilih minimal 1";
                makeToast(toastOpt);
                return;
            }
                

            $('#hal-2').show();
            $('#hal-1').animate({ height: 'toggle' });
            $(this).hide();
            $('#submit, #kembali').show();
            setTimeout(function () {
                $('#hal-1').hide();
            }, 500)

            if ($('#hal-2').is(':visible'))
                $('#kembali').show();

            setTimeout(function () {
                $('body').addClass('modal-open');
            }, 500);

            console.log(data);
            data.atur_carousel();
        });

        $('#kembali').click(function () {
            $('#hal-1, #selanjutnya').show();
            $('#hal-2').animate({ height: 'toggle' });
            $(this).hide();
            $('#submit').hide();
            setTimeout(function () {
                $('#hal-2').hide();
            }, 500)

            if ($('#hal-1').is(':visible'))
                $('#kembali').hide();

            setTimeout(function () {
                $('body').addClass('modal-open');
            }, 500);
        });
        
    }
    return data;
}

function add_eventlistener(data){
    $('#btn-set-carousel').click(async function(){
        fetch(path + 'uihelper/form?f=forms/carousel').then(res => {
            if (res.status != 200)
            return;
        else
            return res.text();
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
                    modalclick: false,
                    size: 'modal-xl',
                    modalTitle: 'Setting carousel',
                    modalPos: 'def',
                    saatBuka: function () {
                        if (!$('body').hasClass('modal-open'))
                            $('body').addClass('modal-open');

                        data.modal_buka();
                    },
                    submitSuccess: function (res) {
                        $('#submit').prop('disabled', false);
                        $('#form-modal-set-carousel').modal('hide');
                        endLoading();

                        res = JSON.parse(res);
                        var toastOpt = data.toasCofig;
                        toastOpt.bg = 'bg-success';
                        toastOpt.title = 'Berhasil';
                        toastOpt.message = res.message;
                        makeToast(toastOpt);

                        data.setCarousel();

                        setTimeout(function () {
                            $('#batal').trigger('click');
                        }, 2000);
                    },
                    submitError: function (res) {
                        $('#submit').prop('disabled', false);
                        $('#form-modal-set-carousel').modal('hide');
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
                        formAct: path + "uihelper/carousel/set",
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
                            { type: 'button', style:'display:none', text: 'Kembali', id: "kembali", class: "btn btn btn-primary" },
                            { type: 'button', text: 'Selanjutnya', id: "selanjutnya", class: "btn btn btn-primary" },
                            { type: 'submit', style: 'display:none', text: 'Simpan', id: "submit", class: "btn btn btn-primary" }
                        ]
                    },
                }
                generateModal('form-modal-set-carousel', 'body', opt)
            }
        })
    })
    $('#btn-delete-carousel').click(async function(){
        showLoading();

        await fetch(path + 'uihelper/carousel/delete').then(res => res.json()).then(res => {
            var toastOpt = data.toasCofig;
            toastOpt.bg = 'bg-success';
            toastOpt.title = 'Berhasil';
            toastOpt.message = 'Berhasil menghapus seting carousel';
            makeToast(toastOpt)
        });

        endLoading();        
    });
}

function inisialisasi(data){
    data.setCarousel();
}