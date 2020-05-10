$(() => {
    $('[id^="user-actions"]').on('change', e => {
        const action = $(e.target).find('option:selected').val();

        //If action is ban
        if (action.includes('ban')) {
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
                        $(`#user-${id}`).addClass('banned');
                        $(`#user-actions-${id}`).find(`#ban-${id}`).remove();
                        $(modal).find('.modal-header').html('Žaidėjas sėkmingai užbanintas');
                        $(modal).find('.modal-body').addClass('modal-success-message').html(`<h3>Žaidėjas ${playerNickname} užbanintas ${$(modal).find(`#${fieldIds[1]}`)[0].value} h.</h3>`);
                        $(modal).find('button[type="submit"]').remove();
                        setTimeout(() => {
                            $(modal).modal('hide');
                        }, 3000);
                    },
                    error: data => {
                        const errors = JSON.parse(data.responseText).errors;

                        //Display error messages and add class for invalid inputs
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
