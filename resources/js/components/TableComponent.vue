<template xmlns:width="http://www.w3.org/1999/xhtml">
    <div id="users">
        <table id="user-table" class="centered">
            <thead v-if="headers.length > 0">
            <th v-for="header in headers" v-text="header"></th>
            </thead>
            <tr v-if="loading"><td colspan="5">Loading...</td></tr>
            <div v-if="error">{{error}}</div>
            <tbody v-if="users && roles">
            <tr v-for="user in users" :class="{ 'banned' : user['banned']}">
                <td>{{user.nickname}}</td>
                <td>{{user.email}}</td>
                <td>{{user.referral}}</td>
                <td>{{roles[user.role_id]['name']}}</td>
                <td><user-actions @change="updateSelected"  :user-id="user.id" :user-banned="user.banned"></user-actions></td>
            </tr>
            </tbody>
        </table>
        <a @click="selectedAction = 'add'" id="add-user">Add new User</a>
        <div>
            <user-action-modal @user-updated="updateOrCreateUser" @user-deleted="deleteUser" @user-banned="banUser" :title="title" :inputs="inputFields()" @modal-closed="selectedAction = ''" :user="modalInputs['user']"
                               :action="selectedAction"></user-action-modal>
        </div>
    </div>

</template>

<script>

    import UserActions from "./UserActions";
    import UserActionModal from "./UserActionModal";

    export default {
        name: "TableComponent",
        props : ['usersRoute', 'rolesRoute', 'banTypesRoute'],
        components : {
            UserActions, UserActionModal
        },
        data : function () {
            return {
                loading : false,
                users : null,
                error : null,
                roles : null,
                banTypes : null,
                headers : ['Nickname', 'E-mail', 'Referral', 'Role', 'Actions'],
                selectedAction : '',
                modalInputs : {
                    'edit' : {
                        nickname : {
                          name : 'nickname',
                          type : 'input',
                          label : 'Nickname',
                        },
                        email : {
                            name : 'email',
                            type : 'input',
                            label : 'E-mail',
                        },
                        password : {
                            name : 'password',
                            type : 'input',
                            label : 'Password'
                        },
                        role : {
                            name : 'role',
                            type : 'select',
                            label : 'Role',
                        },
                    },
                    'add' : {
                        nickname : {
                            name : 'nickname',
                            type : 'input',
                            label : 'Nickname',
                        },
                        email : {
                            name : 'email',
                            type : 'input',
                            label : 'E-mail',
                        },
                        password : {
                            name : 'password',
                            type : 'input',
                            label : 'Password'
                        },
                        role : {
                            name : 'role',
                            type : 'select',
                            label : 'Role',
                        },
                        referral : {
                            name : 'referral',
                            type : 'input',
                            label : 'Referral',
                        },
                    },
                    'ban' : {
                        reason : {
                            name : 'reason',
                            type : 'input',
                            label : 'Reason',
                        },
                        duration : {
                            name : 'duration',
                            type : 'input',
                            label : 'Duration'
                        },
                        type_id : {
                            name : 'type_id',
                            type : 'select',
                            label : 'Type',
                        },
                    },
                    delete : {
                        alert : {
                            type : 'text',
                        }
                    },
                    user : {},
                },
            }
        },
        watch : {
        },
        created() {
            this.fetchUsers();
            this.fetchRoles();
            this.fetchBanTypes();
        },
        computed : {
            action() {
                return this.selectedAction.split('-')[0];
            },
            userId() {
                return this.selectedAction.split('-')[1];
            },
            // Move to modal component ?
            title() {
                switch(this.action) {
                    case 'add':
                        return 'Create a new User';
                    case 'edit':
                        return `Edit user ${this.modalInputs['user']['nickname']}`
                    case 'delete':
                        return `Delete user ${this.modalInputs['user']['nickname']}`
                    case 'ban':
                        return `Ban user ${this.modalInputs['user']['nickname']}`
                    default:
                        return '';
                }
            },
        },
        methods : {
            fetchUsers() {
                this.users = this.error = null;
                this.loading = true;
                let users = {};
                fetch(this.usersRoute)
                    .then(data => data.json())
                    .then(data => {
                        data.forEach(val => {
                            users[val.id] = val;
                        });
                        this.users = users;
                    })
                    .catch(error => this.error = error)
                    .then(() => {
                        if(this.roles)
                            this.loading = false;
                    });
            },
            fetchRoles() {
                this.error = this.roles = null;
                let roles = {};
                this.loading = true;
                fetch(this.rolesRoute)
                    .then(data => data.json())
                    .then(data => {
                            data.forEach(val => {
                               roles[val.id] = val;
                            });
                            this.roles = roles;
                            this.modalInputs['edit']['role']['options'] = this.modalInputs['add']['role']['options'] = roles;
                        }
                    )
                    .catch(error => this.error = error)
                    .then(() => {
                        if(this.users)
                            this.loading = false;
                    });
            },
            fetchBanTypes() {
                this.error = this.banTypes = null;
                let banTypes = {};
                this.loading = true;
                fetch(this.banTypesRoute)
                    .then(data => data.json())
                    .then(data => {
                        data.forEach(val => {
                           banTypes[val.id] = val;
                        });
                        this.banTypes = banTypes;
                        this.modalInputs['ban']['type_id']['options'] = banTypes;
                    })
                    .catch(error => this.error = error)
                    .then(() => {
                       if(this.banTypes)
                           this.loading = false;
                    });
            },
            updateSelected(value) {
                this.selectedAction = value;
            },
            inputFields() {
                if (this.action == 'edit' || this.action == 'delete' || this.action.includes('ban'))
                    this.modalInputs['user'] = this.users[this.userId];
                return this.modalInputs[this.action];
            },
            //Save update or new user
            updateOrCreateUser(user) {
                this.users[user['id']] = user;
            },
            deleteUser(user) {
                delete this.users[user['id']];
            },
            banUser(user) {
                this.users[user['id']]['banned'] = true;
            }
        }
    }
</script>

<style scoped>

</style>
