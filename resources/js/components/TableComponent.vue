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
            <user-action-modal :action="selectedAction"></user-action-modal>
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
                //showModal : false,
            }
        },
        created() {
            this.fetchUsers();
            this.fetchRoles();
        },
        methods : {
            fetchUsers() {
                this.users = this.error = null;
                this.loading = true;
                fetch(this.usersRoute)
                    .then(data => data.json())
                    .then(data => this.users = data)
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
                // $('[id$="modal"]').modal();
            },
            // showModal(modal) {
            //     $(`#${modal}`).modal();
            // }
        }
    }
</script>

<style scoped>

</style>
