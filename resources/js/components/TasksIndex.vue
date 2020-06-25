<template>
    <div>
        <h3 class="text-center">Все задачи</h3><br/>
        <router-link :to="{name: 'tasks.add', params: {  }}" class="btn btn-primary">
            Добавить задачу
        </router-link>

        <form @submit.prevent="onSearch($event)" class="row">
            <div class="form-group col-md-5">
                <label for="exampleInputEmail1">Название задания</label>
                <input type="text" v-model="filter.name" class="form-control" id="exampleInputEmail1"
                       aria-describedby="emailHelp">

            </div>
            <div class="form-group col-md-5">
                <label for="exampleInputEmail2">Описание</label>
                <input type="text" v-model="filter.description" class="form-control" id="exampleInputEmail2"
                       aria-describedby="emailHelp">

            </div>
            <div class="form-group">
                <label for="user_status">Статус</label>
                <select class="form-control" id="user_status" v-model="filter.status_id">
                    <option v-for="status in statuses" :value="status.id">{{status.title}}</option>
                </select>

            </div>

            <div class="form-group col-md-5">
                <button type="submit" class="btn btn-primary">Найти</button>
            </div>

        </form>


        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Название задачи</th>
                <th>Описание</th>
                <th>Сотрудники</th>
                <th>Статус</th>

                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="task in tasks" :key="task.id">
                <td>{{ task.name }}</td>
                <td>{{ task.description }}</td>
                <td>
                    <div v-if="task.users.length>0">
                        <p v-for="user in task.users" :key="user.id">
                            {{ user.user.surname }} {{ user.user.name }} {{ user.user.fathername }}
                        </p>
                    </div>
                </td>
                <td>{{ task.status.title}}</td>


                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'tasks.edit', params: { id: task.id }}" class="btn btn-primary">
                            Редактировать
                        </router-link>
                        <button class="btn btn-danger" @click="deleteUser(task.id)">Удалить</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "TasksIndex",
        data() {
            return {
                tasks: [],
                statuses: [],
                filter: [],
            }
        },
        created() {
            this.axios
                .get('/api/tasks')
                .then(response => {
                    this.tasks = response.data;
                });

            this.axios
                .get('/api/statuses')
                .then(response => {
                    this.statuses = response.data;
                });
        },
        methods: {
            deleteUser(id) {
                this.axios
                    .delete(`/api/tasks/${id}`)
                    .then(response => {
                        let i = this.tasks.map(item => item.id).indexOf(id); // find index of your object
                        this.tasks.splice(i, 1)
                    });
            },

            onSearch(event) {
                event.preventDefault();
                var app = this;

                this.axios
                    .get('/api/tasks', {
                        params: {
                            name: app.filter.name,
                            status_id: app.filter.status_id,
                            description: app.filter.description,
                        }
                    })
                    .then(response => {
                        this.tasks = response.data;
                    });
            }
        }
    }
</script>
