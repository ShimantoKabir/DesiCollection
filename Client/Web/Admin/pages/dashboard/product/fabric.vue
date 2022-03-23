<template>
  <div class="my-template" >
    <AlertComponent
      ref="alert"
      :on-alert-close="onAlertClose"
      :on-negative-btn-click="onNegativeBtnClick"
      :on-positive-btn-click="onPositiveBtnClick" />
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
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">
                    <span>Entries</span>
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form :class="formClassNames.join(' ')" novalidate>
                    <div class="mb-3">
                      <label for="colorInput" class="form-label">Color</label>
                      <input v-model="productFabricViewModel.fabricName" type="text" class="form-control" id="colorInput" required>
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
                  <button v-if="productFabricViewModel.id === 0"
                          type="submit"
                          class="btn btn-primary"
                          v-on:click="verifyInput('create')" >
                    Save
                  </button>
                  <button v-else
                          type="submit"
                          class="btn btn-warning"
                          v-on:click="verifyInput('update')" >
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
                <button v-on:click="onModalOpen"
                    ref="addColorBtn"
                    type="button"
                    class="btn btn-sm btn-outline-secondary"
                    data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
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
            <tr  v-for="(f,i) in productFabricViewModel.productFabrics" >
              <td>{{i+1}}</td>
              <td>{{f.fabricName}}</td>
              <td><i class="fas fa-edit cp" v-on:click="setFormData(f)" ></i></td>
              <td><i class="fas fa-trash cp" v-on:click="onDelete(f)" ></i></td>
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
  name: "fabric",
  mounted() {
    console.log("userInfo=",this.cookieUserInfo);
  },
  data(){
    return{
      productFabricViewModel: {
        id: 0,
        fabricName : "",
        productFabrics : []
      },
    }
  },
  methods: {
    verifyInput(which){
      this.$refs.alert.modify({
        isVisible : true,
        networkState : this.networkState.LOADING,
      });
    },
    onReset(){

    },
    onAlertClose(eventData){
      console.log("eventDate=",eventData);
    },
    onNegativeBtnClick(eventData){
      console.log("eventDate=",eventData);
    },
    onPositiveBtnClick(eventData){
      console.log("eventDate=",eventData);
    },
    onModalOpen(){

    },
    setFormData(fabric){

    },
    onDelete(fabric){

    }
  }
}
</script>

<style scoped>

</style>
