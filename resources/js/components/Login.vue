<template>


    <form @submit.prevent="onSubmit($event)">
        <p>Данные от аккаунта админа </p>
        <p>root@noi.studio:123456</p>
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" required v-model="user.email">

        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Пароль</label>
            <input type="password" class="form-control" required v-model="user.password">
        </div>

        <button type="submit" class="btn btn-primary">Войти</button>
    </form>
</template>

<script>
    export default {
        name: "Login",
        data() {
            return {
                user: {
                    id: null,
                    email: "",
                    password: ""

                },

            };
        },
        methods: {
            onSubmit(event) {
                event.preventDefault();
                var app = this;
                var newUser = app.user;


                axios.post('/api/login', newUser)
                    .then(function (resp) {
                        //alert('Успешно!');
                        if (resp.data.api_token) {

                            localStorage.setItem('api_token', resp.data.api_token);
                            app.$store.commit('SET_TOKEN', resp.data.api_token);


                            app.$root.$emit('reload', resp.data.api_token);
                        } else {
                            localStorage.removeItem('api_token');
                            alert(resp.data.message)
                        }
                        // app.$router.replace('/');
                    })
                    .catch(function (resp) {

                        console.log(resp);

                    });
            }
        }
    }
</script>

<style scoped>

</style>
