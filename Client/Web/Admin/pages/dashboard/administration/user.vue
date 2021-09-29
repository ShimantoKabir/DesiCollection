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
                  <form :class="'user-creation-form '+wasValidated" >
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
                        <option value="1" >--select--</option>
                        <option value="2" >--select--</option>
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
                  <button type="button" class="btn btn-outline-dark">Reset</button>
                  <button v-on:click="verifyInput"
                          type="button"
                          class="btn btn-primary"
                          :data-bs-dismiss="dataBsDismiss">
                    Save
                  </button>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal -->
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
              <th>Is Active</th>
              <th >Edit</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>1,001</td>
              <td>random</td>
              <td>data</td>
              <td>placeholder</td>
              <td><i class="fas fa-edit" ></i></td>
            </tr>
            <tr>
              <td>1,002</td>
              <td>placeholder</td>
              <td>irrelevant</td>
              <td>visual</td>
              <td>layout</td>
            </tr>
            <tr>
              <td>1,003</td>
              <td>data</td>
              <td>rich</td>
              <td>dashboard</td>
              <td>tabular</td>
            </tr>
            <tr>
              <td>1,003</td>
              <td>information</td>
              <td>placeholder</td>
              <td>illustrative</td>
              <td>data</td>
            </tr>
            <tr>
              <td>1,004</td>
              <td>text</td>
              <td>random</td>
              <td>layout</td>
              <td>dashboard</td>
            </tr>
            <tr>
              <td>1,005</td>
              <td>dashboard</td>
              <td>irrelevant</td>
              <td>text</td>
              <td>placeholder</td>
            </tr>
            <tr>
              <td>1,006</td>
              <td>dashboard</td>
              <td>illustrative</td>
              <td>rich</td>
              <td>data</td>
            </tr>
            <tr>
              <td>1,007</td>
              <td>placeholder</td>
              <td>tabular</td>
              <td>information</td>
              <td>irrelevant</td>
            </tr>
            <tr>
              <td>1,008</td>
              <td>random</td>
              <td>data</td>
              <td>placeholder</td>
              <td>text</td>
            </tr>
            <tr>
              <td>1,009</td>
              <td>placeholder</td>
              <td>irrelevant</td>
              <td>visual</td>
              <td>layout</td>
            </tr>
            <tr>
              <td>1,010</td>
              <td>data</td>
              <td>rich</td>
              <td>dashboard</td>
              <td>tabular</td>
            </tr>
            <tr>
              <td>1,011</td>
              <td>information</td>
              <td>placeholder</td>
              <td>illustrative</td>
              <td>data</td>
            </tr>
            <tr>
              <td>1,012</td>
              <td>text</td>
              <td>placeholder</td>
              <td>layout</td>
              <td>dashboard</td>
            </tr>
            <tr>
              <td>1,013</td>
              <td>dashboard</td>
              <td>irrelevant</td>
              <td>text</td>
              <td>visual</td>
            </tr>
            <tr>
              <td>1,014</td>
              <td>dashboard</td>
              <td>illustrative</td>
              <td>rich</td>
              <td>data</td>
            </tr>
            <tr>
              <td>1,015</td>
              <td>random</td>
              <td>tabular</td>
              <td>information</td>
              <td>text</td>
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
                cookieUserInfo : "",
                modalState : "close",
                dataBsDismiss : "",
                wasValidated : "",
                userInfo : {
                    email: "",
                    password : "",
                    mobileNumber: "",
                    roleOid : 0,
                    opAccess : [],
                    isActive: 0
                },
                response : {
                    hasError : false,
                    errorMsg : ""
                }
            }
        },
        methods: {
            getInitialData(){

                this.$axios.$post('/user-infos/view-init',{
                    userInfo : {
                        email : this.cookieUserInfo.email,
                        sessionId: this.cookieUserInfo.sessionId,
                        path : window.location.pathname
                    }
                }).then(res=>{
                    console.log(res);
                    if(res.code !== 200){
                        this.response.hasError = true;
                        this.response.errorMsg = res.msg;
                    }else {
                        this.response.hasError = false;
                        this.response.errorMsg = "";


                    }
                }).catch(err=>{
                    this.response.hasError = true;
                    this.response.errorMsg = "Something went wrong, please try again!";
                }).finally(end=>{
                    this.isNetworkOpStarted = false;
                });
            },
            onModalClose(){

            },
            onModalOpen(){

            },
            verifyInput(){
                this.wasValidated = "was-validated";

            }
        }
    }
</script>

<style scoped>

</style>
