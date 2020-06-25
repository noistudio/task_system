<template>
    <div>
        <form @submit.prevent="onSubmit($event)">
            <div class="form-group">
                <label for="user_name">Название статуса</label>
                <input id="user_name" v-model="status.title"/>
            </div>

            <div class="form-group">
                <button type="submit">Изменить</button>
            </div>
        </form>
    </div>
</template>
<script>
    export default {
        name: "StatusesEdit",
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            app.statusId = id;
            axios.get('/api/statuses/' + id)
                .then(function (resp) {
                    app.status = resp.data;
                })
                .catch(function () {
                    alert("Не удалось загрузить статус")
                });
        },
        data() {
            return {
                status: {
                    id: null,
                    title: "",

                }
            };
        },
        methods: {
            onSubmit(event) {
                event.preventDefault();
                var app = this;
                var newStatus = app.status;
                axios.patch('/api/statuses/' + app.statusId, newStatus)
                    .then(function (resp) {
                        app.$router.replace('/statuses/all');
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Не удалось сохранить статус");
                    });
            }
        },
        created() {
            // @todo load user details
        }
    };
</script>
