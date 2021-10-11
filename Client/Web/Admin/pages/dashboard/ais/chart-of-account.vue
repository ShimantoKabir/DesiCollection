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
            <h1 class="h2">Chart Of Accounts</h1>
          </div>
          <div class="row">
            <div class="col">
              <tree :data="chartOfAccounts"
                    ref="tree"
                    :options="treeOptions"
                    @node:selected="onNodeSelected">
                <span class="tree-text" slot-scope="{ node }">
                    <template  >
                      <i v-if="node.data.isLedger" style="color: darkolivegreen;" class="fas fa-award"></i>
                      <i v-else style="color: darkgoldenrod;" class="fas fa-bolt"></i>
                      &nbsp;
                      {{ node.text }}
                    </template>
                </span>
              </tree>
            </div>
            <div class="col">
            </div>
          </div>

        </main>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "chart-of-account",
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
      treeOptions: {
        dnd: true
      },
    }
  },
  methods : {
    onResetResponse(init){
      this.response.code = 0;
      this.response.msg = "";
      this.response.init = init;
    },
    getInitialData(){
      this.onResetResponse(1);
      this.isNetworkOpStarted = true;
      this.$axios.$post('/chart-of-account/view-init',{
        userInfo : {
          email : this.cookieUserInfo.email,
          sessionId: this.cookieUserInfo.sessionId,
          href : window.location.pathname
        }
      }).then(res=>{
        this.isNetworkOpStarted = false;
        this.response.code = res.code;
        this.response.msg = res.msg;

        this.chartOfAccounts = res.chartOfAccounts;
        this.$refs.tree.setModel(this.makeChartOfAccountTree(this.chartOfAccounts,0));

      }).catch(err=>{
        this.isNetworkOpStarted = false;
        this.response.code = 404;
        this.response.msg = "Something went wrong, please try again!";
      }).finally(end=>{
        this.isNetworkOpStarted = false;
      });
    },
    onNodeSelected(node){
      console.log("node = ",node);
    },
    makeChartOfAccountTree(chartOfAccountList,parentTreeId){
      let  tree = [];
      for (let i = 0; i < chartOfAccountList.length; i++) {
        if(chartOfAccountList[i].parentTreeId === parentTreeId) {
          let children = this.makeChartOfAccountTree(chartOfAccountList, chartOfAccountList[i].treeId);
          if(children.length > 0) {

            chartOfAccountList[i].children = children;

          }
          chartOfAccountList[i].text = chartOfAccountList[i].accountName;
          chartOfAccountList[i].data = {
            id : chartOfAccountList[i].id,
            oid : chartOfAccountList[i].oid,
            path : chartOfAccountList[i].path,
            orgId : chartOfAccountList[i].orgId,
            isLedger : chartOfAccountList[i].isLedger
          };
          chartOfAccountList[i].state = {
            selected : false,
            selectable : true,
            checked : false,
            expanded : true,
            disabled : false,
            visible : true,
            indeterminate : false,
            matched : false,
            editable : true,
            dragging : false,
            draggable : true,
            dropable : true
          };
          tree.push(chartOfAccountList[i]);
        }
      }
      return tree;
    },
  }
}
</script>

<style scoped>

</style>
