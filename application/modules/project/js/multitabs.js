/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$('.sub-list-item').on('click', function () {
    if ($(this).children('.la-plus').length == 1) {
        $('.sub-list-item').each(function (index, val) {
            $(this).children('.la-minus').addClass('la-plus');
            $(this).children('.la-minus').removeClass('la-minus');
        });
        $(this).children('.la-plus').addClass('la-minus');
        $(this).children('.la-plus').removeClass('la-plus');
    } else {
        $(this).children('.la-minus').addClass('la-plus');
        $(this).children('.la-minus').removeClass('la-minus');
    }
});

$('.sub-list-item1').on('click', function () {
    if ($(this).children('.la-plus').length == 1) {
        $('.sub-list-item1').each(function (index, val) {
            $(this).children('.la-minus').addClass('la-plus');
            $(this).children('.la-minus').removeClass('la-minus');
        });
        $(this).children('.la-plus').addClass('la-minus');
        $(this).children('.la-plus').removeClass('la-plus');
    } else {
        $(this).children('.la-minus').addClass('la-plus');
        $(this).children('.la-minus').removeClass('la-minus');
    }
});
$('.main-list-item1').on('click', function () {
    if ($(this).children('.la-plus').length == 1) {
        $('.main-list-item1').each(function (index, val) {
            $(this).children('.la-minus').addClass('la-plus');
            $(this).children('.la-minus').removeClass('la-minus');
        });
        $(this).children('.la-plus').addClass('la-minus');
        $(this).children('.la-plus').removeClass('la-plus');
    } else {
        $(this).children('.la-minus').addClass('la-plus');
        $(this).children('.la-minus').removeClass('la-minus');
    }
});
$('.main-list-item').on('click', function () {
    if ($(this).children('.la-plus').length == 1) {
        $(this).children('.la-plus').addClass('la-minus');
        $(this).children('.la-plus').removeClass('la-plus');
    } else {
        $(this).children('.la-minus').addClass('la-plus');
        $(this).children('.la-minus').removeClass('la-minus');
    }
});

$(document).ready(function () {

    var multisidetabs1 = (function () {
        var opt, parentid,
                vars = {
                    listsub: '.list-sub',
                    showclass: 'mg-show'
                },
        test = function () {
            console.log(parentid);
        },
                events = function () {
                    $(parentid).find('a').on('click', function (ev) {
                        ev.preventDefault();
                        var atag = $(this), childsub = atag.next(vars.listsub);
                        //console.log(atag.text());
                        if (childsub && opt.multipletab == true) {
                            if (childsub.hasClass(vars.showclass)) {
                                childsub.removeClass(vars.showclass).slideUp(500);
                            } else {
                                childsub.addClass(vars.showclass).slideDown(500);
                            }
                        }
                        if (childsub && opt.multipletab == false) {
                            childsub.siblings(vars.listsub).removeClass(vars.showclass).slideUp(500);
                            if (childsub.hasClass(vars.showclass)) {
                                childsub.removeClass(vars.showclass).slideUp(500);
                            } else {
                                childsub.addClass(vars.showclass).slideDown(500);
                            }
                        }
                    });
                },
                init = function (options) {//initials
                    if (options) {
                        opt = options;
                        parentid = '#' + options.id;
                        //test();
                        events();
                    } else {
                        alert('no options');
                    }
                }

        return {init: init};
    })();

    multisidetabs1.init({
        "id": "mg-multisidetabs",
        "multipletab": false
    });


    var multisidetabs = (function () {
        var opt, parentid,
                vars = {
                    listsub: '.list-sub',
                    showclass: 'mg-show'
                },
        test = function () {
            console.log(parentid);
        },
                events = function () {
                    $(parentid).find('a').on('click', function (ev) {
                        ev.preventDefault();
                        var atag = $(this), childsub = atag.next(vars.listsub);
                        //console.log(atag.text());
                        if (childsub && opt.multipletab == true) {
                            if (childsub.hasClass(vars.showclass)) {
                                childsub.removeClass(vars.showclass).slideUp(500);
                            } else {
                                childsub.addClass(vars.showclass).slideDown(500);
                            }
                        }
                        if (childsub && opt.multipletab == false) {
                            childsub.siblings(vars.listsub).removeClass(vars.showclass).slideUp(500);
                            if (childsub.hasClass(vars.showclass)) {
                                childsub.removeClass(vars.showclass).slideUp(500);
                            } else {
                                childsub.addClass(vars.showclass).slideDown(500);
                            }
                        }
                    });
                },
                init = function (options) {//initials
                    if (options) {
                        opt = options;
                        parentid = '#' + options.id;
                        //test();
                        events();
                    } else {
                        alert('no options');
                    }
                }

        return {init: init};
    })();

    multisidetabs.init({
        "id": "mg-multisidetab",
        "multipletab": false
    });
});