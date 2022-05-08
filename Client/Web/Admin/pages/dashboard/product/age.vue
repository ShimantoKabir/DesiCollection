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
               id="ageFormModel"
               tabindex="-1"
               aria-labelledby="ageModalLabel"
               aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="ageModalLabel">
                    <span>Entries</span>
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form :class="formClassNames.join(' ')" novalidate>
                    <div v-show="!isFixedAgeEnable" class="mb-3">
                      <label for="minAgeInput" class="form-label">Min Age</label>
                      <input v-model="ageViewModel.minAge" type="number" class="form-control" id="minAgeInput" min="0">
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div v-show="!isFixedAgeEnable" class="mb-3">
                      <label for="maxAgeInput" class="form-label">Max Age</label>
                      <input v-model="ageViewModel.maxAge" type="number" class="form-control" id="maxAgeInput" min="0">
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                    <div class="mb-3" >
                      <div class="form-check form-switch" v-on:click="onEnableFixedAge" >
                        <input class="form-check-input" type="checkbox" id="fixedAgeCheckbox">
                        <label class="form-check-label" for="fixedAgeCheckbox">
                          <span v-if="isFixedAgeEnable" >Enable fixed age</span>
                          <span v-else >Disable fixed age</span>
                        </label>
                      </div>
                    </div>
                    <div v-show="isFixedAgeEnable" class="mb-3">
                      <label for="fixedAgeInput" class="form-label">Fixed Age</label>
                      <input v-model="ageViewModel.fixedAge"
                             type="number"
                             class="form-control"
                             id="fixedAgeInput"
                             min="0">
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button v-if="ageViewModel.id === 0"
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
            <h1 class="h2">Age</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group me-2">
                <button
                  v-on:click="onModelOpen"
                  type="button"
                  class="btn btn-sm btn-outline-secondary"
                  data-bs-toggle="modal"
                  data-bs-target="#ageFormModel">
                  <i class="fas fa-plus" ></i>
                </button>
                <button
                  ref="updateAgeBtn"
                  type="button"
                  class="btn btn-sm btn-outline-secondary age-update-btn"
                  data-bs-toggle="modal"
                  data-bs-target="#ageFormModel">
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
              <th>Min Age</th>
              <th>Max Age</th>
              <th>Fixed Age</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(f,i) in ageViewModel.ages" >
              <td>{{i+1}}</td>
              <td>{{f.minAge}}</td>
              <td>{{f.maxAge}}</td>
              <td>{{f.fixedAge}}</td>
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
  name: "age",
  mounted() {
    this.getInitialData();
  },
  data(){
    return{
      isFixedAgeEnable : false,
      ageViewModel: {
        id: 0,
        minAge : 0,
        maxAge : 0,
        fixedAge : 0,
        ages : []
      },
    }
  },
  methods: {
    onEnableFixedAge(){
      this.isFixedAgeEnable = document.getElementById("fixedAgeCheckbox").checked;
    },
    getInitialData(){
      this.showLoader(this);
      this.$axios.$post('/ages/index',{
        userInfo : this.getAuthInfo()
      }).then(res=>{
        if(res.code === this.networkState.SUCCESS){
          this.ageViewModel.ages = res.ages;
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
        if(this.ageViewModel.minAge || this.ageViewModel.maxAge || this.ageViewModel.fixedAge){
          which === this.opState.CREATE ? this.onCreate() : this.onUpdate();
        }else {
          this.$refs.alert.modify({
            isVisible: true,
            needHeader: true,
            needFooter: true,
            opState: this.opState.WARNING,
            bodyMsg: "Please fill up at least one age!",
            eventData: this.opState.WARNING
          });
        }
      }
    },
    onReset(){
      this.ageViewModel.minAge = 0;
      this.ageViewModel.maxAge = 0;
      this.ageViewModel.fixedAge = 0;
      this.ageViewModel.id = 0;
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
      this.$axios.$post('/ages',{
        userInfo : this.getAuthInfo(),
        ageViewModel : this.ageViewModel
      }).then(res=>{
        if(res.code === this.networkState.SUCCESS){
          this.ageViewModel.ages.push({
            id : res.model.id,
            minAge: res.model.minAge,
            maxAge: res.model.maxAge,
            fixedAge: res.model.fixedAge
          })
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
      this.$axios.$put('/ages',{
        userInfo : this.getAuthInfo(),
        ageViewModel : this.ageViewModel
      }).then(res=>{
        if(res.code === this.networkState.SUCCESS){

          let objIndex = this.ageViewModel.ages.findIndex((obj => obj.id === this.ageViewModel.id));
          this.ageViewModel.ages[objIndex].minAge = this.ageViewModel.minAge;
          this.ageViewModel.ages[objIndex].maxAge = this.ageViewModel.maxAge;
          this.ageViewModel.ages[objIndex].fixedAge = this.ageViewModel.fixedAge;

          this.showSuccess(this,res.msg);
        }else {
          this.showError(this,this.opState.UPDATE);
        }
      }).catch(err=>{
        this.showError(this,this.opState.UPDATE);
      });
    },
    setFormData(age){
      this.ageViewModel.id = age.id;
      this.ageViewModel.minAge = age.minAge;
      this.ageViewModel.maxAge = age.maxAge;
      this.ageViewModel.fixedAge = age.fixedAge;
      this.$refs.updateAgeBtn.click();
    },
    setDeleteData(age){
      this.ageViewModel.id = age.id;
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
          ageViewModel : {
            id : this.ageViewModel.id,
            minAge : this.ageViewModel.minAge,
            maxAge : this.ageViewModel.maxAge,
            fixedAge : this.ageViewModel.fixedAge
          }
        }
      };
      this.$axios.$delete("/sizes",config).then(res=>{
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
  .age-update-btn{
    display: none;
  }
</style>
