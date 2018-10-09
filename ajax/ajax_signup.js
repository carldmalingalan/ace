$(document).ready(function() {
    var items = [];

    function pushElem(elem) {
            if(items.indexOf(elem) === -1){
                items.push(elem);
            }
    }

    function popElem(elem1) {
        if(items.indexOf(elem1) !== -1){
            items = items.filter(item => item !== elem1);
        }
    }

    function jumpTo(anchor){
        var top = $('#'+anchor).offset(),
            top = top.top,
            top = top <= 100 ? top : top - 100;
            $('html, body').animate({scrollTop:top},'150');
    }

    $('#username').on("keyup focus",function() {
            if($(this).val()){
                $.ajax({
                url: "./validate/register_validate.php",
                method: "post",
                data: {username : $(this).val(), ajax: true},
                dataType: "html",
                success: function(data) {
                        if(data){
                            $('#u_field').removeClass('has-danger').addClass('has-success');
                            $("#username").removeClass('is-invalid').addClass('is-valid');
                            $('#valU').removeClass('text-danger').addClass('text-success').html('Username is available!');
                            popElem('username');
                        }else{
                            $('#u_field').removeClass('has-success').addClass('has-danger');
                            $("#username").removeClass('is-valid').addClass('is-invalid');
                            $('#valU').removeClass('text-success').addClass('text-danger').html('Username is not valid or taken! (Must be atleast 6 character)');
                            pushElem('username');
                        }
                }
            });
            }else{
                $('#u_field').removeClass('has-success').addClass('has-danger');
                $("#username").removeClass('is-valid').addClass('is-invalid');
                $('#valU').removeClass('text-success').addClass('text-danger').html("Field must not be empty!");
                pushElem('username');
            }
    });

    $('#email').on("keyup focus", function() {
        if($(this).val()){
            var emVal = $(this).val();
                $.ajax({
                url: "./validate/register_validate.php",
                method: "post",
                data: {email : $(this).val(), ajax: true},
                dataType: "html",
                success: function(data) {
                        if(data){
                            $('#e_field').removeClass('has-danger').addClass('has-success');
                            $("#email").removeClass('is-invalid').addClass('is-valid');
                            $('#valE').removeClass('text-danger').addClass('text-success').html('Email is valid!');
                            popElem('email');
                        }else{
                            $('#e_field').removeClass('has-success').addClass('has-danger');
                            $("#email").removeClass('is-valid').addClass('is-invalid');
                            $('#valE').removeClass('text-success').addClass('text-danger').html('Email is not valid!');
                            pushElem('email');
                        }
                }
            });
            }else{
                $('#e_field').removeClass('has-success').addClass('has-danger');
                $("#email").removeClass('is-valid').addClass('is-invalid');
                $('#valE').removeClass('text-success').addClass('text-danger').html("Field must not be empty!");
                pushElem('email');
            }
    });
    $('.showpass, .hidepass').each(function() {
        $(this).click(function() {
            var classNames = $(this).attr('class');
            $('#pass').attr('type',$('#pass').attr('type') == "text" ? "password" : "text");
            $('#re_pass').attr('type',$('#re_pass').attr('type') == "text" ? "password" : "text");
            if(classNames.indexOf("fa-eye-slash") !== -1){
                    $(this).hide();
                    $('.hidepass').show()
                }else{
                    $(this).hide();
                    $('.showpass').show()
                }
        });
    
    $('#re_pass').on('keyup',function() {
        var pass = $('#pass').val();
        if(pass === $(this).val()){
            $('#re_field').removeClass('has-danger').addClass('has-success');
            $(this).removeClass('is-invalid').addClass('is-valid');
            $('#valRE').removeClass('text-danger').addClass('text-success').html('Password is match!');
            popElem('re_pass');
        }else if($(this).val() == ""){
            $('#re_field').removeClass('has-success').addClass('has-danger');
            $(this).removeClass('is-valid').addClass('is-invalid');
            $('#valRE').removeClass('text-success').addClass('text-danger').html("Field must not be empty!");
            pushElem('re_pass');
        }else{
            $('#re_field').removeClass('has-success').addClass('has-danger');
            $(this).removeClass('is-valid').addClass('is-invalid');
            $('#valRE').removeClass('text-success').addClass('text-danger').html('Password is not match!');
            pushElem('re_pass');
        }    
    });
    });

    $('#pass').on('keyup focus', function(){
        var Pass = $(this).val();
            if(Pass){
                $.ajax({
                    url: "./validate/register_validate.php",
                    method: "post",
                    data: {pass: Pass, ajax: true },
                    dataType: "html",
                    success: function(data) {
                        if(data){
                            $('#p_field').removeClass('has-danger').addClass('has-success');
                            $("#pass").removeClass('is-invalid').addClass('is-valid');
                            $('#valP').removeClass('text-danger').addClass('text-success').html('Password is valid!');
                            popElem('pass');
                        }else{
                            $('#p_field').removeClass('has-success').addClass('has-danger');
                            $("#pass").removeClass('is-valid').addClass('is-invalid');
                            $('#valP').removeClass('text-success').addClass('text-danger').text("Password is invalid! (Must be atleast 6 character)");
                            pushElem('pass');
                        }
                    }
                });
            }else{
                $('#p_field').removeClass('has-success').addClass('has-danger');
                $(this).removeClass('is-valid').addClass('is-invalid');
                $('#valP').removeClass('text-success').addClass('text-danger').html("Field must not be empty!");
                pushElem('pass');
            }
    });

    $('#mobile_no').on("keyup",function() {
        var mob_no = $(this).val(),
            mob_no = mob_no.split("+63 ").join("").split('_').join("");
            
        if(mob_no.charAt(0) == "9" && !isNaN(parseInt(mob_no)) && mob_no.length === 10){
            $('#m_field').removeClass('has-danger').addClass('has-success');
            $(this).removeClass('is-invalid').addClass('is-valid');
            $('#valM').removeClass('text-danger').addClass('text-success').html('Valid Mobile number!');
            popElem('mobile_no');
        }else if(mob_no === ""){
            $('#m_field').removeClass('has-success').addClass('has-danger');
            $(this).removeClass('is-valid').addClass('is-invalid');
            $('#valM').removeClass('text-success').addClass('text-danger').html("Field must not be empty!");
            pushElem('mobile_no');
        }else{
            $('#m_field').removeClass('has-success').addClass('has-danger');
            $(this).removeClass('is-valid').addClass('is-invalid');
            $('#valM').removeClass('text-success').addClass('text-danger').html("Mobile number must start at 9(ex. +63 9...).");
            pushElem('mobile_no');
        }
    });

    $('.form-control').each(function(){
        $(this).on("blur",function() {
            if($(this).hasClass('is-valid')){
                $(this).removeClass('is-valid');
                $(this).parents().find('.has-success').removeClass('has-success');
                if($(this).attr('id') == "pass"){
                    $(this).parents().find(".msg").text("").removeClass("text-success");
                }else{
                    $(this).siblings("span.msg").text("").removeClass("text-success");
                }
            }
        });
    });
    
    $('#main_form').on('submit',function(e) {
        if(items.length !== 0){
            jumpTo(items[0]);
            e.preventDefault(e);
        }else{
            $('button#submit').attr('disabled',true).html("Validating data...");
        }    

        
    });
    
});

