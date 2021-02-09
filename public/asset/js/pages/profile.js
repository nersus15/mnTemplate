$(document).ready(function () {
    setTimeout(function () {
        $('#pass').val('')
    }, 1000);
    var data = persiapan();
    add_eventlistener(data);
    inisialisasi(data);
});

function persiapan(){
    var data = {};
    data.readURL = function(input, prevEl) {
        console.log(input);
        if (input.files && input.files[0]) {
            var reader = new FileReader();
    
            reader.onload = function (e) {
                $(prevEl).attr('src', e.target.result);
            }
    
            reader.readAsDataURL(input.files[0]);
        }
    }

    return data;
}
function add_eventlistener(data) {
    $('#pp').hover(function () {
        $('#file').show();
    }, function () {
        $('#file').hide();
    });

    $("#n-pp").change(function () {
        data.readURL(this, '#pp-preview');
    })
};

function inisialisasi(data) {
    var options = {
        submitError: function (response) {
            endLoading();
            var responseText = JSON.parse(response.responseText)
            $('#alert_danger strong').html(responseText.message).parent().show();
            $('#btn-login').prop('disabled', false);
        },
        sebelumSubmit: function (input,) {
            showLoading();
            $('#alert_danger strong').html('').parent().hide();
            $('#btn-login').prop('disabled', true);
        },
        submitSuccess: function (res) {
            endLoading();
            location.reload();
        }
    }
    $("#bqn-form-edit-user").initFormAjax(options);

    $('#kelamin').trigger('change');
}

