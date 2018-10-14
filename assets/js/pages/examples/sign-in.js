$(function () {
    $('#sign_in').validate({
        submitHandler : function(form) {
        	$("button[type='submit']").attr('disabled',true).text('Logging in...');
        	form.submit();
        },
        highlight: function (input) {
            console.log(input);
            $(input).parents('.form-line').addClass('error');
        },
        unhighlight: function (input) {
            $(input).parents('.form-line').removeClass('error');
        },
        errorPlacement: function (error, element) {
            $(element).parents('.input-group').append(error);
        }
    });
});