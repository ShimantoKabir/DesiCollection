<template>
  <div class="my-template" >
    <AppHeader/>
    <div class="container-fluid">
      <div class="row">
        <AppSidebar/>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 my-main">
          <div v-show="response.code !== 200 && response.init === 1" class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>
              <span v-if="isNetworkOpStarted" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              <span v-else >ERROR!</span>
            </strong>
            &nbsp;
            <span v-if="isNetworkOpStarted" >Loading...</span>
            <span v-else >{{response.msg}}</span>
            <button v-on:click="onResetResponse" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
          </div>
          <tree :data="menus"
                ref="tree"
                :options="treeOptions"
                @node:selected="onNodeSelected">
          </tree>
        </main>
      </div>
    </div>
  </div>
</template>

<script>

    export default {
        name: "manage",
        mounted(){
            this.cookieUserInfo = this.$cookies.get('userInfo');
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
                menus : this.makeMenuTree(this.$store.state.menus,0),
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
            makeMenuTree(menuList,parentTreeId){

                let  tree = [];

                for (let i = 0; i < menuList.length; i++) {

                    if(menuList[i].parentTreeId === parentTreeId) {

                        let children = this.makeMenuTree(menuList, menuList[i].treeId);

                        if(children.length > 0) {

                            menuList[i].children = children;

                        }

                        menuList[i].text = menuList[i].menuName;
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
            }
        }
    }
</script>

<style scoped>

</style>
