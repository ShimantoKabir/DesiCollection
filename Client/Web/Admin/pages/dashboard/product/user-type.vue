<template>
  <div class="my-template" >
    <AlertComponent
      ref="alert"
      :on-alert-close="onAlertClose"
      :on-left-btn-click="onLeftBtnClick"
      :on-right-btn-click="onRightBtnClick" />
    <AppHeader/>
    <div class="container-fluid">
      <div class="row">
        <AppSidebar/>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 my-main">
          <!--model-->
          <div class="modal fade"
               id="userTypeFormModel"
               tabindex="-1"
               aria-labelledby="userTypeModalLabel"
               aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="userTypeModalLabel">
                    <span>Entries</span>
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form :class="formClassNames.join(' ')" novalidate>
                    <div class="mb-3">
                      <label for="userTypeSelection" class="form-label">User Type</label>
                      <select v-model="userTypeViewModel.userTypeName"
                              class="form-select"
                              id="userTypeSelection"
                              required>
                        <option selected disabled value="">Choose...</option>
                        <option value="Male" >Male</option>
                        <option value="Female" >Female</option>
                        <option value="Child" >Child</option>
                      </select>
                      <div class="invalid-feedback">
                        Please select a user type!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button v-if="userTypeViewModel.id === 0"
                          type="submit"
                          class="btn btn-primary"
                          v-on:click="verifyInput(opState.CREATE)" >
                    Save
                  </button>
                  <button v-else
                          type="submit"
                          class="btn btn-warning"
                          v-on:click="verifyInput(opState.UPDATE)" >
                    Update
                  </button>
                  <button v-on:click="onReset" class="btn btn-outline-dark" >Reset</button>
                </div>
              </div>
            </div>
          </div>
          <!--header-->
          <div class="d-flex
            justify-content-between
            flex-wrap
            flex-md-nowrap
            align-items-center
            pt-3
            pb-2
            mb-3
            border-bottom">
            <h1 class="h2">Product User Type</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group me-2">
                <button
                  v-on:click="onModelOpen"
                  type="button"
                  class="btn btn-sm btn-outline-secondary"
                  data-bs-toggle="modal"
                  data-bs-target="#userTypeFormModel">
                  <i class="fas fa-plus" ></i>
                </button>
                <button
                  ref="updateUserTypeBtn"
                  type="button"
                  class="btn btn-sm btn-outline-secondary user-type-update-btn"
                  data-bs-toggle="modal"
                  data-bs-target="#userTypeFormModel">
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
              <th>User Type</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(f,i) in userTypeViewModel.userTypes" >
              <td>{{i+1}}</td>
              <td>{{f.userTypeName}}</td>
              <td><i class="fas fa-edit cp" v-on:click="setFormData(f)" ></i></td>
              <td><i class="fas fa-trash cp" v-on:click="setDeleteData(f)" ></i></td>
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
  name: "user-type",
  mounted() {
    this.getInitialData();
  },
  data(){
    return{
      userTypeViewModel: {
        id: 0,
        userTypeName : "",
        userTypes : []
      },
    }
  },
  methods: {
    getInitialData(){
      this.showLoader(this);
      this.$axios.$post('/user-types/index',{
        userInfo : this.getAuthInfo()
      }).then(res=>{
        if(res.code === this.networkState.SUCCESS){
          this.userTypeViewModel.userTypes = res.userTypes;
          this.showSuccess(this,res.msg);
        }else {
          this.showErrorMsg(this,this.opState.READ,res.msg);
        }
      }).catch(err=>{
        this.showError(this,this.opState.READ);
      });
    },
    verifyInput(which){
      this.formClassNames.push("was-validated");
      if(which === this.opState.CREATE || which === this.opState.UPDATE){
        if(this.userTypeViewModel.userTypeName){
          which === this.opState.CREATE ? this.onCreate() : this.onUpdate();
        }
      }
    },
    onReset(){
      this.userTypeViewModel.userTypeName = "";
      this.userTypeViewModel.id = 0;
    },
    onAlertClose(eventData){
      console.log("eventDate=",eventData);
    },
    onLeftBtnClick(eventData){
      console.log("eventDate=",eventData);
    },
    onRightBtnClick(eventData){
      if (eventData === this.opState.READ){
        this.getInitialData();
      }else if(eventData === this.opState.CREATE){
        this.onCreate();
      }else if (eventData === this.opState.DELETE){
        this.onDelete();
      }else if (eventData === this.opState.UPDATE){
        this.onUpdate();
      }
    },
    onCreate(){
      this.showLoader(this);
      this.$axios.$post('/user-types',{
        userInfo : this.getAuthInfo(),
        userTypeViewModel : this.userTypeViewModel
      }).then(res=>{
        if(res.code === this.networkState.SUCCESS){
          this.userTypeViewModel.userTypes.push({
            id : res.model.id,
            userTypeName: res.model.userTypeName
          })
          this.showSuccess(this,res.msg);
        }else {
          this.showErrorMsg(this,this.opState.CREATE,res.msg);
        }
      }).catch(err=>{
        this.showError(this,this.opState.CREATE);
      });
    },
    onUpdate(){
      this.showLoader(this);
      this.$axios.$put('/user-types',{
        userInfo : this.getAuthInfo(),
        userTypeViewModel : this.userTypeViewModel
      }).then(res=>{
        if(res.code === this.networkState.SUCCESS){

          let objIndex = this.userTypeViewModel.userTypes.findIndex((obj => obj.id === this.userTypeViewModel.id));
          this.userTypeViewModel.userTypes[objIndex].userTypeName = this.userTypeViewModel.userTypeName;

          this.showSuccess(this,res.msg);
        }else {
          this.showErrorMsg(this,this.opState.UPDATE,res.msg);
        }
      }).catch(err=>{
        this.showError(this,this.opState.UPDATE);
      });
    },
    setFormData(userType){
      this.userTypeViewModel.id = userType.id;
      this.userTypeViewModel.userTypeName = userType.userTypeName;
      this.$refs.updateUserTypeBtn.click();
    },
    setDeleteData(userType){
      this.userTypeViewModel.id = userType.id;
      this.delete(this, this.opState.DELETE)
    },
    onDelete(){
      let config = {
        data: {
          userInfo : {
            email : this.cookieUserInfo.email,
            href : window.location.pathname,
            sessionId : this.cookieUserInfo.sessionId
          },
          userTypeViewModel : {
            id : this.userTypeViewModel.id
          }
        }
      };
      this.$axios.$delete("/user-types",config).then(res=>{
        if(res.code === this.networkState.SUCCESS){
          this.userTypeViewModel.userTypes = this.userTypeViewModel.userTypes.filter((item) => item.id !== this.userTypeViewModel.id);
          this.showSuccess(this,res.msg);
        }else {
          this.showErrorMsg(this,this.opState.DELETE,res.msg);
        }
      }).catch(err=>{
        this.showError(this,this.opState.DELETE);
      });
    },
    onModelOpen(){
      this.onReset();
    }
  }
}
</script>

<style scoped>
  .user-type-update-btn{
    display: none;
  }
</style>
