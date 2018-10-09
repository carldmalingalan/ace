Inputmask.extendAliases({
    pesos: {
              prefix: "₱ ",
              radixPoint: ".",
              groupSeparator: ",",
              alias: "numeric",
              autoGroup: true,
              digits: 2,
              rightAlign:false,
          }
  });



$(function(){
    var dateFormat = $(".dateformat"),
        mobile = $(".mob"),
        image = $('div.imgBG');
    image.each(function(){
        $(this).fadeIn(1500);
    });

    dateFormat.datepicker({format: "mm/dd/yyyy"});
    dateFormat.each(function() {
        $(this).inputmask("mm/dd/yyyy");
    });
    mobile.each(function() {
        $(this).inputmask({mask: "+63 9999999999", greedy: false});
    });

    $('.count-to').countTo();
    
    $('.datepicker').bootstrapMaterialDatePicker({
        format: 'MMMM DD, YYYY',
        clearButton: true,
        weekStart: 1,
        time: false,
        year: false
    });

    $('.numeric').inputmask("Regex",{alias: 'numeric',regex: "[0-9]*"});
    
    $('.peso').inputmask({alias: "pesos"});
    
    $(".form_validate").validate({
        submitHandler : function(form) {
            var btn = $("button[type='submit']");
            btn.attr('disabled',true).text(btn.data("title") ? btn.data("title") : "Saving data...");
            form.submit();
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
});

// function modalLoading(){
//     $('[data-toggle="modalLoading"]')
// }
    