<template>
  <div class="my-template" >
    <AppHeader/>
    <div class="container-fluid">
      <div class="row">
        <AppSidebar/>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 my-main">
          <div v-show="response.code !== 200 && response.init === 1"
               class="alert alert-warning alert-dismissible fade show alert-top"
               role="alert">
            <strong>
              <span v-if="isNetworkOpStarted" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              <span v-else >ERROR!</span>
            </strong>
            &nbsp;
            <span v-if="isNetworkOpStarted" >Loading...</span>
            <span v-else >{{response.msg}}</span>
            <button v-on:click="onResetResponse" type="button" class="btn-close" aria-label="Close">
            </button>
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
          </div>
          <div class="row" >
            <div class="col" >
              <div class="input-group input-group-sm mb-3">
                <span class="input-group-text">Voucher Date</span>
                <input type="date" v-model="accountingTransaction.voucherDate" class="form-control">
              </div>
            </div>
            <div class="col" >
              <div class="input-group input-group-sm mb-3">
                <span class="input-group-text">Voucher Type</span>
                <select v-model="accountingTransaction.voucherType" class="form-select">
                  <option v-bind:value="0">--select--</option>
                  <option v-bind:value="1" >Cash payment voucher</option>
                  <option v-bind:value="2" >Cash receive voucher</option>
                  <option v-bind:value="3" >Bank payment voucher</option>
                  <option v-bind:value="4" >Bank receive voucher</option>
                  <option v-bind:value="5" >Journal voucher(Debit)</option>
                  <option v-bind:value="6" >Journal voucher(Credit)</option>
                </select>
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
                <span class="input-group-text">Bank A/C</span>
                <select v-model="accountingTransaction.chartOfAccountOid" class="form-select">
                  <option v-bind:value="0">--select--</option>
                  <option v-for="b in bankAccounts" >{{b.accountName}}</option>
                </select>
              </div>
            </div>
            <div class="col" >
              <div class="input-group input-group-sm mb-3">
                <span class="input-group-text">Check Date</span>
                <input type="date" v-model="accountingTransaction.checkDate" class="form-control">
              </div>
            </div>
            <div class="col" >
              <div class="input-group input-group-sm mb-3">
                <span class="input-group-text">Check No.</span>
                <input v-model="accountingTransaction.checkNo" type="text" class="form-control">
              </div>
            </div>
          </div>
          <div v-show="accountingTransaction.voucherType === 5 || accountingTransaction.voucherType === 6"
               class="row" >
            <div class="col" >
              <div class="input-group input-group-sm mb-3">
                <span class="input-group-text">Account</span>
                <select v-model="accountingTransaction.chartOfAccountOid" class="form-select">
                  <option v-bind:value="0">--select--</option>
                  <option v-for="c in chartOfAccounts" >{{c.accountName}}</option>
                </select>
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
            <tr  v-for="(t,i) in accountingTransactions" >
              <td>{{i+1}}</td>
              <td>
                <select v-model="t.chartOfAccountOid" class="form-select">
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
                <textarea class="form-control" ></textarea>
              </td>
            </tr>
            <tr>
              <td colspan="2" >
                <button class="btn btn-success" >Save</button>
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
      isNetworkOpStarted: false,
      cookieUserInfo : "",
      modalState : "close",
      dataBsDismiss : "",
      wasValidated : "",
      response : {
        code : 0,
        msg : "",
        init : 0
      },
      chartOfAccounts : [],
      bankAccounts : [],
      accountingTransaction : {
        accountName : "",
        voucherDate : "",
        voucherType : 0,
        voucherNo : "",
        checkNo : "",
        checkDate : "",
        chartOfAccountOid : 0
      },
      accountingTransactions : [
        {
          amt : 0,
          chartOfAccountOid : 0
        }
      ]
    }
  },
  methods : {
    addOrRemoveAccountingTransaction(flag){
      if(flag === 1){
        this.accountingTransactions.push({
          amt : 0,
          chartOfAccountOid : 0
        });
      }else {
        this.accountingTransactions.pop();
      }
    },
    onResetResponse(init){
      this.response.code = 0;
      this.response.msg = "";
      this.response.init = init;
    },
    getInitialData(){
      this.onResetResponse(1);
      this.isNetworkOpStarted = true;
      this.$axios.$post('/ais-entry/view-init',{
        userInfo : {
          email : this.cookieUserInfo.email,
          sessionId: this.cookieUserInfo.sessionId,
          href : window.location.pathname
        }
      }).then(res=>{
        this.isNetworkOpStarted = false;
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

      }).catch(err=>{
        this.isNetworkOpStarted = false;
        this.response.code = 404;
        this.response.msg = "Something went wrong, please try again!";
      }).finally(end=>{
        this.isNetworkOpStarted = false;
      });
    },
  }
}
</script>

<style scoped>

</style>
