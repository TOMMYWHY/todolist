<template>
    <ul class="list-group">
        <div style="display:flex;justify-content: space-between; "
             class="list-group-item list-group-item-action " v-for="task in tasks" :key="task.id">

                                <span>
                                   <svg v-on:click="toggleTask(task)" v-if="task.completed == false" t="1618520878404"
                                        class="icon" viewBox="0 0 1024 1024" version="1.1"
                                        xmlns="http://www.w3.org/2000/svg" p-id="2596" width="32" height="32"><path
                                           d="M843.294118 347.015529h60.235294V963.764706H60.235294V120.470588h505.554824v60.235294H120.470588v722.82353h722.82353V347.015529zM292.382118 490.676706l-42.646589 42.646588 206.848 206.848L913.588706 46.742588l-50.296471-33.189647L446.945882 645.300706 292.382118 490.676706z"
                                           p-id="2597" fill="#bfbfbf"></path></svg>

                                    <svg v-on:click="toggleTask(task)" v-if="task.completed == true" t="1618521141436"
                                         class="icon" viewBox="0 0 1024 1024" version="1.1"
                                         xmlns="http://www.w3.org/2000/svg" p-id="3086" width="32" height="32"><path
                                            d="M843.294118 347.015529h60.235294V963.764706H60.235294V120.470588h505.554824v60.235294H120.470588v722.82353h722.82353V347.015529zM292.382118 490.676706l-42.646589 42.646588 206.848 206.848L913.588706 46.742588l-50.296471-33.189647L446.945882 645.300706 292.382118 490.676706z"
                                            p-id="3087" fill="#1296db"></path></svg>

                                </span>

            <div class="list-group-item d-flex justify-content-between title-text " v-if="edit_status == false || edit_status != task.id"
                  :class="task.completed==true? 'completed':'' ">{{task.title}}</div>
            <div >
                <input  class="form-control" v-if="edit_status == task.id" v-model="task.title" type="text">
            </div>
            <div>
                <span>
                    <svg id="xx" v-on:click="edit_status = task.id"
                         v-show="edit_status==false || edit_status!= task.id "
                         xmlns="http://www.w3.org/2000/svg"
                         class="icon icon-tabler icon-tabler-edit" width="36" height="36"
                         viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFC107" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z"/>
                      <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"/>
                      <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"/>
                      <line x1="16" y1="5" x2="19" y2="8"/>
                    </svg>
                <svg id="oo" v-on:click="updateTask(task)" v-show="edit_status== task.id"
                     xmlns="http://www.w3.org/2000/svg"
                     class="icon icon-tabler icon-tabler-checkbox" width="36" height="36" viewBox="0 0 24 24"
                     stroke-width="1.5"
                     stroke="#4CAF50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z"/>
                  <polyline points="9 11 12 14 20 6"/>
                  <path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9"/>
                </svg>



                </span>
                <button class="btn btn-danger btn-sm"   v-on:click="deleteTask(task)">delete</button>
            </div>

        </div>

    </ul>
</template>

<script>
    export default {
        name: "ListComponent",
        props: {
            tasks: Array,
        },
        data() {
            return {
                title: "",
                // tasks: [],
                err_msg: [],
                edit_status: false,
            }
        },
        methods: {
            //checkbox
            toggleTask(task) {
                task.completed = !task.completed;
                let data;
                if (task.completed == true) {
                    data = {is_completed: 1, title: task.title}
                } else {
                    data = {is_completed: 0, title: task.title}
                }
                axios.patch('/task/' + task.id, data)
                    .then((res) => {
                        console.log(res.data)
                    })
                    .catch((err) => {
                        console.log(err)
                    })
            },
            // editTask
            updateTask(task) {
                this.edit_status = false
                console.log(this.edit_status)
                // todo: if not change doesnt send
                let data = {
                    is_completed: task.completed,
                    title: task.title
                }
                axios.patch('/task/' + task.id, data)
                    .then((res) => {
                        console.log(res.data)
                    })
                    .catch((err) => {
                        console.log(err)
                    })
            },
            deleteTask(task) {

                axios.delete('/task/' + task.id)
                    .then((res) => {
                        let del_id = res.data.id;
                        if (res.data = !0) {
                            for (let i = 0; i < this.tasks.length; i++) {
                                if (this.tasks[i].id == del_id) {
                                    this.tasks.splice(i, 1)
                                }
                            }
                        }
                    })
                    .catch((err) => {
                        console.log(err)
                    })

            },
        },
        mounted() {

        }
    }
</script>

<style scoped>
.title-text{
    border: none;
    background-color:inherit;
}
</style>