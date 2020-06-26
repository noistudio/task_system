<template>
    <div>
        <form @submit.prevent="onSubmit($event)">
            <div class="form-group">
                <label for="user_email">Email</label>
                <input class="form-control" type="email" id="user_email" required v-model="user.email"/>
            </div>
            <div class="form-group">
                <label for="user_password">Пароль</label>
                <input class="form-control" id="user_password" required v-model="user.password"/>
            </div>
            <div class="form-group">
                <label for="user_name">Имя</label>
                <input class="form-control" id="user_name" required v-model="user.name"/>
            </div>
            <div class="form-group">
                <label for="user_surname">Фамилия</label>
                <input class="form-control" id="user_surname" required v-model="user.surname"/>
            </div>
            <div class="form-group">
                <label for="user_fathername">Отчество</label>
                <input class="form-control" id="user_fathername" required v-model="user.fathername"/>
            </div>
            <div class="form-group">
                <label for="user_image">Фото</label>


                <input class="form-control" type="file" id="file" ref="file" v-on:change="processFile($event)"/>
            </div>
            <div class="form-group">
                <table>
                    <tr v-for="(task,index) in tasks" :key="task.id">
                        <td><input type="checkbox" :value="task.id" :true-value="task.id"
                                   :id="task.id" v-model="user.tasks[index]">
                        </td>
                        <td>{{ task.name }}</td>


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
        name: "UsersAdd",
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            app.user = {};
            app.user.tasks = [];
            axios.get('/api/tasks')
                .then(function (resp) {
                    app.tasks = resp.data;

                })
                .catch(function () {
                    alert("Не удалось загрузить задания")
                });
        },
        data() {
            return {
                user: {
                    id: null,
                    email: "",
                    name: "",
                    surname: "",
                    fathername: "",
                    image: "",
                    tasks: []

                },
                tasks: {},
                tasksId: undefined,
            };
        },
        methods: {
            onSubmit(event) {
                event.preventDefault();
                var app = this;
                var newUser = app.user;


                axios.post('/api/users/', newUser)
                    .then(function (resp) {
                        //alert('Успешно!');
                        app.$router.replace('/');
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Не удалось работника");
                    });
            },
            processFile(event) {
                var parent = this;
                this.user.image = event.target.files[0];
                let formData = new FormData();
                formData.append('file', event.target.files[0]);
                axios.post('/api/users/upload',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(function (resp) {
                    if (resp.data.image) {
                        parent.user.image = resp.data.image;
                    }

                })
                    .catch(function () {
                        console.log('FAILURE!!');
                    });
            }
        },
        created() {
            // @todo load user details
        }
    };
</script>
