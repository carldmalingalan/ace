$(function () {
    //Tooltip
    $('body').tooltip({selector: '[data-toggle="tooltip"]'});

    //Popover
    $('[data-toggle="popover"]').popover();
})