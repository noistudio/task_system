<template>
    <div>
        <h3 class="text-center">Все сотрудники</h3><br/>
        <router-link :to="{name: 'users.add', params: {  }}" class="btn btn-primary">
            Добавить сотрудника
        </router-link>

        <form @submit.prevent="onSearch($event)">
            <div class="row">
                <div class="form-group col-md-5">
                    <label for="exampleInputEmail1">Имя</label>
                    <input type="text" v-model="filter.name" class="form-control" id="exampleInputEmail1"
                           aria-describedby="emailHelp">

                </div>
                <div class="form-group col-md-5">
                    <label for="exampleInputEmail2">Фамилия</label>
                    <input type="text" v-model="filter.surname" class="form-control" id="exampleInputEmail2"
                           aria-describedby="emailHelp">

                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="exampleInputEmail2">Отчество</label>
                    <input type="text" v-model="filter.fathername" class="form-control" id="exampleInputEmail3"
                           aria-describedby="emailHelp">

                </div>
                <div class="form-group col-md-3">
                    <label for="exampleInputEmail2">Название задания</label>
                    <input type="text" v-model="filter.task" class="form-control" id="exampleInputEmail4"
                           aria-describedby="emailHelp">

                </div>
                <div class="form-group col-md-3">
                    <button type="submit" class="btn btn-primary">Найти</button>
                </div>
            </div>


        </form>


        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ФИО</th>
                <th>Фото</th>
                <th>Задачи</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in users" :key="user.id">
                <td>{{ user.id }}</td>
                <td>{{ user.name }} {{ user.surname }} {{ user.fathername }}</td>
                <td>

                    <img v-if="user.image==undefined" :src="getImgUrl()"
                         class="img img-thumbnail">
                    <img v-if="user.image!=undefined" :src="user.image" class="img img-thumbnail"></td>
                <td>
                    <div v-if="user.tasks.length>0">
                        <p v-for="task in user.tasks" :key="task.id">
                            {{ task.task.name }} {{ task.task.status.title }}
                        </p>
                    </div>
                </td>

                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'user.edit', params: { id: user.id }}" class="btn btn-primary">
                            Редактировать
                        </router-link>
                        <button class="btn btn-danger" @click="deleteUser(user.id)">Удалить</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "UsersIndex",
        data() {
            return {
                users: [],
                filter: [],
            }
        },
        created() {
            this.axios
                .get('/api/users')
                .then(response => {
                    this.users = response.data;
                });
        },
        methods: {
            deleteUser(id) {
                this.axios
                    .delete(`/api/users/${id}`)
                    .then(response => {
                        let i = this.users.map(item => item.id).indexOf(id); // find index of your object
                        this.users.splice(i, 1)
                    });
            },
            getImgUrl() {
                var random = Math.random();
                var url = 'https://api.adorable.io/avatars/285/' + random + '.png';
                return url;
            },
            onSearch(event) {
                event.preventDefault();
                var app = this;

                this.axios
                    .get('/api/users', {
                        params: {
                            name: app.filter.name,
                            surname: app.filter.surname,
                            fathername: app.filter.fathername,
                            task: app.filter.task,
                        }
                    })
                    .then(response => {
                        this.users = response.data;
                    });
            }
        }
    }
</script>
