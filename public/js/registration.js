(() => {
    $('#referrer').val(document.referrer);
    const url = document.location.pathname;
    if(url.match(/\//g || []).length == 3)
        $('#referral').val(url.substr(url.lastIndexOf('/') + 1));
})();

