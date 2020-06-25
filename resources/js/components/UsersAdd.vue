<template>
    <div>
        <form @submit.prevent="onSubmit($event)">
            <div class="form-group">
                <label for="user_email">Email</label>
                <input type="email" id="user_email" required v-model="user.email"/>
            </div>

            <div class="form-group">
                <label for="user_name">Имя</label>
                <input id="user_name" required v-model="user.name"/>
            </div>
            <div class="form-group">
                <label for="user_surname">Фамилия</label>
                <input id="user_surname" required v-model="user.surname"/>
            </div>
            <div class="form-group">
                <label for="user_fathername">Отчество</label>
                <input id="user_fathername" required v-model="user.fathername"/>
            </div>
            <div class="form-group">
                <label for="user_image">Фото</label>


                <input type="file" id="file" ref="file" v-on:change="processFile($event)"/>
            </div>

            <div class="form-group">
                <button type="submit">Сохранить</button>
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

                }
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
