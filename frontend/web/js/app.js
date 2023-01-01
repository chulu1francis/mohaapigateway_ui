$('#refresh-captcha').on('click', function (e) {
    e.preventDefault();
    $('#captcha-image').yiiCaptcha('refresh');
})

