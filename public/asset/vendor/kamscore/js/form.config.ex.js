var FormConf = {
    'FormLogin': {
        form: {
            enctype: 'multipart/form-data',
            formId: "form-login",
            formAct: "/api/login",
            formMethod: 'POST',
            ajax: true,
            wrapper: '#form',
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
        },
        inputs: [
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
        ]
    }
}