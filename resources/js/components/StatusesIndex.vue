<template>
    <div>
        <h3 class="text-center">Все статусы</h3><br/>
        <router-link :to="{name: 'status.new', params: {  }}" class="btn btn-primary">
            Добавить статус
        </router-link>

        <form @submit.prevent="onSearch($event)" class="row">
            <div class="form-group col-md-5">
                <label for="exampleInputEmail1">Статус</label>
                <input type="text" v-model="filter.title" class="form-control" id="exampleInputEmail1"
                       aria-describedby="emailHelp">

            </div>
            <div class="form-group col-md-5">
                <button type="submit" class="btn btn-primary">Найти</button>
            </div>

        </form>


        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>

                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="status in statuses" :key="status.id">
                <td>{{ status.id }}</td>
                <td>{{ status.title }}</td>

                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'status.edit', params: { id: status.id }}" class="btn btn-primary">
                            Редактировать
                        </router-link>
                        <button class="btn btn-danger" @click="deleteStatus(status.id)">Удалить</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "StatusIndex",
        data() {
            return {
                statuses: [],
                filter: [],
            }
        },
        created() {
            this.axios
                .get('/api/statuses')
                .then(response => {
                    this.statuses = response.data;
                });
        },
        methods: {
            deleteStatus(id) {
                this.axios
                    .delete(`/api/statuses/${id}`)
                    .then(response => {
                        let i = this.statuses.map(item => item.id).indexOf(id); // find index of your object
                        this.statuses.splice(i, 1)
                    });
            },
            onSearch(event) {
                event.preventDefault();
                var app = this;

                this.axios
                    .get('/api/statuses', {
                        params: {
                            status: app.filter.title
                        }
                    })
                    .then(response => {
                        this.statuses = response.data;
                    });
            }
        }
    }
</script>
