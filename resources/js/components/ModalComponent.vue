<template>
    <div>
        <!-- The Modal -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Modal Heading</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <input class="form-control" v-model="data.name">
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" @click="changeData()" class="btn btn-success" data-dismiss="modal">Change
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios"
    import VueSwal from 'vue-swal'

    export default {
        data() {
            return {}
        },
        components: {
            VueSwal,
        },
        props: ['data'],
        methods: {
            getOrder() {
                axios.put('', {
                    id: this.data.id,
                    name: this.data.name,
                }).then((res) => {
                    this.alertMessage();
                    this.data.name = '';
                })
            },
            changeData() {
                axios.put('', {
                    id: this.data.id,
                    name: this.data.name,
                }).then((res) => {
                    this.alertMessage();
                    this.data.name = '';
                    this.$emit('fromModal',res.data)
                })
            },
            alertMessage() {
                this.$swal("Congratulations!", "Category name changed!", "success")
            }
        },
    }
</script>
