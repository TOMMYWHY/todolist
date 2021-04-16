<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h3>Username: {{user.name}}</h3></div>

                    <div class="card-body">
                        <div>
                            <echarts-component :tasks="tasks"></echarts-component>
                        </div>

                        <hr>

                        <div>
                            <input-component @addTask="addTask"></input-component>

                        </div>


                        <hr>
                        <list-component :tasks="tasks" ></list-component>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            user: Object,
        },

        data() {
            return {
                tasks: [],

            }
        },
        methods: {
            addTask(task){
                this.tasks.unshift(task)
            },
        },


        mounted() {
            axios.get('/task').then((res) => {
                this.tasks = res.data.reverse()
            })
        }
    }
</script>
