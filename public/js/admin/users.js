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
                const fieldIds = ['reason', 'duration', 'type_id'];
                $.ajax({
                    type: 'post',
                    data: {'user_id' : id, 'reason' : $(modal).find(`#${fieldIds[0]}`)[0].value,
                        'duration' : $(modal).find(`#${fieldIds[1]}`)[0].value, 'type_id' : parseInt($(modal).find(`#${fieldIds[2]}`)[0].value)},
                    url: `${banUrl}/${id}`,
                    success: data => {
                        $(modal).modal('hide');
                    },
                    error: data => {
                        const errors = JSON.parse(data.responseText).errors;
                        $.each(fieldIds, (key,val) => {
                            if(errors[val] !== undefined) {
                                $(`#${val}`).addClass('is-invalid');
                                $(`#${val} + .invalid-feedback`).show().find('strong').text(errors[val]);
                            }
                            else {
                                $(`#${val}`).removeClass('is-invalid');
                                $(`#${val} + .invalid-feedback`).hide().find('strong').text(errors[val]);
                            }
                        });
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
