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
               id="supplierBillFormModel"
               tabindex="-1"
               aria-labelledby="supplierBillModalLabel"
               aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="supplierBillModalLabel">
                    <span>Entries</span>
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form :class="formClassNames.join(' ')" novalidate>
                    <div class="mb-3">
                      <label for="supplierSelectInput" class="form-label">Supplier Name</label>
                      <select id="supplierSelectInput"
                              v-model="supplierBillViewModel.supplierId"
                              class="form-select" >
                        <option v-bind:value="0">--select--</option>
                        <option v-bind:value="s.id" v-for="s in supplierBillViewModel.suppliers" >
                          {{s.supplierName}}
                        </option>
                      </select>
                      <div class="invalid-feedback">
                        Please select supplier!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="billNumberInput" class="form-label">Bill Number</label>
                      <input v-model="supplierBillViewModel.billNumber"
                             type="text"
                             class="form-control"
                             id="billNumberInput" required>
                      <div class="invalid-feedback">
                        Please give bill number!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="billingDateInput" class="form-label">Billing Date</label>
                      <input v-model="supplierBillViewModel.billingDate"
                             type="date"
                             class="form-control"
                             id="billingDateInput" required>
                      <div class="invalid-feedback">
                        Please give billing date!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="totalQuantityInput" class="form-label">Total Quantity</label>
                      <input v-model="supplierBillViewModel.totalQuantity"
                             type="number"
                             class="form-control"
                             id="totalQuantityInput" required>
                      <div class="invalid-feedback">
                        Please give total quantity!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="debitAmountInput" class="form-label">Total Price</label>
                      <input v-model="supplierBillViewModel.debitAmount"
                             type="number"
                             class="form-control"
                             id="debitAmountInput" required>
                      <div class="invalid-feedback">
                        Please give total price!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="fileInput" class="form-label">Supplier Bill Image</label>
                      <input type="file"
                             class="form-control"
                             id="fileInput"
                             @change="onBillImageUpload"
                             ref="billImage" >
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div v-show="supplierBillViewModel.id !== 0" class="mb-3">
                      <span v-if="supplierBillViewModel.imageName === null" >N/A</span>
                      <img v-else class="update-supplier-bill-logo rounded" :src="supplierBillViewModel.imagePath" alt="logo">
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button v-if="supplierBillViewModel.id === 0"
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
            <h1 class="h2">Supplier Bill</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group me-2">
                <button
                  v-on:click="onModelOpen"
                  type="button"
                  class="btn btn-sm btn-outline-secondary"
                  data-bs-toggle="modal"
                  data-bs-target="#supplierBillFormModel">
                  <i class="fas fa-plus" ></i>
                </button>
                <button
                  ref="updateSupplierBillBtn"
                  type="button"
                  class="btn btn-sm btn-outline-secondary supplier-bill-update-btn"
                  data-bs-toggle="modal"
                  data-bs-target="#supplierBillFormModel">
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
              <th>Bill Number</th>
              <th>Billing Date</th>
              <th>Total Quantity</th>
              <th>Total Price</th>
              <th>Bill Image</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(f,i) in supplierBillViewModel.supplierBills" >
              <td>{{i+1}}</td>
              <td>{{f.supplierName}}</td>
              <td>{{f.billNumber}}</td>
              <td>{{f.billingDate}}</td>
              <td>{{f.totalQuantity}}</td>
              <td>{{f.debitAmount}}</td>
              <td>
                <span v-if="f.imageName === null" >N/A</span>
                <img v-else class="supplier-bill-logo rounded" :src="f.imagePath" alt="logo">
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
  name: "bill",
  mounted() {
    this.getInitialData();
  },
  data(){
    return{
      supplierBillViewModel: {
        id: 0,
        supplierId : 0,
        billNumber : "",
        billingDate : "",
        debitAmount : 0,
        totalQuantity : 0,
        imageName : "",
        imagePath : "",
        billImage : null,
        supplierBills : [],
        suppliers : []
      },
    }
  },
  methods: {
    getInitialData(){
      this.showLoader(this);
      this.$axios.$post('/supplier-bills/index',{
        userInfoViewModel : this.getAuthInfo()
      }).then(res=>{
        if(res.code === this.networkState.SUCCESS){
          this.supplierBillViewModel.supplierBills = res.supplierBills;
          this.supplierBillViewModel.suppliers = res.suppliers;
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
        which === this.opState.CREATE ? this.onCreate() : this.onUpdate();
      }
    },
    onReset(){
      this.supplierBillViewModel.id = 0;
      this.supplierBillViewModel.supplierId = 0;
      this.supplierBillViewModel.billNumber = "";
      this.supplierBillViewModel.billingDate = "";
      this.supplierBillViewModel.debitAmount = 0;
      this.supplierBillViewModel.totalQuantity = 0;
      this.supplierBillViewModel.billImage = null;
      this.supplierBillViewModel.imagePath = "";
      this.supplierBillViewModel.imageName = "";
      this.$refs.billImage.value = null;
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
      formData.append('billImage', this.supplierBillViewModel.billImage);
      formData.append("supplierBillViewModel",JSON.stringify(this.supplierBillViewModel));
      formData.append("userInfoViewModel",JSON.stringify(this.getAuthInfo()))
      const headers = { 'Content-Type': 'multipart/form-data' };

      this.showLoader(this);
      this.$axios.$post('/supplier-bills',formData,{ headers }).then(res=>{
        if(res.code === this.networkState.SUCCESS){

          let supplier = this.supplierBillViewModel.suppliers
            .find((obj => obj.id === this.supplierBillViewModel.supplierId));

          this.supplierBillViewModel.supplierBills.push({
            id : res.model.id,
            supplierId: res.model.supplierId,
            billNumber: res.model.billNumber,
            billingDate: res.model.billingDate,
            totalQuantity: res.model.totalQuantity,
            debitAmount: res.model.debitAmount,
            supplierName: supplier.supplierName,
            imagePath: res.model.imagePath
          });

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
      formData.append('billImage', this.supplierBillViewModel.billImage);
      formData.append("supplierBillViewModel",JSON.stringify(this.supplierBillViewModel));
      formData.append("userInfoViewModel",JSON.stringify(this.getAuthInfo()))
      formData.append('_method', 'PUT');
      const headers = { 'Content-Type': 'multipart/form-data' };

      this.showLoader(this);
      this.$axios.$post('/supplier-bills',formData,{ headers }).then(res=>{
        if(res.code === this.networkState.SUCCESS){

          let objIndex = this.supplierBillViewModel.supplierBills
            .findIndex((obj => obj.id === this.supplierBillViewModel.id));
          let supplier = this.supplierBillViewModel.suppliers
            .find((obj => obj.id === this.supplierBillViewModel.supplierId));

          this.supplierBillViewModel.supplierBills[objIndex].supplierId = this.supplierBillViewModel.supplierId;
          this.supplierBillViewModel.supplierBills[objIndex].billNumber = this.supplierBillViewModel.billNumber;
          this.supplierBillViewModel.supplierBills[objIndex].billingDate = this.supplierBillViewModel.billingDate;
          this.supplierBillViewModel.supplierBills[objIndex].debitAmount = this.supplierBillViewModel.debitAmount;
          this.supplierBillViewModel.supplierBills[objIndex].totalQuantity = this.supplierBillViewModel.totalQuantity;
          this.supplierBillViewModel.supplierBills[objIndex].supplierName = supplier.supplierName;

          this.supplierBillViewModel.supplierBills[objIndex].imageName = res.model.imageName;
          this.supplierBillViewModel.supplierBills[objIndex].imagePath = res.model.imagePath;

          this.supplierBillViewModel.imagePath = res.model.imagePath;
          this.supplierBillViewModel.imageName = res.model.imageName;

          this.showSuccess(this,res.msg);
        }else {
          this.showErrorMsg(this,this.opState.UPDATE,res.msg);
        }
      }).catch(err=>{
        this.showError(this,this.opState.UPDATE);
      });
    },
    setFormData(supplierBill){
      this.supplierBillViewModel.id = supplierBill.id;
      this.supplierBillViewModel.supplierId = supplierBill.supplierId;
      this.supplierBillViewModel.billNumber = supplierBill.billNumber;
      this.supplierBillViewModel.billingDate = supplierBill.billingDate;
      this.supplierBillViewModel.debitAmount = supplierBill.debitAmount;
      this.supplierBillViewModel.totalQuantity = supplierBill.totalQuantity;
      this.supplierBillViewModel.imagePath = supplierBill.imagePath;
      this.supplierBillViewModel.imageName = supplierBill.imageName;
      this.$refs.updateSupplierBillBtn.click();
    },
    setDeleteData(supplierBill){
      this.supplierBillViewModel.id = supplierBill.id;
      this.supplierBillViewModel.imageName = supplierBill.imageName;
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
          supplierBillViewModel : {
            id : this.supplierBillViewModel.id,
            imageName : this.supplierBillViewModel.imageName
          }
        }
      };
      this.$axios.$delete("/supplier-bills",config).then(res=>{
        if(res.code === this.networkState.SUCCESS){
          this.supplierBillViewModel.supplierBills = this.supplierBillViewModel.supplierBills
            .filter((item) => item.id !== this.supplierBillViewModel.id);
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
    onBillImageUpload() {
      this.supplierBillViewModel.billImage = this.$refs.billImage.files[0];
    }
  }
}
</script>

<style scoped>
  .supplier-bill-update-btn{
    display: none;
  }
  .supplier-bill-logo{
    height: 30px;
    width: 50px;
  }
  .update-supplier-bill-logo{
    width: 100%;
  }
</style>
