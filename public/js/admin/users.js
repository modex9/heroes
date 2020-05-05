$(() => {
    $('select[id^="user-actions"]').on('change', e => {
        let action = $(e.target).find('option:selected').val();
        if (action.includes('delete')) {
            let id = action.split('-')[1];
            $.ajax({
                type: 'delete',
                data: id,
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
    });
});
