<template>
  <div class="my-template" >
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

                </div>
                <div class="modal-footer">
                  <date-picker v-model="accountingTransaction.dateRange"
                               type="date"
                               value-type="YYYY-MM-DD"
                               format="YYYY-MM-DD"
                               range></date-picker>
                  <button type="submit"
                          class="btn btn-primary"
                          v-on:click="verifyInput('read')"
                          :data-bs-dismiss="dataBsDismiss">
                    Show
                  </button>
                </div>
              </div>
            </div>
          </div>
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
            <h1 class="h2">Ais Entry</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group me-2">
                <button v-on:click="onModalOpen"
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
                <span class="input-group-text">Voucher Date</span>
                <input type="date" v-model="accountingTransaction.voucherDate" class="form-control">
                <div v-show="showValidation && !accountingTransaction.voucherDate" class="invalid-feedback open">
                  Voucher date required!
                </div>
              </div>
            </div>
            <div class="col" >
              <div class="input-group input-group-sm mb-3">
                <span class="input-group-text">Voucher Type</span>
                <select v-model="accountingTransaction.voucherType" class="form-select" v-on:change="onVoucherTypeChange" >
                  <option v-bind:value="0">--select--</option>
                  <option v-bind:value="1" >Cash payment voucher</option>
                  <option v-bind:value="2" >Cash receive voucher</option>
                  <option v-bind:value="3" >Bank payment voucher</option>
                  <option v-bind:value="4" >Bank receive voucher</option>
                  <option v-bind:value="5" >Journal voucher(Debit)</option>
                  <option v-bind:value="6" >Journal voucher(Credit)</option>
                </select>
                <div v-show="showValidation && accountingTransaction.voucherType === 0"
                     class="invalid-feedback open">
                  Please select a voucher type!
                </div>
              </div>
            </div>
            <div class="col" >
              <div class="input-group input-group-sm mb-3">
                <span class="input-group-text">Voucher No.</span>
                <input v-model="accountingTransaction.voucherNo" type="text" class="form-control" disabled>
              </div>
            </div>
          </div>
          <div v-show="accountingTransaction.voucherType === 3 || accountingTransaction.voucherType === 4"
               class="row" >
            <div class="col" >
              <div class="input-group input-group-sm mb-3">
                <span class="input-group-text">Bank Account</span>
                <select v-model="accountingTransaction.chartOfAccountOid" class="form-select">
                  <option v-bind:value="0">--select--</option>
                  <option v-bind:value="b.oid" v-for="b in bankAccounts" >{{b.accountName}}</option>
                </select>
                <div v-show="showValidation && accountingTransaction.chartOfAccountOid === 0"
                     class="invalid-feedback open">
                  Please select a bank account!
                </div>
              </div>
            </div>
            <div class="col" >
              <div class="input-group input-group-sm mb-3">
                <span class="input-group-text">Check Date</span>
                <input type="date" v-model="accountingTransaction.checkDate" class="form-control">
                <div v-show="showValidation && !accountingTransaction.checkDate"
                     class="invalid-feedback open">
                  Bank check date required!
                </div>
              </div>
            </div>
            <div class="col" >
              <div class="input-group input-group-sm mb-3">
                <span class="input-group-text">Check No.</span>
                <input v-model="accountingTransaction.checkNo" type="text" class="form-control">
                <div v-show="showValidation && !accountingTransaction.checkNo"
                     class="invalid-feedback open">
                  Bank check number required!
                </div>
              </div>
            </div>
          </div>
          <div v-show="accountingTransaction.voucherType === 5 || accountingTransaction.voucherType === 6"
               class="row" >
            <div class="col" >
              <div class="input-group input-group-sm mb-3">
                <span class="input-group-text">
                  <span v-if="accountingTransaction.voucherType === 5" >Debit</span>
                  <span v-else >Credit</span>
                  &nbsp;Account
                </span>
                <select v-model="accountingTransaction.chartOfAccountOid" class="form-select">
                  <option v-bind:value="0">--select--</option>
                  <option v-bind:value="c.oid" v-for="c in chartOfAccounts" >{{c.accountName}}</option>
                </select>
                <div v-show="showValidation && accountingTransaction.chartOfAccountOid === 0"
                     class="invalid-feedback open">
                  Please select an account!
                </div>
              </div>
            </div>
          </div>
          <table class="table table-striped table-sm">
            <thead>
            <tr>
              <th>SL</th>
              <th>Account</th>
              <th>Amount</th>
            </tr>
            </thead>
            <tbody>
            <tr v-show="showValidation && accountingTransactionsValidation.code === 404"
                class="text-center">
              <td colspan="3" style="color: red" >{{accountingTransactionsValidation.msg}}</td>
            </tr>
            <tr  v-for="(t,i) in accountingTransactions" >
              <td>{{i+1}}</td>
              <td>
                <select v-model="t.chartOfAccountOid"
                        class="form-select"
                        v-on:change="onAccountingTransactionChange(t)" >
                  <option v-bind:value="0">--select--</option>
                  <option v-bind:value="c.oid" v-for="c in chartOfAccounts" >{{c.accountName}}</option>
                </select>
              </td>
              <td>
                <input v-model="t.amt" type="number" class="form-control">
              </td>
            </tr>
            <tr>
              <td colspan="3" >
                <textarea v-model="accountingTransaction.narration" class="form-control" placeholder="Narration" ></textarea>
              </td>
            </tr>
            <tr>
              <td colspan="2" >
                <button class="btn btn-success" v-on:click="verifyInput('create')" >Save</button>
              </td>
              <td>
                <button v-on:click="addOrRemoveAccountingTransaction(1)" class="btn btn-outline-success" >
                  <i class="fas fa-plus" ></i>
                </button>
                <button v-on:click="addOrRemoveAccountingTransaction(-1)" class="btn btn-danger" >
                  <i class="fas fa-minus" ></i>
                </button>
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
  name: "entry",
  mounted() {
    this.cookieUserInfo = this.$cookies.get('userInfo');
    this.getInitialData();
  },
  data(){
    return{
        cookieUserInfo : "",
        modalState : "close",
        dataBsDismiss : "",
        wasValidated : "",
        showValidation : false,
        // code
        // 0/1 === 1 show, 0 hide
        // 3 === loading
        response : {
          code : 1,
          msg : "Loading...",
        },
        cashChartOfAccount : {},
        chartOfAccounts : [],
        bankAccounts : [],
        accountingTransaction : {
            accountName : "",
            voucherDate : "",
            voucherType : 0,
            voucherNo : "",
            checkNo : "",
            checkDate : "",
            chartOfAccountOid : 0,
            chartOfAccountRootOid : 0,
            narration : "",
            dateRange: null
        },
        accountingTransactionsValidation : {
            code : 404,
            msg : "Please select at least one account and give some amount!"
        },
        accountingTransactions : [
          {
            amt : "",
            chartOfAccountOid : 0,
            chartOfAccountRootOid : 0
          }
        ]
    }
  },
  methods : {
      onModalOpen(){

      },
      onAccountingTransactionChange(obj){
          let repeatCounter = 0;
          this.accountingTransactions.forEach(function (item) {
              if(item.chartOfAccountOid ===  obj.chartOfAccountOid){
                  repeatCounter++;
              }
          });
          if(repeatCounter>1){
              let x = this.chartOfAccounts.find(item=>item.oid === obj.chartOfAccountOid);
              this.onResetResponse(404,x.accountName + " already selected please choose another account!");
              obj.chartOfAccountOid = 0;
              obj.amt = "";
              obj.chartOfAccountRootOid = 0;
          }
      },
      onVoucherTypeChange(){
          this.accountingTransaction.chartOfAccountOid = 0;
          this.accountingTransaction.chartOfAccountRootOid = 0;
          let oid = this.cashChartOfAccount.oid;
          this.accountingTransactions = [{
              amt : "",
              chartOfAccountOid : 0,
              chartOfAccountRootOid : 0
          }];
          if (this.accountingTransaction.voucherType === 1 || this.accountingTransaction.voucherType === 2){
              this.chartOfAccounts = this.chartOfAccounts.filter(function(item) {
                  return item.oid !== oid
              });
          }else {
              if(!this.chartOfAccounts.find(item=>item.oid === oid)){
                  this.chartOfAccounts.push(JSON.parse(JSON.stringify(this.cashChartOfAccount)));
              }
          }
      },
      performAccountingTransactionsValidation(){
          let accountCheck = this.accountingTransactions.find(function (item) {
              return item.chartOfAccountOid === 0;
          });

          let amtCheck = this.accountingTransactions.find(function (item) {
              return item.amt === 0 || item.amt === "";
          });

          if(this.accountingTransactions.length === 0){
              this.accountingTransactionsValidation.msg = "Please add at least one account!";
              this.accountingTransactionsValidation.code = 404;
          }else if(accountCheck !== undefined){
              this.accountingTransactionsValidation.msg = "Account selection missing!";
              this.accountingTransactionsValidation.code = 404;
          }else if(amtCheck !== undefined){
              this.accountingTransactionsValidation.msg = "Amount missing!";
              this.accountingTransactionsValidation.code = 404;
          }else {
              let self = this;
              let exChartOfAccounts = JSON.parse(JSON.stringify(self.chartOfAccounts));
              this.accountingTransactions.forEach(function (i) {
                  let coa = exChartOfAccounts.find(function (j) {
                      return j.oid === i.chartOfAccountOid;
                  });
                  i.chartOfAccountRootOid = coa.rootOid;
              });
              this.accountingTransactionsValidation.code = 200;
          }
          return this.accountingTransactionsValidation.code === 200;
      },
      verifyInput(which){
          if(which === "create"){
              this.showValidation = true;
              if(this.accountingTransaction.voucherType === 1 || this.accountingTransaction.voucherType === 2){
                  if(this.accountingTransaction.voucherDate && this.performAccountingTransactionsValidation()){
                      this.onCreate();
                  }
              }else if(this.accountingTransaction.voucherType === 3 || this.accountingTransaction.voucherType === 4){
                  if(this.accountingTransaction.chartOfAccountOid !== 0
                      && this.accountingTransaction.checkDate
                      && this.accountingTransaction.checkNo
                      && this.performAccountingTransactionsValidation()){
                      let coa = this.bankAccounts.find(item=>item.oid === this.accountingTransaction.chartOfAccountOid);
                      this.accountingTransaction.chartOfAccountRootOid = coa.rootOid;
                      this.onCreate();
                  }
              }else if(this.accountingTransaction.voucherType === 5 || this.accountingTransaction.voucherType === 6){
                  if(this.accountingTransaction.chartOfAccountOid !== 0
                      && this.performAccountingTransactionsValidation()){
                      let coa = this.chartOfAccounts.find(item=>item.oid === this.accountingTransaction.chartOfAccountOid);
                      this.accountingTransaction.chartOfAccountRootOid = coa.rootOid;
                      this.onCreate();
                  }
              }
          }else if (which === "read"){
              if(this.accountingTransaction.dateRange === null){
                  this.onResetResponse(404,"Please select the date range");
              }else {
                  this.onRead();
              }
          }
      },
      onRead(){
          this.onResetResponse(1,"Loading...");
          let url = "/ais/entries?start-date="+this.accountingTransaction.dateRange[0]+"&end-date="+
            this.accountingTransaction.dateRange[0];
          this.$axios.$get(url).then(res=>{
              this.onResetResponse(res.code,res.msg);
          }).catch(err=>{
              this.onResetResponse(404,"Something went wrong, please try again!");
          });
      },
      onCreate(){
          this.onResetResponse(1,"Loading...");
          this.$axios.$post('/ais/entries',{
              userInfo : {
                  email : this.cookieUserInfo.email,
                  sessionId: this.cookieUserInfo.sessionId,
                  href : window.location.pathname
              },
              accountingTransaction : this.accountingTransaction,
              accountingTransactions : this.accountingTransactions
          }).then(res=>{
              this.onResetResponse(res.code,res.msg);
          }).catch(err=>{
              this.onResetResponse(404,"Something went wrong, please try again!");
          });
      },
      addOrRemoveAccountingTransaction(flag){
        if(flag === 1){
            this.showValidation = true;
            if(this.performAccountingTransactionsValidation()){
                this.accountingTransactions.push({
                    amt : "",
                    chartOfAccountOid : 0,
                    chartOfAccountRootOid : 0
                });
            }
        }else {
            if(this.accountingTransactions.length > 1){
                this.accountingTransactions.pop();
            }
        }
      },
      onResetResponse(code,msg){
        this.response.code = code;
        this.response.msg = msg;
      },
      getInitialData(){
        this.$axios.$post('/ais/entries/view-init',{
          userInfo : {
            email : this.cookieUserInfo.email,
            sessionId: this.cookieUserInfo.sessionId,
            href : window.location.pathname
          }
        }).then(res=>{

          this.response.code = res.code;
          this.response.msg = res.msg;

          this.chartOfAccounts = [];
          res.chartOfAccounts.forEach(item=>{
            if(item.parentTreeId !== 3){
              this.chartOfAccounts.push(item);
            }
          });

          this.bankAccounts = [];
          res.chartOfAccounts.forEach(item=>{
            if(item.parentTreeId === 3){
              this.bankAccounts.push(item);
            }
          });

          console.log("ba = ",this.bankAccounts);
          this.cashChartOfAccount = this.chartOfAccounts.find(item=>item.oid === res.cashChartOfAccount.oid);
          this.onResetResponse(0,"");

        }).catch(err=>{
            this.onResetResponse(404,"Something went wrong, please try again!");
        });
      }
  }
}
</script>

<style scoped>

</style>
