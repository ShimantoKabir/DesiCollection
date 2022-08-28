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
               id="exampleModal"
               tabindex="-1"
               aria-labelledby="exampleModalLabel"
               aria-hidden="true">
            <div class="modal-dialog my-model-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">
                    <span>Entries</span>
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <table class="table table-bordered" >
                    <thead>
                    <tr>
                      <th>SL</th>
                      <th>Number</th>
                      <th>Mobile</th>
                      <th>Given Price</th>
                      <th>Status</th>
                      <th>Date</th>
                      <th>Billed By</th>
                      <th>In Active</th>
                      <th>Edit</th>
                    </tr>
                    </thead>
                    <tbody v-if="previousBill && previousBill.data.length === 0" >
                      <tr class="text-center" >
                        <td colspan="7" >No transaction found!</td>
                      </tr>
                    </tbody>
                    <tbody v-else-if="previousBill && previousBill.data.length > 0" >
                      <tr v-for="(b,i) in previousBill.data" >
                        <td>{{i+1}}</td>
                        <td>{{b.number}}</td>
                        <td>{{b.mobileNumber}}</td>
                        <td>{{b.givenPrice}}</td>
                        <td>
                          <span v-if="b.isActive" >Active</span>
                          <span v-else >In Active</span>
                        </td>
                        <td>{{new Date(b.createdAt).toDateString()}}</td>
                        <td>{{b.billedBy}}</td>
                        <td><i class="fas fa-power-off" ></i></td>
                        <td><i class="fas fa-edit" ></i></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div v-if="previousBill" class="modal-footer" >
                  <nav aria-label="Page navigation example">
                    <ul class="pagination">
                      <li v-for="(p,i) in previousBill.links"
                          v-on:click="onModalOpen(p)"
                          :class="[p.active ? 'page-item my-cursor active' : 'page-item my-cursor']">
                        <span class="page-link" v-if="p.label.includes('Previous')" ><i class="fas fa-arrow-left" ></i></span>
                        <span class="page-link" v-else-if="p.label.includes('Next')" ><i class="fas fa-arrow-right" ></i></span>
                        <span class="page-link" v-else >{{p.label}}</span>
                      </li>
                    </ul>
                  </nav>
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
            <h1 class="h2">Entry</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group me-2">
                <button v-on:click="onModalOpen({url: 'http://localhost:3000/dashboard/sales/offline?page=1'})"
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
          <div class="row" >
            <div class="col" >
              <div class="input-group input-group-sm mb-3">
                <span class="input-group-text">Billing Date</span>
                <input type="date"
                       v-model="billViewModel.date"
                       :min="billViewModel.minDate"
                       :max="billViewModel.maxDate"
                       class="form-control">
                <div v-show="showValidation && !billViewModel.date" class="invalid-feedback open">
                  Billing date required!
                </div>
              </div>
            </div>
            <div class="col" >
              <div class="input-group input-group-sm mb-3">
                <span class="input-group-text">Bill number</span>
                <input type="text" v-model="billViewModel.number" class="form-control" disabled>
              </div>
            </div>
          </div>
          <div class="row" >
            <div class="col" >
              <div class="input-group input-group-sm mb-3">
                <span class="input-group-text">Mobile Number</span>
                <input type="text" v-model="billViewModel.mobileNumber" class="form-control">
                <div v-show="showValidation && !billViewModel.mobileNumber"
                     class="invalid-feedback open">
                  Mobile number required!
                </div>
              </div>
            </div>
            <div class="col" >
              <div class="input-group input-group-sm mb-3">
                <span class="input-group-text">Name</span>
                <input v-model="billViewModel.firstName" type="text" class="form-control">
              </div>
            </div>
          </div>
          <table class="table table-striped table-sm">
            <thead>
            <tr>
              <th>SL</th>
              <th>Code</th>
              <th>Quantity</th>
              <th>Vat(%)</th>
              <th>Price</th>
              <th>Total</th>
            </tr>
            </thead>
            <tbody>
            <tr v-show="showValidation && salasValidationMsg" class="text-center">
              <td colspan="5" style="color: red" >{{salasValidationMsg}}</td>
            </tr>
            <tr  v-for="(s,i) in billViewModel.salesViewModels" >
              <td>{{i+1}}</td>
              <td><input v-model="s.productCode" type="text" class="form-control" :disabled="isConfirmed"></td>
              <td><input v-model="s.productQuantity" type="number" class="form-control" :disabled="isConfirmed"></td>
              <td><input v-model="s.vatPercentage" type="number" class="form-control" disabled></td>
              <td><input v-model="s.singlePrice" type="number" class="form-control" disabled></td>
              <td><input v-model="s.total" type="number" class="form-control" disabled></td>
            </tr>
            <tr>
              <td colspan="4" class="text-center" ></td>
              <td class="text-center" >Given Price</td>
              <td>
                <input v-model="billViewModel.givenPrice" type="number" class="form-control" :disabled="isConfirmed">
              </td>
            </tr>
            <tr>
              <td colspan="6" class="text-center" >
                <button v-on:click="addOrRemoveSales(1)" class="btn btn-outline-success" >
                  <i class="fas fa-plus" ></i>
                </button>
                <button v-on:click="addOrRemoveSales(-1)" class="btn btn-danger" >
                  <i class="fas fa-minus" ></i>
                </button>
              </td>
            </tr>
            <tr v-if="isConfirmed" >
              <td colspan="5" >
                <button class="btn btn-success" >
                  <span v-if="billViewModel.number" >Update</span>
                  <span v-else v-on:click="onCreate" >Save</span>
                </button>
              </td>
              <td class="text-end" >
                <button v-on:click="onCancel" class="btn btn-outline-dark" >Cancel</button>
              </td>
            </tr>
            <tr v-else >
              <td colspan="5" >
                <button class="btn btn-success" v-on:click="verifyInput(opState.OTHER)" >Confirm</button>
              </td>
              <td class="text-end" >
                <button v-on:click="onReset" class="btn btn-outline-dark" >Reset</button>
              </td>
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
  name: "offline",
  mounted() {
    this.currentDate = new Date();
    this.billViewModel.date = this.formatDate(this.currentDate);
    this.billViewModel.maxDate = this.formatDate(this.currentDate);
    this.billViewModel.minDate = this.formatDate(this.currentDate,1)
  },
  data(){
    return{
      isConfirmed: false,
      salasValidationMsg: "",
      currentDate : null,
      showValidation : false,
      previousBill: null,
      billViewModel : {
        number: "",
        date: "",
        minDate : "",
        maxDate: "",
        mobileNumber : "",
        firstName : "",
        givenPrice: 0,
        salesViewModels : [
          {
            singlePrice : 0,
            vatPercentage : 0,
            productCode : "",
            productQuantity : 0,
            total : 0
          }
        ]
      }
    }
  },
  methods : {
    onCancel(){
      this.isConfirmed = false;
    },
    onReset(){
      this.billViewModel.number = "";
      this.billViewModel.mobileNumber = "";
      this.billViewModel.givenPrice = 0;
      this.billViewModel.firstName = "";
      this.billViewModel.salesViewModels.forEach(obj=>{
        obj.productCode = "";
        obj.productQuantity = 0;
        obj.total = 0;
        obj.singlePrice = 0;
        obj.vatPercentage = 0;
      });
    },
    addOrRemoveSales(flag){
      if(flag === 1){
        this.billViewModel.salesViewModels.push({
          singlePrice : 0,
          vatPercentage : 0,
          productCode : "",
          productQuantity : 0,
          total: 0
        });
      }else {
        if(this.billViewModel.salesViewModels.length > 1){
          this.billViewModel.salesViewModels.pop();
        }
      }
    },
    verifyInput(which){
      if (which === this.opState.OTHER){
        this.showValidation = true;

        let quantityCheck = this.billViewModel.salesViewModels.findIndex(obj=>{
          return obj.productQuantity === 0 || obj.productQuantity === ""
        });

        let codeCheck = this.billViewModel.salesViewModels.findIndex(obj=>{
          return !obj.productCode
        });

        if (codeCheck !== -1){
          this.salasValidationMsg = `Code is missing on row: ${codeCheck+1}`;
        }else if (quantityCheck !== -1){
          this.salasValidationMsg = `Quantity is missing on row: ${quantityCheck+1}`;
        }else {
          this.showValidation = false;
          this.isConfirmed = true;
          this.billViewModel.salesViewModels.forEach(obj=>{
            obj.productQuantity = parseInt(obj.productQuantity);
          });
          this.getProductVatAndPrice();
        }
      }
    },
    getProductVatAndPrice(){
      this.showLoader(this);
      this.$axios.$post('/sales-offline/calculation',{
        billViewModel : this.billViewModel,
        userInfoViewModel: this.getAuthInfo()
      }).then(res=>{
        if(res.code === this.networkState.SUCCESS){
          res.saleViewModels.forEach((obj,index)=>{
            this.billViewModel.salesViewModels[index].vatPercentage = obj.vatPercentage;
            this.billViewModel.salesViewModels[index].singlePrice = obj.singlePrice;
            this.billViewModel.salesViewModels[index].total = obj.total;
          });
          this.billViewModel.givenPrice = res.grandTotal;
          this.showSuccess(this, res.msg);
        }else {
          this.showErrorMsg(this,this.opState.OTHER,res.msg);
        }
      }).catch(err=>{
        this.showError(this,this.opState.OTHER);
      });
    },
    onModalOpen(obj){
      if (obj.url){
        let url = new URL(obj.url);
        let page = url.searchParams.get("page");
        this.$axios.$get('/bills?page='+parseInt(page)).then(res=>{
          if(res.code === this.networkState.SUCCESS){
            this.previousBill = res.paginator;
          }else {
            this.showErrorMsg(this,this.opState.OTHER,res.msg);
          }
        }).catch(err=>{
          this.showError(this,this.opState.OTHER);
        });
      }
    },
    onAlertClose(eventData){
      console.log("eventDate=",eventData);
    },
    onLeftBtnClick(eventData){
      console.log("eventDate=",eventData);
    },
    onRightBtnClick(eventData){
      if(eventData === this.opState.CREATE){
        this.onCreate();
      }else if(eventData === this.opState.OTHER){
        this.getProductVatAndPrice();
      }
    },
    onCreate(){
      this.showLoader(this);
      this.$axios.$post('/sales-offline',{
        billViewModel : this.billViewModel,
        userInfoViewModel: this.getAuthInfo()
      }).then(res=>{
        if(res.code === this.networkState.SUCCESS){
          this.billViewModel.number = res.model.number;
          this.showSuccess(this, res.msg);
        }else {
          this.showErrorMsg(this,this.opState.OTHER,res.msg);
        }
      }).catch(err=>{
        this.showError(this,this.opState.OTHER);
      });
    }
  }
}
</script>

<style scoped>
  .my-cursor{
    cursor: pointer;
    color: black;
  }
</style>
