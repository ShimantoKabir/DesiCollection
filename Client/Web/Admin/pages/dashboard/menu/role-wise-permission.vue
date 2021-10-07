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
            <h1 class="h2">Role Wise Permission</h1>
          </div>
          <div class="row">
            <div class="col">
              <select
                class="form-select"
                v-model="role.oid"
                v-on:change="onRoleChange">
                <option :value="0">--select--</option>
                <option v-for="r in roles" :value="r.oid" >{{r.roleName}}</option>
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
                    :options="treeOptions"
                    @node:selected="onNodeSelected">
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
        name: "role-wise-permission",
        mounted(){
            this.cookieUserInfo = this.$cookies.get('userInfo');
            this.getInitialData();
        },
        data(){
            return{
                isNetworkOpStarted: false,
                cookieUserInfo : "",
                isTreeHaveCheckbox : false,
                modalState : "close",
                dataBsDismiss : "",
                wasValidated : "",
                roles : [],
                role : {
                  oid : 0,
                },
                response : {
                    code : 0,
                    msg : "",
                    init : 0
                },
                menus : this.makeMenuTree(this.$store.state.menus,0),
                treeOptions: {
                    checkbox: true
                },
            }
        },
        methods : {
            onReset(){
                this.role.oid = 0;
                let allSelection = this.$refs.tree.findAll({data : { menuFor: "admin"}},true);
                allSelection.uncheck();
                this.onResetResponse();
            },
            verifyInput(which){
                if(which === "create"){
                    let allSelection = this.$refs.tree.findAll({
                        data : { menuFor: "admin"},
                        state : {checked: true}
                    },true);

                    if(this.role.oid === 0){

                        this.response.init = 1;
                        this.response.msg = "Please select a role!";
                        this.response.code = 404;

                    }else if(allSelection.length === 0){
                        this.response.init = 1;
                        this.response.msg = "Please check at least one menu!";
                        this.response.code = 404;
                    }else {
                        this.onCreate();
                    }
                }
            },
            onResetResponse(init){
                this.response.code = 0;
                this.response.msg = "";
                this.response.init = init;
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
                            menuFor : "admin"
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
            onNodeSelected(node){
                console.log("node = ",node);
            },
            getInitialData(){
                this.onResetResponse(1);
                this.isNetworkOpStarted = true;
                this.$axios.$post('/roles/view-init',{
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
                        this.roles = res.roles;
                    }
                }).catch(err=>{
                    this.isNetworkOpStarted = false;
                    this.response.code = 404;
                    this.response.msg = "Something went wrong, please try again!";
                }).finally(end=>{
                    this.isNetworkOpStarted = false;
                });
            },
            onRoleChange(){
                this.onResetResponse(1);
                this.isNetworkOpStarted = true;
                this.$axios.$post('/menu-permission-for-roles/permitted-menus',{
                    menuPermissionForRole : {
                        roleOid : this.role.oid
                    },
                    userInfo : {
                        email : this.cookieUserInfo.email,
                        sessionId: this.cookieUserInfo.sessionId,
                        href : window.location.pathname
                    }
                }).then(res=>{
                    this.isNetworkOpStarted = false;
                    this.response.code = res.code;
                    this.response.msg = res.msg;
                    console.log(res.menus.length);
                    let allSelection = this.$refs.tree.findAll({data : { menuFor: "admin"}},true);
                    allSelection.uncheck();

                    res.menus.forEach(m=>{
                        let selection = this.$refs.tree.find({data: { oid : m.oid }});
                        selection.check(true);
                    });

                }).catch(err=>{
                    this.isNetworkOpStarted = false;
                    this.response.code = 404;
                    this.response.msg = "Something went wrong, please try again!";
                }).finally(end=>{
                    this.isNetworkOpStarted = false;
                });
            },
            onCreate(){

                let menuPermissionForRoles = [];

                let allSelection = this.$refs.tree.findAll({
                    data : { menuFor: "admin"},
                    state : {checked: true}
                },true);

                allSelection.forEach(m=>{
                    menuPermissionForRoles.push({
                        roleOid : this.role.oid,
                        menuOid: m.data.oid
                    });
                });

                this.onResetResponse(1);
                this.isNetworkOpStarted = true;
                this.$axios.$post('/menu-permission-for-roles',{
                    menuPermissionForRoles : menuPermissionForRoles,
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

            }
        }
    }
</script>

<style scoped>

</style>
