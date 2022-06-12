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
               id="typeFormModel"
               tabindex="-1"
               aria-labelledby="typeModalLabel"
               aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="typeModalLabel">
                    <span>Entries</span>
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form :class="formClassNames.join(' ')" novalidate>
                    <div class="mb-3">
                      <label for="colorInput" class="form-label">Product Type</label>
                      <input v-model="typeViewModel.typeName" type="text" class="form-control" id="colorInput" required>
                      <div class="invalid-feedback">
                        Please give type name!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button v-if="typeViewModel.id === 0"
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
            <h1 class="h2">Product Type</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group me-2">
                <button
                  v-on:click="onModelOpen"
                  type="button"
                  class="btn btn-sm btn-outline-secondary"
                  data-bs-toggle="modal"
                  data-bs-target="#typeFormModel">
                  <i class="fas fa-plus" ></i>
                </button>
                <button
                  ref="updateTypeBtn"
                  type="button"
                  class="btn btn-sm btn-outline-secondary type-update-btn"
                  data-bs-toggle="modal"
                  data-bs-target="#typeFormModel">
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
              <th>Type Name</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(f,i) in typeViewModel.types" >
              <td>{{i+1}}</td>
              <td>{{f.typeName}}</td>
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
  name: "type",
  mounted() {
    this.getInitialData();
  },
  data(){
    return{
      typeViewModel: {
        id: 0,
        typeName : "",
        types : []
      },
    }
  },
  methods: {
    getInitialData(){
      this.showLoader(this);
      this.$axios.$post('/types/index',{
        userInfoViewModel : this.getAuthInfo()
      }).then(res=>{
        if(res.code === this.networkState.SUCCESS){
          this.typeViewModel.types = res.types;
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
        if(this.typeViewModel.typeName){
          which === this.opState.CREATE ? this.onCreate() : this.onUpdate();
        }
      }
    },
    onReset(){
      this.typeViewModel.typeName = "";
      this.typeViewModel.id = 0;
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
      this.$axios.$post('/types',{
        userInfoViewModel : this.getAuthInfo(),
        typeViewModel : this.typeViewModel
      }).then(res=>{
        if(res.code === this.networkState.SUCCESS){
          this.typeViewModel.types.push({
            id : res.model.id,
            typeName: res.model.typeName
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
      this.$axios.$put('/types',{
        userInfoViewModel : this.getAuthInfo(),
        typeViewModel : this.typeViewModel
      }).then(res=>{
        if(res.code === this.networkState.SUCCESS){

          let objIndex = this.typeViewModel.types.findIndex((obj => obj.id === this.typeViewModel.id));
          this.typeViewModel.types[objIndex].typeName = this.typeViewModel.typeName;

          this.showSuccess(this,res.msg);
        }else {
          this.showErrorMsg(this,this.opState.UPDATE,res.msg);
        }
      }).catch(err=>{
        this.showError(this,this.opState.UPDATE);
      });
    },
    setFormData(type){
      this.typeViewModel.id = type.id;
      this.typeViewModel.typeName = type.typeName;
      this.$refs.updateTypeBtn.click();
    },
    setDeleteData(type){
      this.typeViewModel.id = type.id;
      this.delete(this, this.opState.DELETE)
    },
    onDelete(){
      let config = {
        data: {
          userInfoViewModel : {
            email : this.cookieUserInfo.email,
            href : window.location.pathname,
            sessionId : this.cookieUserInfo.sessionId
          },
          typeViewModel : {
            id : this.typeViewModel.id
          }
        }
      };
      this.$axios.$delete("/types",config).then(res=>{
        if(res.code === this.networkState.SUCCESS){
          this.typeViewModel.types = this.typeViewModel.types.filter((item) => item.id !== this.typeViewModel.id);
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
  .type-update-btn{
    display: none;
  }
</style>
