<template xmlns:width="http://www.w3.org/1999/xhtml">
    <div id="users">
        <table id="user-table" class="centered">
            <thead v-if="headers.length > 0">
            <th v-for="header in headers" v-text="header"></th>
            </thead>
            <tr v-if="loading"><td colspan="5">Loading...</td></tr>
            <div v-if="error">{{error}}</div>
            <tbody v-if="users && roles">
            <tr v-for="user in users">
                <td>{{user.nickname}}</td>
                <td>{{user.email}}</td>
                <td>{{user.referral}}</td>
                <td>{{roles[user.role_id]['name']}}</td>
                <td><user-actions @change="updateSelected"  :user-id="user.id"></user-actions></td>
            </tr>
            </tbody>
        </table>
        <div>
            <user-action-modal @user-updated="updateUser" :title="editTitle" :inputs="inputFields()" :user="modalInputs['user']" :action="selectedAction"></user-action-modal>
        </div>
    </div>

</template>

<script>

    import UserActions from "./UserActions";
    import UserActionModal from "./UserActionModal";

    export default {
        name: "TableComponent",
        props : ['usersRoute', 'rolesRoute'],
        components : {
            UserActions, UserActionModal
        },
        data : function () {
            return {
                loading : false,
                users : null,
                error : null,
                roles : null,
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
                            placeholder : 'Leaving empty will leave password the same.',
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
                    user : {},
                },
            }
        },
        watch : {
        },
        created() {this.modalInputs['edit']['role']['options'] = this.roles;
            this.fetchUsers();
            this.fetchRoles();
        },
        computed : {
            action() {
                return this.selectedAction.split('-')[0];
            },
            userId() {
                return this.selectedAction.split('-')[1];
            },
            editTitle() {
              return `Edit user ${this.modalInputs['user']['nickname']}`
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
                            this.modalInputs['edit']['role']['options'] = roles;
                        }
                    )
                    .catch(error => this.error = error)
                    .then(() => {
                        if(this.users)
                            this.loading = false;
                    });
            },
            updateSelected(value) {
                this.selectedAction = value;
            },
            inputFields() {
                if (this.action == 'edit')
                    this.modalInputs['user'] = this.users[this.userId];
                return this.modalInputs[this.action];
            },
            updateUser(user) {
                this.users[user['id']] = user;
            }
        }
    }
</script>

<style scoped>

</style>
