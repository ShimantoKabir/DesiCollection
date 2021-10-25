<template>
  <div class="my-template" >
    <AppHeader/>
    <div class="container-fluid">
      <div class="row">
        <AppSidebar/>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 my-main">
          <div v-show="response.code === 1 || response.code === 200 || response.code === 404"
               class="alert alert-warning alert-dismissible fade show alert-top"
               role="alert">
            <strong>
              <span v-if="response.code === 1" class="spinner-border spinner-border-sm"></span>
              <span v-else-if="response.code === 200" >SUCCESS!</span>
              <span v-else-if="response.code === 404" >ERROR!</span>
              <span v-else >Unknown</span>
            </strong>
            &nbsp;
            <span>{{response.msg}}</span>
            <button v-on:click="onResetResponse(0,'')" type="button" class="btn-close"></button>
          </div>
          <div class="d-flex
            justify-content-between
            flex-wrap
            flex-md-nowrap
            align-items-center
            pt-3
            pb-2
            mb-3
            border-bottom">
            <h1 class="h2">Ais Report</h1>
          </div>
          <div class="row" >
            <div class="col" >
              <div class="input-group input-group-sm mb-3">
                <span class="input-group-text">Date Range</span>
                <date-picker v-model="reportViewModel.dateRange" type="date" range></date-picker>
                <div v-show="showValidation && reportViewModel.dateRange === null" class="invalid-feedback open">
                  Date range selection required!
                </div>
              </div>
            </div>
            <div class="col" >
              <div class="input-group input-group-sm mb-3">
                <span class="input-group-text">Report</span>
                <select v-model="reportViewModel.reportType" class="form-select" v-on:change="onReportTypeChange" >
                  <option v-bind:value="0">--select--</option>
                  <option v-bind:value="1" >Ledger</option>
                  <option v-bind:value="2" >Journal</option>
                  <option v-bind:value="3" >Trial Balance</option>
                  <option v-bind:value="4" >Income Statement</option>
                  <option v-bind:value="5" >Balance Sheet</option>
                </select>
                <div v-show="showValidation && reportViewModel.reportType === 0"
                     class="invalid-feedback open">
                  Please select a report!
                </div>
              </div>
            </div>
            <div class="col">
              <button class="btn btn-sm btn-success" v-on:click="verifyInput('showReport')" >Show</button>
            </div>
          </div>
        </main>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
        name: "report",
        mounted() {
            this.cookieUserInfo = this.$cookies.get('userInfo');
        },
        data(){
            return{
                cookieUserInfo : "",
                response : {
                    code : 0,
                    msg : "",
                },
                reportViewModel : {
                    dateRange : null,
                    reportType : 0,
                },
                showValidation : false,
            }
        },
        methods : {
            verifyInput(which){
                if (which === "showReport"){
                    this.showValidation = true;
                    if (this.reportViewModel.dateRange !== null && this.reportViewModel.reportType !== 0){
                        this.showReport();
                    }
                }
            },
            onResetResponse(code,msg){
                this.response.code = code;
                this.response.msg = msg;
            },
            onReportTypeChange(){

            },
            showReport(){
                this.onResetResponse(1,"Loading...");
                this.$axios.$post('/ais/report',{
                    userInfo : {
                        email : this.cookieUserInfo.email,
                        sessionId: this.cookieUserInfo.sessionId,
                        href : window.location.pathname
                    },
                    reportViewModel : this.reportViewModel
                }).then(res=>{

                    this.response.code = res.code;
                    this.response.msg = res.msg;

                }).catch(err=>{
                    this.onResetResponse(404,"Something went wrong, please try again!");
                });
            }
        }
    }
</script>

<style scoped>

</style>
