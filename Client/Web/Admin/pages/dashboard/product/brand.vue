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
               id="brandFormModel"
               tabindex="-1"
               aria-labelledby="brandModalLabel"
               aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="brandModalLabel">
                    <span>Entries</span>
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form :class="formClassNames.join(' ')" novalidate>
                    <div class="mb-3">
                      <label for="colorInput" class="form-label">Brand</label>
                      <input v-model="brandViewModel.brandName" type="text" class="form-control" id="colorInput" required>
                      <div class="invalid-feedback">
                        Please give brand name!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="fileInput" class="form-label">Brand Image</label>
                      <input type="file"
                             class="form-control"
                             id="fileInput"
                             @change="onBrandImageUpload"
                             ref="brandImage" >
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div v-show="brandViewModel.id !== 0" class="mb-3">
                      <span v-if="brandViewModel.imageName === null" >N/A</span>
                      <img v-else class="update-brand-logo rounded" :src="brandViewModel.imagePath" alt="logo">
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button v-if="brandViewModel.id === 0"
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
            <h1 class="h2">Brand</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group me-2">
                <button
                  v-on:click="onModelOpen"
                  type="button"
                  class="btn btn-sm btn-outline-secondary"
                  data-bs-toggle="modal"
                  data-bs-target="#brandFormModel">
                  <i class="fas fa-plus" ></i>
                </button>
                <button
                  ref="updateBrandBtn"
                  type="button"
                  class="btn btn-sm btn-outline-secondary brand-update-btn"
                  data-bs-toggle="modal"
                  data-bs-target="#brandFormModel">
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
              <th>Name</th>
              <th>Logo</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(f,i) in brandViewModel.brands" >
              <td>{{i+1}}</td>
              <td>{{f.brandName}}</td>
              <td>
                <span v-if="f.imageName === null" >N/A</span>
                <img v-else class="brand-logo rounded" :src="f.imagePath" alt="logo">
              </td>
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
  name: "brand",
  mounted() {
    this.getInitialData();
  },
  data(){
    return{
      brandViewModel: {
        id: 0,
        brandName : "",
        imageName : "",
        imagePath : "",
        brands : []
      },
    }
  },
  methods: {
    getInitialData(){
      this.showLoader(this);
      this.$axios.$post('/brands/index',{
        userInfoViewModel : this.getAuthInfo()
      }).then(res=>{
        if(res.code === this.networkState.SUCCESS){
          this.brandViewModel.brands = res.brands;
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
        if(this.brandViewModel.brandName){
          which === this.opState.CREATE ? this.onCreate() : this.onUpdate();
        }
      }
    },
    onReset(){
      this.brandViewModel.brandName = "";
      this.brandViewModel.id = 0;
      this.brandViewModel.brandImage = null;
      this.$refs.brandImage.value = null;
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

      const formData = new FormData();
      formData.append('brandImage', this.brandViewModel.brandImage);
      formData.append("brandViewModel",JSON.stringify(this.brandViewModel));
      formData.append("userInfoViewModel",JSON.stringify(this.getAuthInfo()))
      const headers = { 'Content-Type': 'multipart/form-data' };

      this.showLoader(this);
      this.$axios.$post('/brands',formData,{ headers }).then(res=>{
        if(res.code === this.networkState.SUCCESS){
          this.brandViewModel.brands.push({
            id : res.model.id,
            brandName: res.model.brandName,
            imageName: res.model.imageName,
            imagePath: res.model.imagePath
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

      const formData = new FormData();
      formData.append('brandImage', this.brandViewModel.brandImage);
      formData.append("brandViewModel",JSON.stringify(this.brandViewModel));
      formData.append("userInfoViewModel",JSON.stringify(this.getAuthInfo()))
      formData.append('_method', 'PUT');
      const headers = { 'Content-Type': 'multipart/form-data' };

      this.showLoader(this);
      this.$axios.$post('/brands',formData,{ headers }).then(res=>{
        if(res.code === this.networkState.SUCCESS){

          let objIndex = this.brandViewModel.brands.findIndex((obj => obj.id === this.brandViewModel.id));
          this.brandViewModel.brands[objIndex].brandName = this.brandViewModel.brandName;
          this.brandViewModel.brands[objIndex].imageName = res.model.imageName;
          this.brandViewModel.brands[objIndex].imagePath = res.model.imagePath;

          this.brandViewModel.imagePath = res.model.imagePath;
          this.brandViewModel.imageName = res.model.imageName;

          this.showSuccess(this,res.msg);
        }else {
          this.showErrorMsg(this,this.opState.UPDATE,res.msg);
        }
      }).catch(err=>{
        this.showError(this,this.opState.UPDATE);
      });
    },
    setFormData(brand){
      this.brandViewModel.id = brand.id;
      this.brandViewModel.brandName = brand.brandName;
      this.brandViewModel.imagePath = brand.imagePath;
      this.brandViewModel.imageName = brand.imageName;
      this.$refs.updateBrandBtn.click();
    },
    setDeleteData(brand){
      this.brandViewModel.id = brand.id;
      this.brandViewModel.imageName = brand.imageName;
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
          brandViewModel : {
            id : this.brandViewModel.id,
            imageName : this.brandViewModel.imageName
          }
        }
      };
      this.$axios.$delete("/brands",config).then(res=>{
        if(res.code === this.networkState.SUCCESS){
          this.brandViewModel.brands = this.brandViewModel.brands.filter((item) => item.id !== this.brandViewModel.id);
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
    },
    onBrandImageUpload() {
      this.brandViewModel.brandImage = this.$refs.brandImage.files[0];
    }
  }
}
</script>

<style scoped>
  .brand-update-btn{
    display: none;
  }
  .brand-logo{
    height: 30px;
    width: 50px;
  }
  .update-brand-logo{
    width: 100%;
  }
</style>
