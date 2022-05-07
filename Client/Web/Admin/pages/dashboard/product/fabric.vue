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
               id="fabricFormModel"
               tabindex="-1"
               aria-labelledby="fabricModalLabel"
               aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="fabricModalLabel">
                    <span>Entries</span>
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form :class="formClassNames.join(' ')" novalidate>
                    <div class="mb-3">
                      <label for="colorInput" class="form-label">Fabric</label>
                      <input v-model="fabricViewModel.fabricName" type="text" class="form-control" id="colorInput" required>
                      <div class="invalid-feedback">
                        Please give fabric name!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button v-if="fabricViewModel.id === 0"
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
            <h1 class="h2">Fabric</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group me-2">
                <button
                    v-on:click="onModelOpen"
                    type="button"
                    class="btn btn-sm btn-outline-secondary"
                    data-bs-toggle="modal"
                    data-bs-target="#fabricFormModel">
                  <i class="fas fa-plus" ></i>
                </button>
                <button
                  ref="updateFabricBtn"
                  type="button"
                  class="btn btn-sm btn-outline-secondary fabric-update-btn"
                  data-bs-toggle="modal"
                  data-bs-target="#fabricFormModel">
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
              <th>Fabric Name</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(f,i) in fabricViewModel.fabrics" >
              <td>{{i+1}}</td>
              <td>{{f.fabricName}}</td>
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
import NetworkState from "~/enums/NetworkState";

export default {
  name: "fabric",
  mounted() {
    this.getInitialData();
  },
  data(){
    return{
      fabricViewModel: {
        id: 0,
        fabricName : "",
        fabrics : []
      },
    }
  },
  methods: {
    getInitialData(){
      this.showLoader(this);
      this.$axios.$post('/fabrics/index',{
        userInfo : this.getAuthInfo()
      }).then(res=>{
        if(res.code === this.networkState.SUCCESS){
          this.fabricViewModel.fabrics = res.fabrics;
          this.showSuccess(this,res.msg);
        }else {
          this.showError(this,this.opState.READ);
        }
      }).catch(err=>{
        this.showError(this,this.opState.READ);
      });
    },
    verifyInput(which){
      this.formClassNames.push("was-validated");
      if(which === this.opState.CREATE || which === this.opState.UPDATE){
        if(this.fabricViewModel.fabricName){
          which === this.opState.CREATE ? this.onCreate() : this.onUpdate();
        }
      }
    },
    onReset(){
      this.fabricViewModel.fabricName = "";
      this.fabricViewModel.id = 0;
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
      this.$axios.$post('/fabrics',{
        userInfo : this.getAuthInfo(),
        fabricViewModel : this.fabricViewModel
      }).then(res=>{
        if(res.code === this.networkState.SUCCESS){
          this.fabricViewModel.fabrics.push({
            id : res.id,
            fabricName: res.fabricName
          })
          this.showSuccess(this,res.msg);
        }else {
          this.showError(this,this.opState.CREATE);
        }
      }).catch(err=>{
        this.showError(this,this.opState.CREATE);
      });
    },
    onUpdate(){
      this.showLoader(this);
      this.$axios.$put('/fabrics',{
        userInfo : this.getAuthInfo(),
        fabricViewModel : this.fabricViewModel
      }).then(res=>{
        if(res.code === this.networkState.SUCCESS){

          let objIndex = this.fabricViewModel.fabrics.findIndex((obj => obj.id === this.fabricViewModel.id));
          this.fabricViewModel.fabrics[objIndex].fabricName = this.fabricViewModel.fabricName;

          this.showSuccess(this,res.msg);
        }else {
          this.showError(this,this.opState.UPDATE);
        }
      }).catch(err=>{
        this.showError(this,this.opState.UPDATE);
      });
    },
    setFormData(fabric){
      this.fabricViewModel.id = fabric.id;
      this.fabricViewModel.fabricName = fabric.fabricName;
      this.$refs.updateFabricBtn.click();
    },
    setDeleteData(fabric){
      this.fabricViewModel.id = fabric.id;
      this.ask(this, this.opState.DELETE)
    },
    onDelete(){
      let config = {
        data: {
          userInfo : {
            email : this.cookieUserInfo.email,
            href : window.location.pathname,
            sessionId : this.cookieUserInfo.sessionId
          },
          fabricViewModel : {
            id : this.fabricViewModel.id
          }
        }
      };
      this.$axios.$delete("/fabrics",config).then(res=>{
        if(res.code === this.networkState.SUCCESS){
          this.fabricViewModel.fabrics = this.fabricViewModel.fabrics.filter((item) => item.id !== this.fabricViewModel.id);
          this.showSuccess(this,res.msg);
        }else {
          this.showError(this,this.opState.DELETE);
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
  .fabric-update-btn{
    display: none;
  }
</style>
