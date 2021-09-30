<template>
  <div class="my-template" >
    <AppHeader/>
    <div class="container-fluid">
      <div class="row">
        <AppSidebar/>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 my-main">
          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Create User</h5>
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
                      <label for="validationCustom01" class="form-label">Email/Username</label>
                      <input v-model="userInfo.email" type="email" class="form-control" id="validationCustom01" required>
                      <div class="invalid-feedback">
                        Email/Username Required!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="validationCustom02" class="form-label">Password</label>
                      <input v-model="userInfo.password" type="text" class="form-control" id="validationCustom02" required>
                      <div class="invalid-feedback">
                        Password Required!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="validationCustom03" class="form-label">Mobile Number</label>
                      <input v-model="userInfo.mobileNumber" type="tel" class="form-control" id="validationCustom03" required>
                      <div class="invalid-feedback">
                        Mobile Number Required!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="validationCustom04" class="form-label">Role</label>
                      <select v-model="userInfo.roleOid" class="form-select" id="validationCustom04" required>
                        <option :value="r.oid" v-for="r in roles" >{{r.role_name}}</option>
                      </select>
                      <div class="invalid-feedback">
                        Please select a role!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="validationCustom05" class="form-label">Permission</label>
                      <div id="validationCustom05" >
                        <div class="form-check-inline" >
                          <input v-model="userInfo.opAccess" value="C" class="form-check-input" type="checkbox" id="invalidCheck1" required>
                          <label class="form-check-label" for="invalidCheck1">Create</label>
                        </div>
                        <div class="form-check-inline">
                          <input v-model="userInfo.opAccess" value="R" class="form-check-input" type="checkbox" id="invalidCheck2" required>
                          <label class="form-check-label" for="invalidCheck2">Read</label>
                        </div>
                        <div class="form-check-inline">
                          <input v-model="userInfo.opAccess" value="U" class="form-check-input" type="checkbox" id="invalidCheck3" required>
                          <label class="form-check-label" for="invalidCheck3">Update</label>
                        </div>
                        <div class="form-check-inline">
                          <input v-model="userInfo.opAccess" value="D" class="form-check-input" type="checkbox" id="invalidCheck4" required>
                          <label class="form-check-label" for="invalidCheck4">Delete</label>
                        </div>
                      </div>
                      <div class="invalid-feedback">
                        Please give at least one permission!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="validationCustom06" class="form-label">Status</label>
                      <div id="validationCustom06" >
                        <div class="form-check form-check-inline">
                          <input v-model="userInfo.isActive"
                                 value="0"
                                 class="form-check-input"
                                 type="radio"
                                 name="inlineRadioOptions"
                                 id="inlineRadio1" required>
                          <label class="form-check-label" for="inlineRadio1">Active</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input v-model="userInfo.isActive" value="1" class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" required>
                          <label class="form-check-label" for="inlineRadio2">Inactive</label>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-outline-dark">Reset</button>
                  <button v-on:click="verifyInput('create')"
                          type="submit"
                          class="btn btn-primary"
                          :data-bs-dismiss="dataBsDismiss">
                    <span v-if="isNetworkOpStarted" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <span v-else>Save</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div v-show="response.code !== 200 && response.init === 1" class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>
              <span v-if="isNetworkOpStarted" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              <span v-else >ERROR!</span>
            </strong>
            &nbsp;
            <span v-if="isNetworkOpStarted" >Loading...</span>
            <span v-else >{{response.msg}}</span>
            <button v-on:click="onResetResponse" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
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
            <h1 class="h2">Users</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group me-2">
                <button v-on:click="onModalOpen"
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
              <th>Email</th>
              <th>Role</th>
              <th>Status</th>
              <th>Update</th>
              <th>Delete</th>
            </tr>
            </thead>
            <tbody v-for="(u,i) in userInfos.data" >
            <tr :key="i" >
              <td>{{i+1}}</td>
              <td>{{u.email}}</td>
              <td>{{u.role_name}}</td>
              <td>
                <span v-if="u.is_active == 0" >Inactive</span>
                <span v-else >Active</span>
              </td>
              <td><i class="fas fa-edit" v-on:click="setFormDate(u)" ></i></td>
              <td><i class="fas fa-trash" ></i></td>
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
                userInfos : [],
                userInfo : {
                    email: "",
                    password : "",
                    mobileNumber: "",
                    roleOid : 0,
                    opAccess : [],
                    isActive: 0
                },
                response : {
                    code : 0,
                    msg : "",
                    init : 0
                }
            }
        },
        methods: {
            setFormDate(u){
                console.log(u);
            },
            onResetResponse(init){
                this.response.code = 0;
                this.response.msg = "";
                this.response.init = init;
            },
            getInitialData(){
                this.onResetResponse(1);
                this.isNetworkOpStarted = true;
                this.$axios.$post('/user-infos/view-init',{
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
                        this.userInfos = res.userInfos;
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
                this.onResetResponse();
            },
            verifyInput(which){
                if (which === "create"){
                    this.wasValidated = "was-validated";
                    if(this.userInfo.roleOid !== 0
                        && this.userInfo.opAccess.length !== 0
                        && this.userInfo.email
                        && this.userInfo.mobileNumber
                        && this.userInfo.password
                    ){
                        this.onCreate();
                    }
                }
            },
            onCreate(){
                this.onResetResponse(0);
                this.isNetworkOpStarted = true;
                this.$axios.$post('/user-infos',{
                    newUserInfo : this.userInfo,
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
                        this.userInfos = res.userInfos;
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
