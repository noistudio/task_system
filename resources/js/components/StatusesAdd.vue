<template>
    <div>
        <form @submit.prevent="onSubmit($event)">
            <div class="form-group">
                <label for="user_name">Название статуса</label>
                <input class="form-control" id="user_name" v-model="status.title"/>
            </div>

            <div class="form-group">
                <button class="form-control" type="submit">Изменить</button>
            </div>
        </form>
    </div>
</template>
<script>
    export default {
        name: "StatusesAdd",
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            app.status = {};
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
                axios.post('/api/statuses/', newStatus)
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
