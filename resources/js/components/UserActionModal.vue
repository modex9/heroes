<template>
    <div class="modal fade" :id="id" tabindex="-1" role="dialog" aria-labelledby="l" aria-hidden="true">
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
                            <label v-if="input['type'] !== 'text'" :for="input['name']">{{input['label']}}</label>
<!--                            simple inputs-->
                            <input v-if="input['type'] == 'input'" type="text" class="form-control" :class="{ 'is-invalid' : input['name'] in modalErrors}" :name="input['name']"
                                   :id="input['name']" v-model="data[input['name']]" required>
<!--                            select inputs-->
                            <select v-model="data[input['name']]" v-else-if="input['type'] == 'select'" :class="{ 'is-invalid' : input['name'] in modalErrors}" :name="input['name']" :id="input['name']">
                                <option v-for="option in input['options']" :value="option['id']">{{option['name']}}</option>
                            </select>
<!--                            text messages-->
                            <p class="modal-alert" v-else-if="input['type'] == 'text'">{{modalAlert}}</p>
                            <span v-if="!!input['name'] && input['name'] in modalErrors" class="invalid-feedback" role="alert">
                                        <strong>{{modalErrors[input['name']][0]}}</strong>
                            </span>
                        </div>
                    </div>
                    <div id="action-success" v-else>
                        {{successMessage}}
                    </div>
                    <div v-if="!!deletionError" class="alert-danger">{{deletionError}}</div>
                </div>
                <div class="modal-footer">

                </div>
                <button v-if="!actionSuccess" @click="handleAction()" class="btn btn-primary" type="submit" :disabled="deletionError">{{buttonText}}</button>
                <button @click="afterModalClosed" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                deletionError : false,
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
                    if(this.inputs[val]['type'] == 'select') {
                        if(this.user !== undefined && this.user) {
                            Vue.set(this.data, val, this.user[`${val}_id`]);
                        }
                        else {
                            Vue.set(this.data, val, 1);
                        }
                    }
                    else if (this.user !== undefined)
                        Vue.set(this.data, val, this.user[val]);
                    else
                        Vue.set(this.data, val, '');

                });
            },

        },
        computed : {
            modalId() {
                return `${this.action}-modal`;
            },
            route() {
                if (this.action.includes('edit') || this.action.includes('delete'))
                    return `${document.location.href}/${this.user['id']}`;
                else if (this.action.includes('add'))
                    return document.location.href;
                else if (this.action.startsWith('ban'))
                    return `${window.origin}/public/ban/${this.user['id']}`;
                else if (this.action.includes('ban'))
                    return `${window.origin}/public/unban/${this.user['id']}`;
            },
            method() {
                if (this.action.includes('edit'))
                    return 'PUT';
                else if (this.action.includes('add') || this.action.includes('ban'))
                    return 'POST';
                else if (this.action.includes('delete'))
                    return 'DELETE';
            },
            successMessage() {
                switch (this.actionName) {
                    case 'edit' :
                        return `User ${this.user['nickname']} was successfully updated.`;
                    case 'add' :
                        return `New User ${this.data['nickname']} was successfully created.`;
                    case 'delete' :
                        return `User ${this.user['nickname']} was successfully deleted.`;
                    case 'ban' :
                        return `User ${this.user['nickname']} was banned for ${this.data['duration']}.`;
                    case 'unban' :
                        return `User ${this.user['nickname']} was successfully unbanned.`;
                    default :
                        return '';
                }
            },
            buttonText() {
                if (this.action.includes('delete'))
                    return 'Confirm Deletion';
                else if (this.action.startsWith('ban'))
                    return 'Ban User';
                else if (this.action.includes('unban'))
                    return 'Remove Ban';
                else
                    return 'Save';
            },
            modalAlert() {
                switch (this.actionName) {
                    case 'delete' :
                        return `Are you sure you want to delete user ${this.user['nickname']}?`;
                    default :
                        return '';
                }
            },
            actionName() {
              return this.action.split('-')[0];
            },
        },
        methods : {
            handleAction() {
                this.modalErrors = {};
                //If we are banning, we send user id in a different field name.
                if((this.actionName.includes('ban')))
                    this.data['user_id'] = this.user['id'];
                else
                    this.data['id'] = this.user['id'];
                fetch(this.route, {
                    method : this.method,
                    body : JSON.stringify(this.data),
                    headers : {
                        "Content-Type": "application/json; charset=utf-8",
                        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content'),
                        'cache' : 'no-store',
                    },
                })
                .then(data => data.json())
                .then(data =>  {
                    if(!data['success'])
                        this.modalErrors = data['errors'];
                    else {
                        if(this.actionName == 'edit' || this.actionName == 'add')
                            this.$emit('user-updated', data['user']);
                        else if(this.actionName == 'delete')
                            this.$emit('user-deleted', this.user);
                        else if(this.actionName.includes('ban')) {
                            this.user.banned = this.actionName === 'ban'
                            this.$emit('user-banned', this.user);
                        }
                        this.actionSuccess = true;
                    }
                    if(data['error'])
                        this.deletionError = data['error'];
                })
                .catch(error => console.log(error));
            },
            afterModalClosed() {
                this.actionSuccess = false;
                this.deletionError = false;
                this.data = {};
                this.$emit('modal-closed', true);
            },

        },
    }
</script>

<style scoped>

</style>
