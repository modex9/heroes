<template>
    <div class="modal fade" v-bind:id="id" tabindex="-1" role="dialog" aria-labelledby="l" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="xc">{{modalId}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <form method="post" id="x" action="">

                </form>
            </div>
            <div class="modal-footer">

            </div>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "UserActionModal",
        props : ['action', 'visible'],
        data : function() {
            return {
                id : '',
            }
        },
        watch : {
            modalId() {
                this.id = this.modalId;
                this.$nextTick(() => {
                   $(`#${this.id}`).modal();
                });
                //this.$emit('show-modal', this.id);
                //$(`#${this.action}-modal`).modal();
            }
        },
        computed : {
            modalId() {
                return `${this.action}-modal`;
            },
        },
        methods : {
            // appendAction(postfix) {
            //     this.modalId = `${this.action}${postfix}`;
            // },
        },
    }
</script>

<style scoped>

</style>
