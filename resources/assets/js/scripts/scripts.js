(function () {

    window.errorsHandler = (response) => {
        if (void 0 !== response.data.errors && Array.isArray(response.data.errors)) window.alert(response.data.errors[0]);
    };

    window.successReloadHandler = (response, url) => {
        url = url || false;
        if (response.data.success) window.alert(response.data.success);
        if (!url) window.location.reload();
        else window.location.href = url;
    };

    $(document).on('click', '.flash-messages>span', (event) => {
        $(event.currentTarget).parent().hide();
    });
})();

