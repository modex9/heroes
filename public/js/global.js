$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

const getModalId = function() {
    const modal = $('.modal');
    modal.unbind( "hidden.bs.modal" );
    if(modal.length > 1) {
        console.log('Error: multiple modals detected.');
        return;
    }
    $(`#${$('.modal').attr('id')}`).on('hidden.bs.modal', function () {
        $(this).find('button.btn-secondary').click();
    });
}
