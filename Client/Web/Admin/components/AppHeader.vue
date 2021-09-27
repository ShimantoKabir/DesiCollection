<template>
  <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 cp" v-on:click="goToHome" >
      <i class="fas fa-home" ></i> &nbsp; Dashboard
    </a>
    <button class="navbar-toggler position-absolute d-md-none collapsed"
            type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu"
            aria-controls="sidebarMenu"
            aria-expanded="false"
            aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-nav extra-nav-item">
      <div class="nav-item">
        <a class="px-3 cp" v-on:click="logout" title="Logout" ><i class="fas fa-power-off" ></i></a>
        <a class="px-3 cp" title="Profile" ><i class="fas fa-user-circle" ></i></a>
        <a class="px-3 cp" href="#" title="Notification" ><i class="fas fa-bell" ></i></a>
      </div>
    </div>
  </header>
</template>

<script>
    export default {
        name: "AppHeader",
        methods:{
            logout(){
                localStorage.clear();
                this.$cookies.removeAll();
                this.$router.push({path: '/'});
            },
            goToHome(){
                this.$router.push({path: '/dashboard/home'});
            }
        }
    }
</script>

<style scoped>
  .navbar-brand {
    padding-top: .75rem;
    padding-bottom: .75rem;
    font-size: 1rem;
    background-color: rgba(0, 0, 0, .25);
    box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
  }

  .navbar .navbar-toggler {
    top: .25rem;
    right: 1rem;
  }

  .extra-nav-item > div > a > i{
    color: white;
  }

</style>
