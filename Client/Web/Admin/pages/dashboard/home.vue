<template>
    <main>
      <button v-on:click="goLogin" ></button>
    </main>
</template>

<script>
    export default {
        name: "home",
        methods: {
            goLogin(){

                this.$router.push({path: '/dashboard/administration/user'});

                // this.$nuxt.$loading.start();
                // let stringUserInfo = localStorage.getItem("userInfo");
                //
                // console.log("userinfo = ",JSON.parse(stringUserInfo));

                // this.$axios.$post('/user-info/reload').then(res=>{
                //     console.log("res = ",res);
                // }).catch(err=>{
                //     console.log("err = ",err);
                // }).finally(end=>{
                //     console.log("end = ",end);
                // });
            }
        }
    }
</script>

<style scoped>

</style>
