function addBodyload() {
    $(document.body).append('<div id="preloader">' +
        '      <div class="loader" id="loader-1"></div>' +
        '    </div>');
}
function removeBodyload() {
    var obj = $("#preloader");
    obj.remove();
}