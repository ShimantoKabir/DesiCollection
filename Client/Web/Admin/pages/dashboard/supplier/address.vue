<template>
  <div class="my-template">
    <AlertComponent
      ref="alert"
      :on-alert-close="onAlertClose"
      :on-left-btn-click="onLeftBtnClick"
      :on-right-btn-click="onRightBtnClick"/>
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
                      <label for="supplierSelectInput" class="form-label">Supplier Name</label>
                      <select id="supplierSelectInput"
                              v-model="supplierAddressViewModel.supplierId"
                              class="form-select" >
                        <option v-bind:value="0">--select--</option>
                        <option v-bind:value="s.id" v-for="s in supplierAddressViewModel.suppliers" >
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
                      <label for="cityInput" class="form-label">City</label>
                      <input v-model="supplierAddressViewModel.city"
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
                      <input v-model="supplierAddressViewModel.email"
                             type="email"
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
                      <input v-model="supplierAddressViewModel.country"
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
                      <input v-model="supplierAddressViewModel.zipCode"
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
                      <input v-model="supplierAddressViewModel.firstMobileNo"
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
                      <input v-model="supplierAddressViewModel.secondMobileNo"
                             type="text"
                             class="form-control"
                             id="secondMobileNoCodeInput">
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="detailInput" class="form-label">Detail</label>
                      <textarea
                        class="form-control"
                        id="detailInput"
                        v-model="supplierAddressViewModel.detail">
                      </textarea>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button v-if="supplierAddressViewModel.id === 0"
                          type="submit"
                          class="btn btn-primary"
                          v-on:click="verifyInput(opState.CREATE)">
                    Save
                  </button>
                  <button v-else
                          type="submit"
                          class="btn btn-warning"
                          v-on:click="verifyInput(opState.UPDATE)">
                    Update
                  </button>
                  <button v-on:click="onReset" class="btn btn-outline-dark">Reset</button>
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
                  <i class="fas fa-plus"></i>
                </button>
                <button
                  ref="updateSupplierBtn"
                  type="button"
                  class="btn btn-sm btn-outline-secondary supplier-update-btn"
                  data-bs-toggle="modal"
                  data-bs-target="#supplierFormModel">
                  <i class="fas fa-plus"></i>
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
              <th>City</th>
              <th>Email</th>
              <th>Country</th>
              <th>Zip Code</th>
              <th>Mobile Number</th>
              <th>Detail</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(a,i) in supplierAddressViewModel.addresses">
              <td>{{ i + 1 }}</td>
              <td>{{ a.supplierName }}</td>
              <td>{{ a.city }}</td>
              <td>{{ a.email }}</td>
              <td>{{ a.country }}</td>
              <td>{{ a.zipCode }}</td>
              <td>
                <span>{{a.firstMobileNo}}</span>
                <br>
                <span v-if="a.secondMobileNo" >{{a.secondMobileNo}}</span>
                <span v-else >N/A</span>
              </td>
              <td>{{a.detail}}</td>
              <td><i class="fas fa-edit cp" v-on:click="setFormData(a)"></i></td>
              <td><i class="fas fa-trash cp" v-on:click="setDeleteData(a)"></i></td>
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
  name: "addresses",
  mounted() {
    this.getInitialData();
  },
  data() {
    return {
      supplierAddressViewModel: {
        id: 0,
        city: "",
        email: "",
        detail: "",
        country: "",
        zipCode: "",
        firstMobileNo: "",
        secondMobileNo: "",
        supplierId: 0,
        supplierName: "",
        suppliers: [],
        addresses : []
      },
    }
  },
  methods: {
    getInitialData() {
      this.showLoader(this);
      this.$axios.$post('/suppliers/addresses/index', {
        userInfo: this.getAuthInfo()
      }).then(res => {
        if (res.code === this.networkState.SUCCESS) {
          this.supplierAddressViewModel.suppliers = res.suppliers;
          this.supplierAddressViewModel.addresses = res.addresses;
          this.showSuccess(this, res.msg);
        } else {
          this.showError(this, this.opState.READ);
        }
      }).catch(err => {
        this.showError(this, this.opState.READ);
      });
    },
    verifyInput(which) {
      this.formClassNames.push("was-validated");

      let isAllFieldFilledUpForCreate = false;
      let isAllFieldFilledUpForUpdate = false;

      if (
        this.supplierAddressViewModel.city &&
        this.supplierAddressViewModel.email &&
        this.supplierAddressViewModel.country &&
        this.supplierAddressViewModel.zipCode &&
        this.supplierAddressViewModel.firstMobileNo &&
        this.supplierAddressViewModel.detail &&
        this.supplierAddressViewModel.supplierId !== 0
      ) {
        isAllFieldFilledUpForCreate = true;
      }

      if (this.supplierAddressViewModel.id !== 0 && isAllFieldFilledUpForCreate){
        isAllFieldFilledUpForUpdate = true;
      }

      if (which === this.opState.CREATE && isAllFieldFilledUpForCreate) {
        this.onCreate();
      }else if (which === this.opState.UPDATE && isAllFieldFilledUpForUpdate){
        this.onUpdate();
      }
    },
    onReset() {
      this.supplierAddressViewModel.id = 0;
      this.supplierAddressViewModel.city = "";
      this.supplierAddressViewModel.email = "";
      this.supplierAddressViewModel.detail = "";
      this.supplierAddressViewModel.country = "";
      this.supplierAddressViewModel.zipCode = "";
      this.supplierAddressViewModel.firstMobileNo = "";
      this.supplierAddressViewModel.secondMobileNo = "";
      this.supplierAddressViewModel.supplierId = 0;
      this.supplierAddressViewModel.supplierName = "";
    },
    onAlertClose(eventData) {
      console.log("eventDate=", eventData);
    },
    onLeftBtnClick(eventData) {
      console.log("eventDate=", eventData);
    },
    onRightBtnClick(eventData) {
      if (eventData === this.opState.READ) {
        this.getInitialData();
      } else if (eventData === this.opState.CREATE) {
        this.onCreate();
      } else if (eventData === this.opState.DELETE) {
        this.onDelete();
      } else if (eventData === this.opState.UPDATE) {
        this.onUpdate();
      }
    },
    onCreate() {
      this.showLoader(this);
      this.$axios.$post('/suppliers/addresses', {
        userInfo: this.getAuthInfo(),
        supplierAddressViewModel: this.supplierAddressViewModel
      }).then(res => {
        if (res.code === this.networkState.SUCCESS) {
          let supplier = this.supplierAddressViewModel.suppliers
            .find((obj => obj.id === this.supplierAddressViewModel.supplierId));

          this.supplierAddressViewModel.addresses.push({
            id: res.model.id,
            city: res.model.city,
            email: res.model.email,
            detail: res.model.detail,
            country: res.model.country,
            zipCode: res.model.zipCode,
            supplierId: res.model.linkUpId,
            firstMobileNo: res.model.firstMobileNo,
            secondMobileNo: res.model.secondMobileNo,
            supplierName: supplier.supplierName
          });

          this.showSuccess(this, res.msg);
        } else {
          this.showErrorMsg(this, this.opState.CREATE, res.msg);
        }
      }).catch(err => {
        this.showError(this, this.opState.CREATE);
      });
    },
    onUpdate() {
      this.showLoader(this);
      this.$axios.$put('/suppliers/addresses', {
        userInfo: this.getAuthInfo(),
        supplierAddressViewModel: this.supplierAddressViewModel
      }).then(res => {
        if (res.code === this.networkState.SUCCESS) {

          let objIndex = this.supplierAddressViewModel.addresses
            .findIndex((obj => obj.id === this.supplierAddressViewModel.id));

          this.supplierAddressViewModel.addresses[objIndex].city = this.supplierAddressViewModel.city;
          this.supplierAddressViewModel.addresses[objIndex].email = this.supplierAddressViewModel.email;
          this.supplierAddressViewModel.addresses[objIndex].country = this.supplierAddressViewModel.country;
          this.supplierAddressViewModel.addresses[objIndex].zipCode = this.supplierAddressViewModel.zipCode;
          this.supplierAddressViewModel.addresses[objIndex].firstMobileNo = this.supplierAddressViewModel.firstMobileNo;
          this.supplierAddressViewModel.addresses[objIndex].secondMobileNo = this.supplierAddressViewModel.secondMobileNo;
          this.supplierAddressViewModel.addresses[objIndex].detail = this.supplierAddressViewModel.detail;
          this.supplierAddressViewModel.addresses[objIndex].supplierId = this.supplierAddressViewModel.supplierId;

          let supplier = this.supplierAddressViewModel.suppliers
            .find((obj => obj.id === this.supplierAddressViewModel.supplierId));

          this.supplierAddressViewModel.addresses[objIndex].supplierName = supplier.supplierName;

          this.showSuccess(this, res.msg);

        } else {
          console.log("by");
          this.showError(this, this.opState.UPDATE);
        }
      }).catch(err => {
        this.showError(this, this.opState.UPDATE);
      });
    },
    setFormData(supplier) {
      this.supplierAddressViewModel.id = supplier.id;
      this.supplierAddressViewModel.city = supplier.city;
      this.supplierAddressViewModel.email = supplier.email;
      this.supplierAddressViewModel.country = supplier.country;
      this.supplierAddressViewModel.zipCode = supplier.zipCode;
      this.supplierAddressViewModel.detail = supplier.detail;
      this.supplierAddressViewModel.firstMobileNo = supplier.firstMobileNo;
      this.supplierAddressViewModel.secondMobileNo = supplier.secondMobileNo;
      this.supplierAddressViewModel.supplierId = supplier.supplierId;
      this.supplierAddressViewModel.supplierName = supplier.supplierName;
      this.$refs.updateSupplierBtn.click();
    },
    setDeleteData(supplier) {
      this.supplierAddressViewModel.id = supplier.id;
      this.delete(this, this.opState.DELETE)
    },
    onDelete() {
      let config = {
        data: {
          userInfo: {
            email: this.cookieUserInfo.email,
            href: window.location.pathname,
            sessionId: this.cookieUserInfo.sessionId
          },
          supplierAddressViewModel: {
            id: this.supplierAddressViewModel.id,
          }
        }
      };
      this.$axios.$delete("/suppliers/addresses", config).then(res => {
        if (res.code === this.networkState.SUCCESS) {
          this.supplierAddressViewModel.addresses = this.supplierAddressViewModel.addresses
            .filter((item) => item.id !== this.supplierAddressViewModel.id);
          this.showSuccess(this, res.msg);
        } else {
          this.showError(this, this.opState.DELETE);
        }
      }).catch(err => {
        this.showError(this, this.opState.DELETE);
      });
    },
    onModelOpen() {
      this.onReset();
    }
  }
}
</script>

<style scoped>
.supplier-update-btn {
  display: none;
}
</style>
