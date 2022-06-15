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
               id="productFormModel"
               tabindex="-1"
               aria-labelledby="productModalLabel"
               aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="productModalLabel">
                    <span>Entries</span>
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form :class="formClassNames.join(' ')" novalidate>
                    <div class="mb-3">
                      <label for="fabricSelectInput" class="form-label">Fabric</label>
                      <select id="fabricSelectInput"
                              v-model="productViewModel.fabricId"
                              class="form-select" >
                        <option v-bind:value="0">--select--</option>
                        <option v-bind:value="f.id" v-for="f in productViewModel.fabrics" >
                          {{f.fabricName}}
                        </option>
                      </select>
                      <div class="invalid-feedback">
                        Please select fabric!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="sizeSelectInput" class="form-label">Size</label>
                      <select id="sizeSelectInput"
                              v-model="productViewModel.sizeId"
                              class="form-select" >
                        <option v-bind:value="0">--select--</option>
                        <option v-bind:value="s.id" v-for="s in productViewModel.sizes" >
                          {{s.sizeName}}
                        </option>
                      </select>
                      <div class="invalid-feedback">
                        Please select size!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="ageSelectInput" class="form-label">Age</label>
                      <select id="ageSelectInput"
                              v-model="productViewModel.userAgeId"
                              class="form-select" >
                        <option v-bind:value="0">--select--</option>
                        <option v-bind:value="a.id" v-for="a in productViewModel.ages" >
                          <template v-if="a.fixedAge">Fixed Age - {{a.fixedAge}}</template>
                          <template v-else>Min Age - {{a.maxAge}}, Max Age - {{a.minAge}}</template>
                        </option>
                      </select>
                      <div class="invalid-feedback">
                        Please select age!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="colorSelectInput" class="form-label">Color</label>
                      <select id="colorSelectInput"
                              v-model="productViewModel.colorId"
                              class="form-select" >
                        <option v-bind:value="0">--select--</option>
                        <option v-bind:value="c.id" v-for="c in productViewModel.colors" >
                          {{c.colorName}}
                        </option>
                      </select>
                      <div class="invalid-feedback">
                        Please select color!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="typeSelectInput" class="form-label">Type</label>
                      <select id="typeSelectInput"
                              v-model="productViewModel.typeId"
                              class="form-select" >
                        <option v-bind:value="0">--select--</option>
                        <option v-bind:value="t.id" v-for="t in productViewModel.types" >
                          {{t.typeName}}
                        </option>
                      </select>
                      <div class="invalid-feedback">
                        Please select type!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="userSelectInput" class="form-label">User</label>
                      <select id="userSelectInput"
                              v-model="productViewModel.userTypeId"
                              class="form-select" >
                        <option v-bind:value="0">--select--</option>
                        <option v-bind:value="u.id" v-for="u in productViewModel.userTypes" >
                          {{u.userTypeName}}
                        </option>
                      </select>
                      <div class="invalid-feedback">
                        Please select user!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="billSelectInput" class="form-label">Bill Number</label>
                      <select id="billSelectInput"
                              v-model="productViewModel.billNumber"
                              class="form-select" >
                        <option v-bind:value="null">--select--</option>
                        <option v-bind:value="b.billNumber" v-for="b in productViewModel.supplierBills" >
                          {{b.billNumber}}
                        </option>
                      </select>
                      <div class="invalid-feedback">
                        Please select user!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button v-if="productViewModel.id === 0"
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
            <h1 class="h2">Product</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group me-2">
                <button
                  v-on:click="onModelOpen"
                  type="button"
                  class="btn btn-sm btn-outline-secondary"
                  data-bs-toggle="modal"
                  data-bs-target="#productFormModel">
                  <i class="fas fa-plus" ></i>
                </button>
                <button
                  ref="updateProductBtn"
                  type="button"
                  class="btn btn-sm btn-outline-secondary product-update-btn"
                  data-bs-toggle="modal"
                  data-bs-target="#productFormModel">
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
              <th>Product Name</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(f,i) in productViewModel.products" >
              <td>{{i+1}}</td>
              <td>{{f.colorName}}</td>
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
      productViewModel: {
        id: 0,
        code: 0,
        colorId : 0,
        colorName : "",
        fabricId : 0,
        fabricName : "",
        sizeId : 0,
        sizeName : "",
        userAgeId : 0,
        minAge : "",
        maxAge : "",
        fixedAge : "",
        brandId : 0,
        brandName : "",
        typeId : 0,
        typeName : "",
        userTypeId : 0,
        userTypeName : "",
        billNumber : null,
        availableQuantity : 0,
        singlePurchasePrice : 0,
        maxOfferPercentage : 0,
        maxProfitPercentage : 0,
        products : [],
        sizes : [],
        fabrics : [],
        ages : [],
        brands : [],
        types : [],
        userTypes : [],
        colors : [],
        supplierBills : [],
        startDate : '',
        endDate: ''
      },
    }
  },
  methods: {
    getInitialData(){
      this.showLoader(this);
      this.$axios.$post('/products/index',{
        userInfoViewModel : this.getAuthInfo(),
        productViewModel: this.productViewModel
      }).then(res=>{
        if(res.code === this.networkState.SUCCESS){
          this.productViewModel.products = res.products;
          this.productViewModel.sizes = res.sizes;
          this.productViewModel.fabrics = res.fabrics;
          this.productViewModel.ages = res.ages;
          this.productViewModel.brands = res.brands;
          this.productViewModel.types = res.types;
          this.productViewModel.userTypes = res.userTypes;
          this.productViewModel.colors = res.colors;
          this.productViewModel.supplierBills = res.supplierBills;
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
        if(this.productViewModel.productName){
          which === this.opState.CREATE ? this.onCreate() : this.onUpdate();
        }
      }
    },
    onReset(){
      this.productViewModel.productName = "";
      this.productViewModel.id = 0;
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
      this.$axios.$post('/products',{
        userInfoViewModel : this.getAuthInfo(),
        productViewModel : this.productViewModel
      }).then(res=>{
        if(res.code === this.networkState.SUCCESS){
          this.productViewModel.products.push({
            id : res.model.id,
            productName: res.model.productName
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
      this.$axios.$put('/products',{
        userInfoViewModel : this.getAuthInfo(),
        productViewModel : this.productViewModel
      }).then(res=>{
        if(res.code === this.networkState.SUCCESS){

          let objIndex = this.productViewModel.products.findIndex((obj => obj.id === this.productViewModel.id));
          this.productViewModel.products[objIndex].productName = this.productViewModel.productName;

          this.showSuccess(this,res.msg);
        }else {
          this.showErrorMsg(this,this.opState.UPDATE,res.msg);
        }
      }).catch(err=>{
        this.showError(this,this.opState.UPDATE);
      });
    },
    setFormData(product){
      this.productViewModel.id = product.id;
      this.productViewModel.productName = product.productName;
      this.$refs.updateProductBtn.click();
    },
    setDeleteData(product){
      this.productViewModel.id = product.id;
      this.delete(this, this.opState.DELETE)
    },
    onDelete(){
      let config = {
        data: {
          userInfoViewModel : this.getAuthInfo(),
          productViewModel : this.productViewModel
        }
      };
      this.$axios.$delete("/products",config).then(res=>{
        if(res.code === this.networkState.SUCCESS){
          this.productViewModel.products = this.productViewModel.products.filter((item) => item.id !== this.productViewModel.id);
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
  .product-update-btn{
    display: none;
  }
</style>
