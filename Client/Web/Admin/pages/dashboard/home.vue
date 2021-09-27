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

                this.$nuxt.$loading.start();

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
