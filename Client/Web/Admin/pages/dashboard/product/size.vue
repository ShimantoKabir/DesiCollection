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
               id="sizeFormModel"
               tabindex="-1"
               aria-labelledby="sizeModalLabel"
               aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="sizeModalLabel">
                    <span>Entries</span>
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form :class="formClassNames.join(' ')" novalidate>
                    <div class="mb-3">
                      <label for="colorInput" class="form-label">Size</label>
                      <input v-model="sizeViewModel.sizeName" type="text" class="form-control" id="colorInput" required>
                      <div class="invalid-feedback">
                        Please give size name!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button v-if="sizeViewModel.id === 0"
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
            <h1 class="h2">Size</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group me-2">
                <button
                  v-on:click="onModelOpen"
                  type="button"
                  class="btn btn-sm btn-outline-secondary"
                  data-bs-toggle="modal"
                  data-bs-target="#sizeFormModel">
                  <i class="fas fa-plus" ></i>
                </button>
                <button
                  ref="updateSizeBtn"
                  type="button"
                  class="btn btn-sm btn-outline-secondary size-update-btn"
                  data-bs-toggle="modal"
                  data-bs-target="#sizeFormModel">
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
              <th>Size Name</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(f,i) in sizeViewModel.sizes" >
              <td>{{i+1}}</td>
              <td>{{f.sizeName}}</td>
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
  name: "size",
  mounted() {
    this.getInitialData();
  },
  data(){
    return{
      sizeViewModel: {
        id: 0,
        sizeName : "",
        sizes : []
      },
    }
  },
  methods: {
    getInitialData(){
      this.showLoader(this);
      this.$axios.$post('/sizes/index',{
        userInfo : this.getAuthInfo()
      }).then(res=>{
        if(res.code === this.networkState.SUCCESS){
          this.sizeViewModel.sizes = res.sizes;
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
        if(this.sizeViewModel.sizeName){
          which === this.opState.CREATE ? this.onCreate() : this.onUpdate();
        }
      }
    },
    onReset(){
      this.sizeViewModel.sizeName = "";
      this.sizeViewModel.id = 0;
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
      this.$axios.$post('/sizes',{
        userInfo : this.getAuthInfo(),
        sizeViewModel : this.sizeViewModel
      }).then(res=>{
        if(res.code === this.networkState.SUCCESS){
          this.sizeViewModel.sizes.push({
            id : res.model.id,
            sizeName: res.model.sizeName
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
      this.$axios.$put('/sizes',{
        userInfo : this.getAuthInfo(),
        sizeViewModel : this.sizeViewModel
      }).then(res=>{
        if(res.code === this.networkState.SUCCESS){

          let objIndex = this.sizeViewModel.sizes.findIndex((obj => obj.id === this.sizeViewModel.id));
          this.sizeViewModel.sizes[objIndex].sizeName = this.sizeViewModel.sizeName;

          this.showSuccess(this,res.msg);
        }else {
          this.showError(this,this.opState.UPDATE);
        }
      }).catch(err=>{
        this.showError(this,this.opState.UPDATE);
      });
    },
    setFormData(size){
      this.sizeViewModel.id = size.id;
      this.sizeViewModel.sizeName = size.sizeName;
      this.$refs.updateSizeBtn.click();
    },
    setDeleteData(size){
      this.sizeViewModel.id = size.id;
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
          sizeViewModel : {
            id : this.sizeViewModel.id
          }
        }
      };
      this.$axios.$delete("/sizes",config).then(res=>{
        if(res.code === this.networkState.SUCCESS){
          this.sizeViewModel.sizes = this.sizeViewModel.sizes.filter((item) => item.id !== this.sizeViewModel.id);
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
  .size-update-btn{
    display: none;
  }
</style>
