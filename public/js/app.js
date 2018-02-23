'use strict';

/// Get query params
window.$_GET = window.location.search.substr(1).split('&').reduce(function(o, i){
    let
        u = decodeURIComponent,
        [k, v] = i.split('=');

    o[u(k)] = v && u(v);

    return o;
}, {});

$(document).ready(function(){
    $('#sidebarCollapse').on('click', function(){
        $('#sidebar').toggleClass('active');
        $('body').toggleClass('sidebar-active');
        $(this).toggleClass('active');
    });
});