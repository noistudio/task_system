<template>
    <div class="container">
        <div class="text-center" style="margin: 20px 0px 20px 0px;">

            <span class="text-secondary">Task System</span>
        </div>


        <nav v-if="this.isadmin==1 && this.isauth==1"
             class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <router-link to="/" class="nav-item nav-link">Работники</router-link>
                    <router-link to="/tasks" class="nav-item nav-link">Задачи</router-link>
                    <router-link to="/statuses/all" class="nav-item nav-link">Статусы</router-link>

                </div>
                <button v-on:click="logout">Выход</button>
            </div>
        </nav>
        <nav v-if="this.isadmin==0 && this.isauth==1"
             class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">

                    <router-link to="/tasks" class="nav-item nav-link">Мои задачи</router-link>

                </div>
                <button v-on:click="logout">Выход</button>
            </div>
        </nav>
        <br/>
        <router-view></router-view>
    </div>
</template>

<script>
    export default {}
</script>

<script>
    export default {
        name: "App",
        data() {
            return {
                'isauth': false,
                'isadmin': false,
            }

        },
        mounted() {
            let app = this;


            app.loadUserInfo(app.$store.getters.TOKEN);
            app.$root.$on('reload', (token) => { // here you need to use the arrow function

                app.loadUserInfo(app.$store.getters.TOKEN);


            })
            app.$root.$on('update_user_info', (isauth, isadmin) => { // here you need to use the arrow function

                app.isauth = isauth;
                app.isadmin = isadmin;

                if (isadmin == true) {
                    app.$router.replace('/');
                } else {
                    app.$router.replace('/tasks');
                }

            })


        },
        methods: {
            logout: function (event) {
                // `this` внутри методов указывает на экземпляр Vue
                localStorage.removeItem('api_token');
                this.isauth = false;
                this.isadmin = false;
                this.$store.commit('SET_TOKEN', '');
                this.$router.replace('/login');

            },
        }

    }
</script>

<style scoped>

</style>
