<template>
    <div>
        <form @submit.prevent="onSubmit($event)">


            <div class="form-group">
                <label for="user_name">Название задачи</label>
                <input class="form-control" id="user_name" required v-model="task.name"/>
            </div>

            <div class="form-group">
                <label for="user_status">Статус</label>
                <select class="form-control" id="user_status" required v-model="task.status_id">
                    <option v-for="status in statuses" :value="status.id">{{status.title}}</option>
                </select>

            </div>
            <div class="form-group">
                <label for="user_surname">Описание</label>
                <textarea class="form-control" id="user_surname" required v-model="task.description"></textarea>

            </div>

            <div class="form-group">
                <table>
                    <tr v-for="(user,index) in users" :key="user.id">
                        <td><input type="checkbox" :value="user.id" v-model="task.users[user.id]">
                        </td>
                        <td>{{ user.id }} {{ user.surname }} {{ user.name }} {{ user.fathername }}</td>


                    </tr>
                </table>
            </div>

            <div class="form-group">
                <button class="form-control" type="submit">Сохранить</button>
            </div>
        </form>
    </div>
</template>
<script>
    export default {
        name: "TasksAdd",
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            app.task = {};
            app.task.users = {}

        },
        data() {
            let users = this.axios
                .get('/api/users')
                .then(response => {
                    this.users = response.data;
                });
            let statuses = this.axios
                .get('/api/statuses')
                .then(response => {
                    this.statuses = response.data;
                });

            return {
                task: {
                    id: null,

                    name: "",
                    description: "",
                    users: [],


                },
                users: users,
                statuses: statuses,
                checkedUsers: [],
            };
        },
        methods: {
            onSubmit(event) {
                event.preventDefault();
                var app = this;
                var newTask = app.task;
                axios.post('/api/tasks/', newTask)
                    .then(function (resp) {
                        //alert('Успешно!');
                        app.$router.replace('/tasks');
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Не удалось создать задачу");
                    });
            },

        },
        created() {
            // @todo load user details
        }
    };
</script>
