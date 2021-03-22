<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="#">
                    {{ config.app.name }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li  class="nav-item"><router-link class="nav-link" :to="{name: 'home'}">Home</router-link></li>
                        <li  class="nav-item"><router-link class="nav-link" :to="{name: 'products'}">Products</router-link></li>
                        <li  class="nav-item"><router-link class="nav-link" :to="{name: 'suppliers'}">Suppliers</router-link></li>
                        <li  class="nav-item"><router-link class="nav-link" :to="{name: 'orders'}">Orders</router-link></li>
                        <!-- Authentication Links -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                User Here <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/logout">Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <router-view></router-view>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
export default {
    name: "App",
    data() {
        return {
            config: window.Laravel
        }
    },
    mounted(){
        this.$store.dispatch('fetchCurrentUser');
    }
}
</script>

<style scoped>

</style>
