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
          <ul :key="i" v-for="(m,i) in menus" class="list-unstyled ps-0">
            <li class="mb-1">
              <button class="btn btn-toggle align-items-center rounded collapsed"
                      data-bs-toggle="collapse"
                      data-bs-target="#home-collapse"
                      aria-expanded="true">
                {{m.menu_name}}
              </button>
              <div class="collapse show" id="home-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                  <li v-for="c in m.children" v-on:click="navigateTo(c.href)" >
                    <a class="link-dark rounded cp">
                      {{c.menu_name}}
                    </a>
                  </li>
                </ul>
              </div>
            </li>
          </ul>
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
                menus : this.$store.state.menus,
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
                this.$axios.$post('/menus/view-init',{
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
                        // this.menus = this.makeMenuTree(res.menus);
                        // console.log("menus "+this.menus);
                    }
                }).catch(err=>{
                    this.isNetworkOpStarted = false;
                    this.response.code = 404;
                    this.response.msg = "Something went wrong, please try again!";
                }).finally(end=>{
                    this.isNetworkOpStarted = false;
                });
            },
            makeMenuTree(menuList,parent_tree_id){

                let  tree = [];

                for (let i = 0; i < menuList.length; i++) {

                    if(menuList[i].parent_tree_id === parent_tree_id) {

                        let children = this.makeMenuTree(menuList, menuList[i].tree_id);

                        if(children.length > 0) {

                            menuList[i].children = children;

                        }

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
