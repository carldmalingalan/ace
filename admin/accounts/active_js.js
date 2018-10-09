var dataTable = $('#dataTable').dataTable({
    "responsive": true,
    "processing": true,
    "serverSide": true,
    "ajax": {
        "url": "ajax/active_account.php"
    },
    "pageLength": 10,
    "realtime": true,
    "paging": true,
    "columnDefs": [{
        className: "text-center",
        "targets": [3,4]
    },{searchable: false, orderable: false,"targets":[3,4]}]

}).api();

function userModal(data){        
    $.ajax({
        url: "ajax/user_modal.php",
        method: "POST",
        data: {id: data},
        dataType: "json",
        success: function(data) {
            const info = data;
            Object.keys(info).forEach(function(key){
                var elem = $('input[name="'+key+'"]');
              if(elem.attr('type')=="radio"){
                $('input[type="radio"]#'+info[key]).attr('checked',true);
              }else if(key == "role_id"){
                $('#role_id').val(info[key]);
                $('#role_id').selectpicker('refresh');
              }
                else{
                  $('#'+key).val(info[key]);
              }
            });
            
        }
    });
    $('#userModal').modal({show:true});
}
function confirmDeact(id){
swal({
    confirmButtonClass: "btn btn-danger waves-effect m-l-10",
    cancelButtonClass: "btn btn-default waves-effect",
    buttonsStyling: false,
    title: "Are you sure?",
    text:  "This account will be deactivated.",
    type:  "warning",
    showCancelButton: true,
    reverseButtons: true,
    confirmButtonText:  "Confirm!",
    cancelButtonText:   "Cancel"
}).then((result) => {
    if(result.value){
        swal({
            showConfirmButton: false,
            title: "Account Deactivation Success!",
            type: "error",
            timer: 2000
        })
        $.ajax({
            url: "ajax/change_stat.php",
            method: "POST",
            data:{ deact : id },
            error: function(msg){console.log(msg.responseText)}
        });
        dataTable.ajax.reload();
    }
});
}

function confirmActive(id){
swal({
    confirmButtonClass: "btn btn-success waves-effect m-l-10",
    cancelButtonClass: "btn btn-default waves-effect",
    buttonsStyling: false,
    title: "Are you sure?",
    text:  "This account will be activated.",
    type:  "question",
    showCancelButton: true,
    reverseButtons: true,
    confirmButtonText:  "Confirm!",
    cancelButtonText:   "Cancel"
}).then((result) => {
    if(result.value){
        swal({
            showConfirmButton: false,
            title: "Account Activation Success!",
            type: "success",
            timer: 2000
        })
        $.ajax({
            url: "ajax/change_stat.php",
            method: "POST",
            data:{ activate : id }
        });
        dataTable.ajax.reload();
    }
});
}

$(document).ready(function() {
    $('#userModal').on("hidden.bs.modal",function(){
        var old = $('div.Usex').html().replace('checked="checked"',"");
        $('div.Usex').html(old);
        $('#role_id').val('');
        $('#role_id').selectpicker('refresh');
        
    });
    $('#lockPass').on("click",function() {
        if($(this).find('i.material-icons').text() == "lock_outline"){
            $(this).parents().find('#pass').attr('type','text');
            $('#re_pass').attr('type','text');
            $(this).find('i.material-icons').text("lock_open");
        }else{
            $(this).parents().find('#pass').attr('type','password');
            $(this).find('i.material-icons').text("lock_outline");
            $('#re_pass').attr('type','password');
        }
    });
    
$('#modal-form').submit(function(e){
    $('#change').attr('disabled',true).text('Saving...');
});

$('#custom_validate').validate({
    rules: {
        'sex': {required: true},
        'mobile_no': {phMobile:true},
        'email': {required:true,email:true},
        'f_name': {whiteSpaceClear: true},
        'l_name': {whiteSpaceClear: true}
    },
    highlight: function (input) {
        $(input).parents('.form-line').addClass('error');
    },
    unhighlight: function (input) {
        $(input).parents('.form-line').removeClass('error');
    },
    errorPlacement: function (error, element) {
        $(element).parents('.form-group').append(error);
    }
});
$('.form_validate').validate({
    rules: {
       'sex': {required: true},
       'pass': {whiteSpaceClear:true},
       're_pass': {retypePass: true},
       'username': {authUsername: true},
       'mobile_no': {phMobile:true},
       'email': {authEmail:true,required:true},
       'f_name': {whiteSpaceClear: true},
       'l_name': {whiteSpaceClear: true}
    },
    highlight: function (input) {
        $(input).parents('.form-line').addClass('error');
    },
    unhighlight: function (input) {
        $(input).parents('.form-line').removeClass('error');
    },
    errorPlacement: function (error, element) {
        $(element).parents('.form-group').append(error);
    }
});

$.validator.addMethod('retypePass',function(value,element){
    return value == $('input[name="pass"]').val() ? true : false;
},"Password must match!");

$.validator.addMethod('whiteSpaceClear',function(value,elements){
    return value.trim().length !== 0 ? true : false;
},"Spaces are considered as blank, Please fill the field properly.");

$.validator.addMethod('authUsername',function(value,element){
    var val;
    $.ajax({
        url: "../../validate/register_validate.php",
        method: "POST",
        async: false,
        data: {username: value},
        success: function(data){
            val = data;
        }
    });
    return val;
},"Username is taken/invalid. (Character must be Alphanumeric only)");

$.validator.addMethod("phMobile",function(value,element){
    var value = value.replace('+63 ','').split('_').join('');
    return value.indexOf('9') == 0 && value.length == 10 ? true : false;
},"Must be 10 digits and start with 9. (Ex. +63 9...)");

$.validator.addMethod("authEmail",function(value,element){
    var val;
    $.ajax({
        url: "../../validate/register_validate.php",
        method: "POST",
        async: false,
        data: {email: value},
        success: function(data){
            val = data;
        
        }
    });
    return val;
}, "Email is taken!");
});    