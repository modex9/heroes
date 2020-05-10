$(() => {
    $('[id^="user-actions"]').on('change', e => {
        const action = $(e.target).find('option:selected').val();
        if (action.includes('ban')) {
            const id = action.split('-')[1];
            const modal = $('option[value^="ban"]').attr('data-target');
            $(modal).on('show.bs.modal', function(){
                $(`${modal}Label`).text(`Užbaninti žaidėją ${$(`#nickname-${id}`).text()}`);
            });
            $('#banForm').on('submit', e => {
                e.preventDefault();
                $.ajax({
                    type: 'post',
                    data: {'user_id' : id, 'reason' : $(modal).find('#reason')[0].value,
                        'duration' : $(modal).find('#duration')[0].value, 'type_id' : $(modal).find('#type')[0].value},
                    url: `${banUrl}/${id}`,
                    success: data => {
                        $(modal).modal('hide');
                    }
                });
            });
            $(modal).modal();
        }
        else if (action.includes('delete')) {
            const id = action.split('-')[1];
            $.ajax({
                type: 'delete',
                url: document.URL + '/' + id,
                success: data => {
                    if(data['status']) {
                        let deletedUser = `#user-table tr[id$='${id}']`;
                        $(deletedUser).remove();
                    }
                }
            });
        }
        else document.location.href = action;
        $('[id^="user-actions"] option').prop('selected', function() {
            return this.defaultSelected;
        });
    });
});
