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
               id="supplierFormModel"
               tabindex="-1"
               aria-labelledby="supplierModalLabel"
               aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="supplierModalLabel">
                    <span>Entries</span>
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form :class="formClassNames.join(' ')" novalidate>
                    <div class="mb-3">
                      <label for="supplierNameInput" class="form-label">Supplier Name</label>
                      <input v-model="supplierViewModel.supplierName" type="text" class="form-control" id="supplierNameInput" required>
                      <div class="invalid-feedback">
                        Please give supplier name!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="cityInput" class="form-label">City</label>
                      <input v-model="supplierViewModel.addressViewModel.city"
                             type="text"
                             class="form-control"
                             id="cityInput" required>
                      <div class="invalid-feedback">
                        Please give city name!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="emailInput" class="form-label">Email</label>
                      <input v-model="supplierViewModel.addressViewModel.email"
                             type="text"
                             class="form-control"
                             id="emailInput" required>
                      <div class="invalid-feedback">
                        Please give email!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="countryInput" class="form-label">Country</label>
                      <input v-model="supplierViewModel.addressViewModel.country"
                             type="text"
                             class="form-control"
                             id="countryInput" required>
                      <div class="invalid-feedback">
                        Please give country!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="zipCodeInput" class="form-label">Zip Code</label>
                      <input v-model="supplierViewModel.addressViewModel.zipCode"
                             type="text"
                             class="form-control"
                             id="zipCodeInput" required>
                      <div class="invalid-feedback">
                        Please give zipcode!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="firstMobileNoCodeInput" class="form-label">First mobile number</label>
                      <input v-model="supplierViewModel.addressViewModel.firstMobileNo"
                             type="text"
                             class="form-control"
                             id="firstMobileNoCodeInput" required>
                      <div class="invalid-feedback">
                        Please give first mobile number!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="secondMobileNoCodeInput" class="form-label">Second mobile number</label>
                      <input v-model="supplierViewModel.addressViewModel.secondMobileNo"
                             type="text"
                             class="form-control"
                             id="secondMobileNoCodeInput" required>
                      <div class="invalid-feedback">
                        Please give second mobile number!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="detailInput" class="form-label">Detail</label>
                      <textarea
                        class="form-control"
                        id="detailInput"
                        v-model="supplierViewModel.addressViewModel.detail">
                      </textarea>
                      <div class="invalid-feedback">
                        Please give second mobile number!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button v-if="supplierViewModel.id === 0"
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
            <h1 class="h2">Supplier</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group me-2">
                <button
                  v-on:click="onModelOpen"
                  type="button"
                  class="btn btn-sm btn-outline-secondary"
                  data-bs-toggle="modal"
                  data-bs-target="#supplierFormModel">
                  <i class="fas fa-plus" ></i>
                </button>
                <button
                  ref="updateSupplierBtn"
                  type="button"
                  class="btn btn-sm btn-outline-secondary supplier-update-btn"
                  data-bs-toggle="modal"
                  data-bs-target="#supplierFormModel">
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
              <th>Supplier Name</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(s,i) in supplierViewModel.suppliers" >
              <td>{{i+1}}</td>
              <td>
                {{s.supplierName}}
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
  name: "manage",
  mounted() {
    this.getInitialData();
  },
  data(){
    return{
      supplierViewModel: {
        id: 0,
        supplierName: "",
        addressViewModel : {
          id : 0,
          city : "",
          email : "",
          detail : "",
          country : "",
          zipCode : "",
          firstMobileNo : "",
          secondMobileNo : ""
        },
        suppliers : []
      },
    }
  },
  methods: {
    getInitialData(){
      this.showLoader(this);
      this.$axios.$post('/suppliers/index',{
        userInfo : this.getAuthInfo()
      }).then(res=>{
        if(res.code === this.networkState.SUCCESS){
          this.supplierViewModel.suppliers = res.suppliers;
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
        if(this.supplierViewModel.supplierName){
          which === this.opState.CREATE ? this.onCreate() : this.onUpdate();
        }
      }
    },
    onReset(){
      this.supplierViewModel.id = 0;
      this.supplierViewModel.supplierName = "";
      this.supplierViewModel.addressViewModel.id = 0;
      this.supplierViewModel.addressViewModel.city = "";
      this.supplierViewModel.addressViewModel.email = "";
      this.supplierViewModel.addressViewModel.detail = "";
      this.supplierViewModel.addressViewModel.country = "";
      this.supplierViewModel.addressViewModel.zipCode = "";
      this.supplierViewModel.addressViewModel.firstMobileNo = "";
      this.supplierViewModel.addressViewModel.secondMobileNo = "";
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
      this.$axios.$post('/suppliers',{
        userInfo : this.getAuthInfo(),
        supplierViewModel : this.supplierViewModel
      }).then(res=>{
        if(res.code === this.networkState.SUCCESS){
          this.showSuccess(this,res.msg);
        }else {
          this.showErrorMsg(this,this.opState.CREATE, res.msg);
        }
      }).catch(err=>{
        this.showError(this,this.opState.CREATE);
      });
    },
    onUpdate(){
      this.showLoader(this);
      this.$axios.$put('/suppliers',{
        userInfo : this.getAuthInfo(),
        ageViewModel : this.ageViewModel
      }).then(res=>{
        if(res.code === this.networkState.SUCCESS){

          let objIndex = this.supplierViewModel.suppliers.findIndex((obj => obj.id === this.supplierViewModel.id));

          this.showSuccess(this,res.msg);
        }else {
          this.showError(this,this.opState.UPDATE);
        }
      }).catch(err=>{
        this.showError(this,this.opState.UPDATE);
      });
    },
    setFormData(supplier){
      this.supplierViewModel.id = supplier.id;
      this.$refs.updateSupplierBtn.click();
    },
    setDeleteData(supplier){
      this.supplierViewModel.id = supplier.id;
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
          supplierViewModel : {
            id : this.supplierViewModel.id,
          }
        }
      };
      this.$axios.$delete("/suppliers",config).then(res=>{
        if(res.code === this.networkState.SUCCESS){
          this.ageViewModel.ages = this.ageViewModel.ages.filter((item) => item.id !== this.ageViewModel.id);
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

</style>
