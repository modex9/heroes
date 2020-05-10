$(() => {
    $('[id^="user-actions"]').on('change', e => {
        const action = $(e.target).find('option:selected').val();

        if (action.includes('unban')) {
            const id = action.split('-')[1];
            const modal = $('option[value^="unban"]').attr('data-target');
            const playerNickname = $(`#nickname-${id}`).text();
            //Show modal
            $(modal).on('show.bs.modal', function(){
                $(`${modal}Label`).text(`Nuimti baną žaidėjui ${playerNickname}`);
            });
            $('#unbanForm').on('submit', e => {
                e.preventDefault();
                const fieldIds = ['reason'];
                let fieldsData = {};
                $.each(fieldIds, (i, val) => {
                    fieldsData[val] = $(modal).find(`#${val}`)[0].value;
                });
                const data = {...fieldsData, ...{'user_id' : id}};
                $.ajax({
                    type: 'post',
                    data: data,
                    url: `${unbanUrl}/${id}`,
                    success: data => {
                        $(`#user-actions-${id}`).find(`#unban-${id}`).attr('disabled', true);
                        $(`#user-actions-${id}`).find(`#ban-${id}`).attr('disabled', false);
                        $(modal).find('.modal-header').html('Banas nuimtas');
                        $(modal).find('.modal-body').addClass('modal-success-message').html(`<h3>Žaidėjui ${playerNickname} banas nuimtas.</h3>`);
                        $(modal).find('button[type="submit"]').hide();
                        setTimeout(() => {
                            $(modal).modal('hide');
                            $(`#user-${id}`).removeClass('banned');
                        }, 3000);
                    },
                    error: data => {
                        const errors = JSON.parse(data.responseText).errors;

                        //Display error messages and add class for invalid inputs
                        handleModalErrors(fieldIds, errors);
                    }
                });
            });
            $(modal).modal();
        }
        //If action is ban
        else if (action.includes('ban')) {
            const id = action.split('-')[1];
            const modal = $('option[value^="ban"]').attr('data-target');
            const playerNickname = $(`#nickname-${id}`).text();
            //Show modal
            $(modal).on('show.bs.modal', function(){
                $(`${modal}Label`).text(`Užbaninti žaidėją ${playerNickname}`);
            });
            $('#banForm').on('submit', e => {
                e.preventDefault();
                const fieldIds = ['reason', 'duration', 'type_id'];
                let fieldsData = {};
                $.each(fieldIds, (i, val) => {
                    fieldsData[val] = $(modal).find(`#${val}`)[0].value;
                });
                const data = {...fieldsData, ...{'user_id' : id}};
                $.ajax({
                    type: 'post',
                    data: data,
                    url: `${banUrl}/${id}`,
                    success: data => {
                        $(`#user-actions-${id}`).find(`#ban-${id}`).attr('disabled', true);
                        $(`#user-actions-${id}`).find(`#unban-${id}`).attr('disabled', false);
                        $(modal).find('.modal-header').html('Žaidėjas sėkmingai užbanintas');
                        $(modal).find('.modal-body').addClass('modal-success-message').html(`<h3>Žaidėjas ${playerNickname} užbanintas ${$(modal).find(`#${fieldIds[1]}`)[0].value} h.</h3>`);
                        $(modal).find('button[type="submit"]').remove();
                        setTimeout(() => {
                            $(modal).modal('hide');
                            $(`#user-${id}`).addClass('banned');
                        }, 3000);
                    },
                    error: data => {
                        const errors = JSON.parse(data.responseText).errors;
                        handleModalErrors(fieldIds, errors);
                    }
                });
            });
            $(modal).modal();
        }
        // If actions is delete
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
        // If action is not Ajax, just redirect to it
        else document.location.href = action;

        // Reset selection input
        $('[id^="user-actions"] option').prop('selected', function() {
            return this.defaultSelected;
        });
    });
});

//Display error messages and add class for invalid inputs
function handleModalErrors(fields, errors) {
    $.each(fields, (key,val) => {
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
