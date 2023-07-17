function redirectback() {
    var url = $(location).attr('href').split("/").splice(0, 5).join("/");
    // var segments = url.split('/');
    // var id = segments[5];
    setTimeout(function() { window.location = url; }, 1000);

}