<template>
    <div id="app">
        <h1>Hello App!</h1>
        <p>
            <router-link to="/">Home</router-link>
            <router-link to="/about">About</router-link>
            <router-link to="/user">User</router-link>
            <router-link to="/auth/login">Login</router-link>
        </p>
        <transition name="el-fade-in-linear">
            <router-view></router-view>
        </transition>
    </div>
</template>

<script>
    export default {
        name: 'adminApp'
    }
</script>

<style lang="css" scoped>

</style>
