<template>
  <div class="my-template" >
    <AppHeader/>
    <div class="container-fluid">
      <div class="row">
        <AppSidebar/>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 my-main">
          <!--alert-->
          <div v-show="response.code === 1 || response.code === 200 || response.code === 404"
               class="alert alert-warning alert-dismissible fade show alert-top"
               role="alert">
            <strong>
              <span v-if="response.code === 1" class="spinner-border spinner-border-sm"></span>
              <span v-else-if="response.code === 200" >SUCCESS!</span>
              <span v-else-if="response.code === 404" >ERROR!</span>
              <span v-else >Unknown</span>
            </strong>
            &nbsp;
            <span>{{response.msg}}</span>
            <button v-on:click="onResetResponse(0,'')" type="button" class="btn-close"></button>
          </div>
          <div class="d-flex
            justify-content-between
            flex-wrap
            flex-md-nowrap
            align-items-center
            pt-3
            pb-2
            mb-3
            border-bottom">
            <h1 class="h2">Color</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group me-2">
                <button v-on:click="onModalOpen"
                        ref="addRoleBtn"
                        type="button"
                        class="btn btn-sm btn-outline-secondary"
                        data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                  <i class="fas fa-plus" ></i>
                </button>
              </div>
            </div>
          </div>

          <form class="needs-validation" novalidate>
            <div class="mb-3">
              <label for="colorInput" class="form-label">Color</label>
              <input type="text" class="form-control" id="colorInput" >
              <div class="invalid-feedback">
                Please give your email address!
              </div>
              <div class="valid-feedback">
                Looks good!
              </div>
            </div>
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </form>

        </main>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
        name: "color",
        mounted() {
            this.cookieUserInfo = this.$cookies.get('userInfo');
            this.getInitialData();
        },
        data(){
            return{
                cookieUserInfo : "",
                showValidation : false,
                response : {
                    code : 1,
                    msg : "Loading...",
                },
            }
        },
        methods : {
            onModalOpen(){

            },
            onResetResponse(code,msg){
                this.response.code = code;
                this.response.msg = msg;
            },
            getInitialData(){
                this.$axios.$post('/colors/view-init',{
                    userInfo : {
                        email : this.cookieUserInfo.email,
                        sessionId: this.cookieUserInfo.sessionId,
                        href : window.location.pathname
                    }
                }).then(res=>{

                    if(res.code === 200){
                        this.onResetResponse(0,"");
                    }else {
                        this.response.code = res.code;
                        this.response.msg = res.msg;
                    }


                }).catch(err=>{
                    this.onResetResponse(404,"Something went wrong, please try again!");
                });
            },
        }
    }
</script>

<style scoped>

</style>
