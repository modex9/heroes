$(() => {
    $('[id^="user-actions"]').on('change', e => {
        const action = $(e.target).find('option:selected').val();

        // If actions is delete
        if (action.includes('delete')) {
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
        // If action is not Ajax, just redirect to it
        else document.location.href = action;

        // Reset selection input
        $('[id^="user-actions"] option').prop('selected', function() {
            return this.defaultSelected;
        });
    });
});
