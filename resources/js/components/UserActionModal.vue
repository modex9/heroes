<template>
    <div class="modal fade" v-bind:id="id" tabindex="-1" role="dialog" aria-labelledby="l" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="xc">{{title}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div v-if="!actionSuccess" id="before-send">
                        <div class="form-group" v-for="input in inputs">
                            <label v-bind:for="input['name']">{{input['label']}}</label>
                            <input v-if="input['type'] == 'input'" type="text" class="form-control" :class="{ 'is-invalid' : input['name'] in modalErrors}" v-bind:name="input['name']"
                                   v-bind:id="input['name']" v-model="data[input['name']]" required>
                            <select v-model="data[input['name']]" v-else-if="input['type'] == 'select'" v-bind:name="input['name']" v-bind:id="input['name']">
                                <option v-for="option in input['options']" v-bind:value="option['id']">{{option['name']}}</option>
                            </select>
                            <span v-if="input['name'] in modalErrors" class="invalid-feedback" role="alert">
                                        <strong>{{modalErrors[input['name']][0]}}</strong>
                            </span>
                        </div>
                    </div>
                    <div id="action-success" v-else>
                        {{successMessage}}
                    </div>
                </div>
                <div class="modal-footer">

                </div>
                <button v-if="!actionSuccess" @click="handleAction()" class="btn btn-primary" type="submit">Save changes</button>
                <button @click="actionSuccess = false" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "UserActionModal",
        props : ['action', 'visible', 'inputs', 'user', 'title'],
        data : function() {
            return {
                id : '',
                data : {},
                modalErrors : {},
                actionSuccess : false,
            }
        },
        watch : {
            modalId() {
                this.id = this.modalId;
                this.$nextTick(() => {
                   $(`#${this.id}`).modal();
                });
            },
            user() {
                this.modalErrors = {};
                const keys = Object.keys(this.inputs);
                keys.forEach((val) => {
                    if(this.inputs[val]['type'] == 'select')
                        Vue.set(this.data, val, this.user[`${val}_id`]);
                    else Vue.set(this.data, val, this.user[val]);
                });
            },

        },
        computed : {
            modalId() {
                return `${this.action}-modal`;
            },
            // formId() {
            //     return `${this.action}Form`;
            // },
            route() {
                if(this.action.includes('edit'))
                    return `${document.location.href}/${this.user['id']}`
            },
            successMessage() {
                switch (this.action.split('-')[0]) {
                    case'edit' :
                        return `User ${this.user['nickname']} was successfully updated.`;
                    default :
                        return '';
                }
            }
        },
        methods : {
            handleAction() {
                this.modalErrors = {};
                this.data['id'] = this.user['id'];
                fetch(this.route, {
                    method : "PUT",
                    body : JSON.stringify(this.data),
                    headers : {
                        "Content-Type": "application/json; charset=utf-8",
                        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content'),
                    },
                })
                .then(data => data.json())
                .then(data =>  {
                    if(!data['success'])
                        this.modalErrors = data['errors'];
                    else {
                        this.$emit('user-updated', data['user']);
                        this.actionSuccess = true;
                    }
                })
                .catch(error => console.log(error));
            },
        },
    }
</script>

<style scoped>

</style>
