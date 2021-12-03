<template>
  <div class="my-template" >
    <AppHeader/>
    <div class="container-fluid">
      <div class="row">
        <AppSidebar/>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 my-main">
          <!--model-->
          <div class="modal fade"
               id="exampleModal"
               tabindex="-1"
               aria-labelledby="exampleModalLabel"
               aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">
                    <span>Entries</span>
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form :class="formClassNames.join(' ')" novalidate>
                    <div class="mb-3">
                      <label for="colorInput" class="form-label">Color</label>
                      <input v-model="productColorViewModel.colorName" type="text" class="form-control" id="colorInput" required>
                      <div class="invalid-feedback">
                        Please give color name!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                  </form>
                </div>
                <div v-if="response.code === 1" class="modal-footer">
                  <button class="btn btn-primary" >
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                  </button>
                </div>
                <div v-else class="modal-footer">
                  <button v-if="productColorViewModel.id === 0"
                          type="submit"
                          class="btn btn-primary"
                          v-on:click="verifyInput('create')" >
                    Save
                  </button>
                  <button v-else
                          type="submit"
                          class="btn btn-warning"
                          v-on:click="verifyInput('update')" >
                    Update
                  </button>
                  <button v-on:click="onReset" class="btn btn-outline-dark" >Reset</button>
                </div>
              </div>
            </div>
          </div>
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
          <!--heading-->
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
                        ref="addColorBtn"
                        type="button"
                        class="btn btn-sm btn-outline-secondary"
                        data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                  <i class="fas fa-plus" ></i>
                </button>
              </div>
            </div>
          </div>
          <!--table-->
          <table class="table table-striped table-sm">
            <thead>
            <tr>
              <th>SL</th>
              <th>Color Name</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            <tr  v-for="(c,i) in productColorViewModel.productColors" >
              <td>{{i+1}}</td>
              <td>{{c.colorName}}</td>
              <td><i class="fas fa-edit cp" v-on:click="setFormDate(c)" ></i></td>
              <td><i class="fas fa-trash cp" v-on:click="onDelete(c)" ></i></td>
            </tr>
            </tbody>
          </table>

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
                formClassNames : ["needs-validation"],
                cookieUserInfo : "",
                showValidation : false,
                productColorViewModel: {
                    id: 0,
                    colorName : "",
                    productColors : []
                },
                response : {
                    code : 1,
                    msg : "Loading...",
                },
            }
        },
        methods : {
            onDelete(c){
                let config = {
                    data: {
                        userInfo : {
                            email : this.cookieUserInfo.email,
                            href : window.location.pathname,
                            sessionId : this.cookieUserInfo.sessionId
                        },
                        productColorViewModel : {
                            id : c.id
                        }
                    }
                };

                this.$axios.$delete("/colors",config).then(res=>{
                    this.onResetResponse(res.code,res.msg);
                    if(res.code === 200){
                        this.productColorViewModel.productColors = res.productColorViewModel.productColors;
                    }
                }).catch(err=>{
                    this.onResetResponse(404,"Something went wrong, please try again!");
                });
            },
            setFormDate(c){
                this.$refs.addColorBtn.click();
                this.productColorViewModel.id = c.id;
                this.productColorViewModel.colorName = c.colorName;
            },
            verifyInput(which){
                this.formClassNames.push("was-validated");
                if(which === "create" || which === "update"){
                    if(this.productColorViewModel.colorName){
                        which === "create" ? this.onCreate() : this.onUpdate();
                    }
                }
            },
            onUpdate(){
                this.onResetResponse(1,"Loading...");
                this.$axios.$put('/colors/',{
                    userInfo : {
                        email : this.cookieUserInfo.email,
                        sessionId: this.cookieUserInfo.sessionId,
                        href : window.location.pathname
                    },
                    productColorViewModel : this.productColorViewModel
                }).then(res=>{
                    this.onResetResponse(res.code,res.msg);
                    if(res.code === 200){
                        this.productColorViewModel.productColors = res.productColorViewModel.productColors;
                    }
                }).catch(err=>{
                    this.onResetResponse(404,"Something went wrong, please try again!");
                });
            },
            onCreate(){
                this.onResetResponse(1,"Loading...");
                this.$axios.$post('/colors',{
                    userInfo : {
                        email : this.cookieUserInfo.email,
                        sessionId: this.cookieUserInfo.sessionId,
                        href : window.location.pathname
                    },
                    productColorViewModel : this.productColorViewModel
                }).then(res=>{
                    this.onResetResponse(res.code,res.msg);
                    if(res.code === 200){
                        this.productColorViewModel.productColors = res.productColorViewModel.productColors;
                    }
                }).catch(err=>{
                    this.onResetResponse(404,"Something went wrong, please try again!");
                });
            },
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
                        this.productColorViewModel.productColors = res.productColorViewModel.productColors;
                    }else {
                        this.response.code = res.code;
                        this.response.msg = res.msg;
                    }
                }).catch(err=>{
                    this.onResetResponse(404,"Something went wrong, please try again!");
                });
            },
            onReset(){
                this.productColorViewModel.colorName = "";
                this.productColorViewModel.id = 0;
            }
        }
    }
</script>

<style scoped>

</style>
