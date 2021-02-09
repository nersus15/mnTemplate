var modalConf = {
    'detail-user': {
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
                customBody: '<h1>Hello</h1>'
            },
        }
    }
}