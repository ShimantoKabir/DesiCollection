<template>
  <div class="my-template" >
    <AppHeader/>
    <div class="container-fluid">
      <div class="row">
        <AppSidebar/>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 my-main">
          <!-- Modal -->
          <div class="modal fade"
               id="exampleModal"
               tabindex="-1"
               aria-labelledby="exampleModalLabel"
               aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">
                    <span v-if="role.oid === 0" >Create Role</span>
                    <span v-else >Update Role</span>
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form :class="'user-creation-form needs-validation '+wasValidated" >
                    <div v-show="response.code !== 0 && response.init === 0" >
                      <div :class="response.code === 200 ? 'alert alert-dismissible fade show alert-success'
                        : 'alert alert-dismissible fade show alert-warning'" >
                        <strong v-if="response.code === 200" >SUCCESS!</strong>
                        <strong v-else >ERROR!</strong>
                        {{response.msg}}
                        <button v-on:click="onResetResponse" type="button" class="btn-close">
                        </button>
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="validationCustom01" class="form-label">Role Name</label>
                      <input v-model="role.roleName" type="text" class="form-control" id="validationCustom01" required>
                      <div class="invalid-feedback">
                        Role Name Required!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="validationCustom02" class="form-label">Role Power</label>
                      <input v-model="role.power" type="number" class="form-control" id="validationCustom02" required>
                      <div class="invalid-feedback">
                        Role Power Required!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-outline-dark" v-on:click="onReset" >Reset</button>
                  <button v-if="role.oid === 0" v-on:click="verifyInput('create')"
                          type="submit"
                          class="btn btn-primary"
                          :data-bs-dismiss="dataBsDismiss">
                    <span v-if="isNetworkOpStarted"
                          class="spinner-border spinner-border-sm"
                          role="status"
                          aria-hidden="true">
                    </span>
                    <span v-else>Save</span>
                  </button>
                  <button v-else v-on:click="verifyInput('update')"
                          type="submit"
                          class="btn btn-primary"
                          :data-bs-dismiss="dataBsDismiss">
                    <span v-if="isNetworkOpStarted"
                          class="spinner-border spinner-border-sm"
                          role="status"
                          aria-hidden="true">
                    </span>
                    <span v-else>Update</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div v-show="response.code !== 200 && response.init === 1"
               class="alert alert-warning alert-dismissible fade show alert-top"
               role="alert">
            <strong>
              <span v-if="isNetworkOpStarted"
                    class="spinner-border spinner-border-sm"
                    role="status" aria-hidden="true">
              </span>
              <span v-else >ERROR!</span>
            </strong>
            &nbsp;
            <span v-if="isNetworkOpStarted" >Loading...</span>
            <span v-else >{{response.msg}}</span>
            <button v-on:click="onResetResponse"
                    type="button" class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
            </button>
          </div>
          <!-- User table -->
          <div class="d-flex
            justify-content-between
            flex-wrap
            flex-md-nowrap
            align-items-center
            pt-3
            pb-2
            mb-3
            border-bottom">
            <h1 class="h2">Roles</h1>
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
          <table class="table table-striped table-sm">
            <thead>
            <tr>
              <th>SL</th>
              <th>Role</th>
              <th>Power</th>
              <th>Update</th>
            </tr>
            </thead>
            <tbody>
            <tr  v-for="(r,i) in roles" >
              <td>{{i+1}}</td>
              <td>{{r.roleName}}</td>
              <td>{{r.power}}</td>
              <td><i class="fas fa-edit cp" v-on:click="setFormDate(r)" ></i></td>
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
        name: "user",
        mounted(){
            this.cookieUserInfo = this.$cookies.get('userInfo');
            this.getInitialData();
        },
        data(){
            return{
                isNetworkOpStarted: false,
                cookieUserInfo : "",
                modalState : "close",
                dataBsDismiss : "",
                wasValidated : "",
                roles : [],
                role : {
                    oid: 0,
                    power : undefined,
                    roleName : undefined
                },
                response : {
                    code : 0,
                    msg : "",
                    init : 0
                }
            }
        },
        methods: {
            onReset(){
                this.wasValidated = "";
                this.role.oid =  0;
                this.role.power = undefined;
                this.role.roleName =  undefined;
                this.onResetResponse(0);
            },
            setFormDate(r){

                this.$refs.addRoleBtn.click();
                this.role.oid = r.oid;
                this.role.roleName = r.roleName;
                this.role.power = r.power;

            },
            onResetResponse(init){
                this.response.code = 0;
                this.response.msg = "";
                this.response.init = init;
            },
            getInitialData(){
                this.onResetResponse(1);
                this.isNetworkOpStarted = true;
                this.$axios.$post('/roles/view-init',{
                    userInfo : {
                        email : this.cookieUserInfo.email,
                        sessionId: this.cookieUserInfo.sessionId,
                        href : window.location.pathname
                    }
                }).then(res=>{
                    this.isNetworkOpStarted = false;
                    this.response.code = res.code;
                    this.response.msg = res.msg;
                    if(res.code === 200){
                        this.roles = res.roles;
                    }
                }).catch(err=>{
                    this.isNetworkOpStarted = false;
                    this.response.code = 404;
                    this.response.msg = "Something went wrong, please try again!";
                }).finally(end=>{
                    this.isNetworkOpStarted = false;
                });
            },
            onModalClose(){

            },
            onModalOpen(){
                this.onReset();
                this.onResetResponse();
            },
            verifyInput(which){
                if(this.role.roleName && this.role.power){
                    which === "create" ? this.onCreate() : this.onUpdate();
                }else {
                    this.wasValidated = "was-validated";
                }
            },
            onUpdate(){
                this.onResetResponse(0);
                this.isNetworkOpStarted = true;
                this.$axios.$put('/roles/'+this.role.oid,{
                    role : this.role,
                    userInfo : {
                        email : this.cookieUserInfo.email,
                        sessionId: this.cookieUserInfo.sessionId,
                        href : window.location.pathname
                    }
                }).then(res=>{

                    this.isNetworkOpStarted = false;
                    this.response.code = res.code;
                    this.response.msg = res.msg;

                    if(res.code === 200){
                        this.roles = res.roles;
                    }

                }).catch(err=>{
                    this.isNetworkOpStarted = false;
                    this.response.code = 404;
                    this.response.msg = "Something went wrong, please try again!";
                }).finally(end=>{
                    this.isNetworkOpStarted = false;
                });
            },
            onCreate(){
                this.onResetResponse(0);
                this.isNetworkOpStarted = true;
                this.$axios.$post('/roles',{
                    role : this.role,
                    userInfo : {
                        email : this.cookieUserInfo.email,
                        sessionId: this.cookieUserInfo.sessionId,
                        href : window.location.pathname
                    }
                }).then(res=>{

                    this.isNetworkOpStarted = false;
                    this.response.code = res.code;
                    this.response.msg = res.msg;

                    if(res.code === 200){
                        this.roles = res.roles;
                    }

                }).catch(err=>{
                    this.isNetworkOpStarted = false;
                    this.response.code = 404;
                    this.response.msg = "Something went wrong, please try again!";
                }).finally(end=>{
                    this.isNetworkOpStarted = false;
                });
            }
        }
    }
</script>

<style scoped>

</style>
