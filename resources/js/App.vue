<template>
    <div class="container">
        <div class="text-center" style="margin: 20px 0px 20px 0px;">

            <span class="text-secondary">Task System</span>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <router-link to="/" class="nav-item nav-link">Работники</router-link>
                    <router-link to="/tasks" class="nav-item nav-link">Задачи</router-link>
                    <router-link to="/statuses/all" class="nav-item nav-link">Статусы</router-link>
                </div>
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
        name: "App"
    }
</script>

<style scoped>

</style>
