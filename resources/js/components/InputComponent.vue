<template>
    <div class="InputComponent">
        <form class="form-inline">
            <div class="form-group row _center">
                <label  class="col-sm-2 col-form-label">Title:</label>
                <div class="col-sm-10">
                    <input class="form-control"   type="text"
                           :class="{'is-invalid':err_msg.length>0}" v-model="title"  >
                    <button @click="saveData()" type="button" class="btn btn-primary ">Add</button>
                </div>
            </div>

        </form>
        <div class="text-danger text-center " v-if="err_msg.length>0">Error msg: {{err_msg[0]}}</div>


    </div>
</template>

<script>
    export default {
        name: "InputComponent",
        data(){
            return{
                title: "",
                err_msg: [],
            }
        },

        methods:{
            saveData() {
                let data = {title: this.title}
                axios.post('/task', data).then((res) => {
                    if (res.data != 0) {
                        // this.tasks.unshift(res.data)
                        this.$emit("addTask",res.data)
                        this.title = ""
                    }
                }).catch((err) => {
                    if (err.response) {
                        this.err_msg.push(err.response.data.errors.title[0])
                        console.log(this.err_msg)//todo
                    }

                })
            },
        }
    }
</script>

<style scoped>

</style>