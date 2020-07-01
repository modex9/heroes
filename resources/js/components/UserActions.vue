<template>
    <div id="userActions">
        <select v-model="selected" :name="formSelectName()"  :id="formSelectName()" @change="sendAction()">
            <option v-for="action in actions" :value="formatAction(action)">{{action}}</option>
        </select>
    </div>
</template>

<script>
    export default {
        name: "UserActions",
        props: ['userId'],
        data : function () {
            return {
                selected : '',
                actions : ['Edit', 'Delete', 'Ban', 'Unban'],
                modalData : {
                  type : ''
                },
            }
        },
        methods : {
            formSelectName : function () {
                return `userActions-${this.userId}`
            },
            formatAction : function (act) {
                return `${act}-${this.userId}`.toLowerCase();
            },
            sendAction : function () {
                this.$emit('change', this.selected);
                this.selected = undefined;
            },

        }
    }
</script>

<style scoped>

</style>
