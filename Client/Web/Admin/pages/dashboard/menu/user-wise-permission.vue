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
            <h1 class="h2">User Wise Permission</h1>
          </div>
          <div class="row">
            <div class="col">
              <select
                class="form-select"
                v-model="userInfo.id"
                v-on:change="onUserChange">
                <option :value="undefined">--select--</option>
                <option v-for="u in userInfos" :value="u.id" >{{u.email}}</option>
              </select>
            </div>
            <div class="col">
              <div class="row">
                <div class="col-auto me-auto">
                  <button class="btn btn-outline-dark" v-on:click="onReset" >Reset</button>
                </div>
                <div class="col-auto">
                  <button v-on:click="verifyInput('create')" class="btn btn-success" >Save</button>
                </div>
              </div>
              <hr/>
              <br/>
              <tree :data="menus"
                    ref="tree"
                    :options="treeOptions">
              </tree>
            </div>
          </div>
        </main>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
        name: "user-wise-permission",
        mounted(){
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
                userInfos : [],
                restrictedMenuOidList : [],
                userInfo: {
                  id : undefined,
                  email : undefined,
                  roleOid : undefined
                },
                menus : this.makeMenuTree(this.$store.state.menus,0),
                response : {
                    code : 0,
                    msg : "",
                    init : 0
                },
                treeOptions: {
                    checkbox: true
                }
            }
        },
        methods : {
            onUserChange(){
                let u = this.userInfos.find(x=>x.id === this.userInfo.id);
                this.userInfo.roleOid = u.roleOid;

                this.onResetResponse(1);
                this.isNetworkOpStarted = true;
                this.$axios.$post('/user-wise-permissions/permitted-menus',{
                    exUserInfo : this.userInfo,
                    userInfo : {
                        email : this.cookieUserInfo.email,
                        sessionId: this.cookieUserInfo.sessionId,
                        href : window.location.pathname
                    }
                }).then(res=>{

                  this.isNetworkOpStarted = false;
                  this.response.code = res.code;
                  this.response.msg = res.msg;

                  let allSelection = this.$refs.tree.findAll({data : { menuFor: "admin"}},true);
                  allSelection.uncheck();
                  allSelection.disable();

                  res.menus.forEach(m=>{
                    let selection = this.$refs.tree.find({data: { oid : m.oid}});
                    selection.enable();
                    selection.check();
                  });

                  res.restrictedMenuOidList.forEach((oid=>{
                    let selection = this.$refs.tree.find({data: { oid : parseInt(oid)}});
                    selection.uncheck();
                  }));

                }).catch(err=>{
                    this.isNetworkOpStarted = false;
                    this.response.code = 404;
                    this.response.msg = "Something went wrong, please try again!";
                }).finally(end=>{
                    this.isNetworkOpStarted = false;
                });
            },
            onReset(){


            },
            verifyInput(which){
              this.restrictedMenuOidList = [];
              this.$store.state.menus.forEach(m=>{
                let selection = this.$refs.tree.find({
                  data: {
                    oid : m.oid,
                    hasChildren : false
                  },
                  state : {
                    disabled : false,
                    checked: false
                  }
                });
                selection.forEach(item=>{
                  this.restrictedMenuOidList.push(item.data.oid);
                });
              });

              this.onResetResponse(1);
              this.isNetworkOpStarted = true;
              this.$axios.$put('/user-wise-permissions/'+this.userInfo.id,{
                restrictedMenuOidList : this.restrictedMenuOidList,
                userInfo : {
                  email : this.cookieUserInfo.email,
                  sessionId: this.cookieUserInfo.sessionId,
                  href : window.location.pathname
                }
              }).then(res=>{
                this.isNetworkOpStarted = false;
                this.response.code = res.code;
                this.response.msg = res.msg;
              }).catch(err=>{
                this.isNetworkOpStarted = false;
                this.response.code = 404;
                this.response.msg = "Something went wrong, please try again!";
              }).finally(end=>{
                this.isNetworkOpStarted = false;
              });

            },
            onResetResponse(init){
                this.response.code = 0;
                this.response.msg = "";
                this.response.init = init;
            },
            getInitialData(){
                this.onResetResponse(1);
                this.isNetworkOpStarted = true;
                this.$axios.$post('/user-wise-permissions/view-init',{
                    userInfo : {
                        email : this.cookieUserInfo.email,
                        sessionId: this.cookieUserInfo.sessionId,
                        href : window.location.pathname
                    }
                }).then(res=>{
                    this.isNetworkOpStarted = false;
                    this.response.code = res.code;
                    this.response.msg = res.msg;
                    if(res.code === 200){
                        this.userInfos = res.userInfos;
                    }
                }).catch(err=>{
                    this.isNetworkOpStarted = false;
                    this.response.code = 404;
                    this.response.msg = "Something went wrong, please try again!";
                }).finally(end=>{
                    this.isNetworkOpStarted = false;
                });
            },
            makeMenuTree(menuList,parentTreeId){
                let  tree = [];
                for (let i = 0; i < menuList.length; i++) {
                    if(menuList[i].parentTreeId === parentTreeId) {
                        let children = this.makeMenuTree(menuList, menuList[i].treeId);
                        if(children.length > 0) {
                            menuList[i].children = children;
                        }
                        menuList[i].text = menuList[i].menuName;
                        menuList[i].data = {
                            oid : menuList[i].oid,
                            roleOid : menuList[i].roleOid,
                            menuFor : "admin",
                            hasChildren : children.length > 0
                        };
                        menuList[i].state = {
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
                        tree.push(menuList[i]);
                    }
                }
                return tree
            },
        }
    }
</script>

<style scoped>

</style>
