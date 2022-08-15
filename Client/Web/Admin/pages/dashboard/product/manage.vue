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
                        <option v-bind:value="null">--select--</option>
                        <option v-bind:value="f.id" v-for="f in productViewModel.fabrics" >
                          {{f.fabricName}}
                        </option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label for="sizeSelectInput" class="form-label">Size</label>
                      <select id="sizeSelectInput"
                              v-model="productViewModel.sizeId"
                              class="form-select" >
                        <option v-bind:value="null">--select--</option>
                        <option v-bind:value="s.id" v-for="s in productViewModel.sizes" >
                          {{s.sizeName}}
                        </option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label for="ageSelectInput" class="form-label">Age</label>
                      <select id="ageSelectInput"
                              v-model="productViewModel.userAgeId"
                              class="form-select" >
                        <option v-bind:value="null">--select--</option>
                        <option v-bind:value="a.id" v-for="a in productViewModel.ages" >
                          <template v-if="a.fixedAge">Fixed Age - {{a.fixedAge}}</template>
                          <template v-else>Min Age - {{a.maxAge}}, Max Age - {{a.minAge}}</template>
                        </option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label for="colorSelectInput" class="form-label">Color</label>
                      <select id="colorSelectInput"
                              v-model="productViewModel.colorId"
                              class="form-select" >
                        <option v-bind:value="null">--select--</option>
                        <option v-bind:value="c.id" v-for="c in productViewModel.colors" >
                          {{c.colorName}}
                        </option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label for="typeSelectInput" class="form-label">Type</label>
                      <select id="typeSelectInput"
                              v-model="productViewModel.typeId"
                              class="form-select" >
                        <option v-bind:value="null">--select--</option>
                        <option v-bind:value="t.id" v-for="t in productViewModel.types" >
                          {{t.typeName}}
                        </option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label for="brandSelectInput" class="form-label">Brand</label>
                      <select id="brandSelectInput"
                              v-model="productViewModel.brandId"
                              class="form-select" >
                        <option v-bind:value="null">--select--</option>
                        <option v-bind:value="b.id" v-for="b in productViewModel.brands" >
                          {{b.brandName}}
                        </option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label for="userSelectInput" class="form-label">User</label>
                      <select id="userSelectInput"
                              v-model="productViewModel.userTypeId"
                              class="form-select" >
                        <option v-bind:value="null">--select--</option>
                        <option v-bind:value="u.id" v-for="u in productViewModel.userTypes" >
                          {{u.userTypeName}}
                        </option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label for="billSelectInput" class="form-label">Bill No(Supplier)</label>
                      <select id="billSelectInput"
                              v-model="productViewModel.billNumber"
                              class="form-select" required>
                        <option v-bind:value="null">--select--</option>
                        <option v-bind:value="b.billNumber" v-for="b in productViewModel.supplierBills" >
                          {{b.billNumber}}
                        </option>
                      </select>
                      <div class="invalid-feedback">
                        Please select bill number!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="totalQuantityInput" class="form-label">Quantity</label>
                      <input v-model="productViewModel.totalQuantity"
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
                      <label for="singlePriceInput" class="form-label">Price</label>
                      <input v-model="productViewModel.singlePurchasePrice"
                             type="number"
                             class="form-control"
                             id="singlePriceInput" required>
                      <div class="invalid-feedback">
                        Please give single price!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="minOfferInput" class="form-label">Offer(%)</label>
                      <input v-model="productViewModel.minOfferPercentage"
                             type="number"
                             class="form-control"
                             id="minOfferInput" required>
                      <div class="invalid-feedback">
                        Please give minimum offer percentage!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="maxProfitInput" class="form-label">Profit(%)</label>
                      <input v-model="productViewModel.minProfitPercentage"
                             type="number"
                             class="form-control"
                             id="maxProfitInput" required>
                      <div class="invalid-feedback">
                        Please give minimum profit percentage!
                      </div>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="vatInput" class="form-label">VAT(%)</label>
                      <input v-model="productViewModel.vatPercentage"
                         type="number"
                         class="form-control"
                         id="vatInput">
                    </div>
                    <div class="mb-3" >
                      <multiple-image
                        @upload-success="uploadImageSuccess"
                        @edit-image="editImage"
                        @before-remove="beforeRemove"
                        :data-images="productViewModel.initImages"
                        dragText="Drag images (multiple)"
                        browseText="(or) Select">
                      </multiple-image>
                    </div>
                  </form>
                </div>
                <div class="modal-footer" >
                  <div v-if="productViewModel.id === -1" ></div>
                  <button v-else-if="productViewModel.id === 0"
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
              <th>Code</th>
              <th>Bill No(Supplier)</th>
              <th>Total(Qty)</th>
              <th>Available(Qty)</th>
              <th>Offer(%)</th>
              <th>Profit(%)</th>
              <th>Price</th>
              <th>VAT(%)</th>
              <th>Edit</th>
              <th>View</th>
              <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(f,i) in productViewModel.products" >
              <td>{{i+1}}</td>
              <td>{{f.code}}</td>
              <td>{{f.billNumber}}</td>
              <td>{{f.totalQuantity}}</td>
              <td>{{f.availableQuantity}}</td>
              <td>{{f.minOfferPercentage}}</td>
              <td>{{f.minProfitPercentage}}</td>
              <td>{{f.singlePurchasePrice}}</td>
              <td>{{f.vatPercentage}}</td>
              <td><i class="fas fa-edit cp" v-on:click="setFormData(f,false)" ></i></td>
              <td><i class="fas fa-eye cp" v-on:click="setFormData(f,true)" ></i></td>
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
        code: null,
        colorId : null,
        fabricId : null,
        sizeId : null,
        userAgeId : null,
        brandId : null,
        typeId : null,
        userTypeId : null,
        billNumber : null,
        totalQuantity : null,
        vatPercentage : 0,
        availableQuantity : null,
        singlePurchasePrice : null,
        minOfferPercentage : null,
        minProfitPercentage : null,
        products : [],
        sizes : [],
        fabrics : [],
        ages : [],
        brands : [],
        types : [],
        userTypes : [],
        colors : [],
        supplierBills : [],
        images : [],
        initImages : [],
        deletedImageIds : [],
        startDate : null,
        endDate: null
      },
    }
  },
  methods: {
    setFormData(product,isViewMood){
      this.productViewModel.id = isViewMood ? -1 : product.id;
      this.productViewModel.code = product.code;
      this.productViewModel.billNumber = product.billNumber;
      this.productViewModel.colorId = product.colorId;
      this.productViewModel.fabricId = product.fabricId;
      this.productViewModel.sizeId = product.sizeId;
      this.productViewModel.userAgeId = product.userAgeId;
      this.productViewModel.brandId = product.brandId;
      this.productViewModel.typeId = product.typeId;
      this.productViewModel.userTypeId = product.userTypeId;
      this.productViewModel.totalQuantity = product.totalQuantity;
      this.productViewModel.availableQuantity = product.availableQuantity;
      this.productViewModel.minProfitPercentage = product.minProfitPercentage;
      this.productViewModel.minOfferPercentage = product.minOfferPercentage;
      this.productViewModel.singlePurchasePrice = product.singlePurchasePrice;
      this.productViewModel.vatPercentage = product.vatPercentage;
      this.productViewModel.initImages = [];

      let self = this;
      product.images.forEach(obj=>{
        self.productViewModel.initImages.push({
          id: obj.id,
          path: obj.imagePath
        });
      });

      this.$refs.updateProductBtn.click();
    },
    uploadImageSuccess(formData, index, fileList) {
      this.productViewModel.images = fileList;
    },
    beforeRemove (index, done, fileList) {
      let r = confirm("Do you want to remove the image?");
      if (r === true) {
        if(fileList[index].id){
          this.pushDeletedImageId(fileList[index].id);
        }
        done();
      }
    },
    pushDeletedImageId(id){
      if (!this.productViewModel.deletedImageIds.includes(id)){
        this.productViewModel.deletedImageIds.push(id);
      }
    },
    editImage (formData, index, fileList) {
      this.productViewModel.images = fileList;
    },
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

      if(
        which === this.opState.CREATE &&
        this.productViewModel.billNumber &&
        this.productViewModel.totalQuantity &&
        this.productViewModel.singlePurchasePrice &&
        this.productViewModel.minOfferPercentage &&
        this.productViewModel.minProfitPercentage &&
        this.productViewModel.images.length > 0
      ){
        this.onCreate();
      }

      if(
        which === this.opState.UPDATE &&
        this.productViewModel.billNumber &&
        this.productViewModel.totalQuantity &&
        this.productViewModel.singlePurchasePrice &&
        this.productViewModel.minOfferPercentage &&
        this.productViewModel.minProfitPercentage
      ){
        this.onUpdate();
      }
    },
    onReset(){
      this.productViewModel.id = 0;
      this.productViewModel.code = null;
      this.productViewModel.billNumber = null;
      this.productViewModel.colorId = null;
      this.productViewModel.fabricId = null;
      this.productViewModel.sizeId = null;
      this.productViewModel.userAgeId = null;
      this.productViewModel.brandId = null;
      this.productViewModel.typeId = null;
      this.productViewModel.userTypeId = null;
      this.productViewModel.totalQuantity = null;
      this.productViewModel.availableQuantity = null;
      this.productViewModel.minProfitPercentage = null;
      this.productViewModel.minOfferPercentage = null;
      this.productViewModel.singlePurchasePrice = null;
      this.productViewModel.vatPercentage = 0;
      this.productViewModel.initImages = [];
    },
    onAlertClose(eventData){},
    onLeftBtnClick(eventData){},
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
      this.productViewModel.images.forEach((obj,index)=>{
        formData.append("productImages[]",this.b64toBlob(this.productViewModel.images[index].path),obj.name);
      });

      formData.append("productViewModel",JSON.stringify(this.productViewModel));
      formData.append("userInfoViewModel",JSON.stringify(this.getAuthInfo()));
      const headers = { 'Content-Type': 'multipart/form-data' };

      this.showLoader(this);

      this.$axios.$post('/products',formData,{ headers }).then(res=>{
        if(res.code === this.networkState.SUCCESS){
          this.productViewModel.products.push({
            id : res.model.id,
            code : res.model.code,
            billNumber : res.model.billNumber,
            colorId : res.model.colorId,
            fabricId : res.model.fabricId,
            sizeId : res.model.sizeId,
            userAgeId : res.model.userAgeId,
            brandId : res.model.brandId,
            typeId : res.model.typeId,
            userTypeId : res.model.userTypeId,
            totalQuantity : res.model.totalQuantity,
            availableQuantity : res.model.availableQuantity,
            minProfitPercentage : res.model.minProfitPercentage,
            minOfferPercentage : res.model.minOfferPercentage,
            singlePurchasePrice : res.model.singlePurchasePrice,
            vatPercentage : res.model.vatPercentage,
            images: res.images
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

      this.productViewModel.images.forEach((obj,index)=>{
        if(obj.name){
          formData.append("productImages[]",this.b64toBlob(this.productViewModel.images[index].path),obj.name);
        }
        if(obj.name && obj.id){
          this.pushDeletedImageId(obj.id);
        }
      });

      formData.append("productViewModel",JSON.stringify(this.productViewModel));
      formData.append("userInfoViewModel",JSON.stringify(this.getAuthInfo()));
      formData.append('_method', 'PUT');

      const headers = { 'Content-Type': 'multipart/form-data' };

      this.showLoader(this);

      this.$axios.$post('/products',formData,{ headers }).then(res=>{
        if(res.code === this.networkState.SUCCESS){
          this.productViewModel.deletedImageIds = [];

          let objIndex = this.productViewModel.products.findIndex((obj => obj.id === this.productViewModel.id));

          this.productViewModel.products[objIndex].billNumber = res.model.billNumber;
          this.productViewModel.products[objIndex].colorId = res.model.colorId;
          this.productViewModel.products[objIndex].fabricId = res.model.fabricId;
          this.productViewModel.products[objIndex].sizeId = res.model.sizeId;
          this.productViewModel.products[objIndex].userAgeId = res.model.userAgeId;
          this.productViewModel.products[objIndex].brandId = res.model.brandId;
          this.productViewModel.products[objIndex].typeId = res.model.typeId;
          this.productViewModel.products[objIndex].userTypeId = res.model.userTypeId;
          this.productViewModel.products[objIndex].totalQuantity = res.model.totalQuantity;
          this.productViewModel.products[objIndex].availableQuantity = res.model.availableQuantity;
          this.productViewModel.products[objIndex].minProfitPercentage = res.model.minProfitPercentage;
          this.productViewModel.products[objIndex].minOfferPercentage = res.model.minOfferPercentage;
          this.productViewModel.products[objIndex].singlePurchasePrice = res.model.singlePurchasePrice;
          this.productViewModel.products[objIndex].vatPercentage = res.model.vatPercentage;

          this.productViewModel.initImages = [];

          let self = this;
          res.images.forEach(obj=>{
            self.productViewModel.initImages.push({
              id: obj.id,
              path: obj.imagePath
            });
          });

          this.showSuccess(this,res.msg);
        }else {
          this.showErrorMsg(this,this.opState.CREATE,res.msg);
        }
      }).catch(err=>{
        this.showError(this,this.opState.CREATE);
      });
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
