<template>
  <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="position-sticky pt-3">
    <div class="flex-shrink-0 p-3">
      <ul :key="i" v-for="(m,i) in menus" class="list-unstyled ps-0">
        <li class="mb-1">
          <button class="btn btn-toggle align-items-center rounded collapsed"
                  data-bs-toggle="collapse"
                  :data-bs-target="'#menuCollapse'+i"
                  aria-expanded="true">
            {{m.menuName}}
          </button>
          <div class="collapse show" :id="'menuCollapse'+i">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              <li v-for="c in m.children" v-on:click="navigateTo(c.href)" >
                <a class="link-dark rounded cp">
                  {{c.menuName}}
                </a>
              </li>
            </ul>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>
</template>

<script>
    export default {
        name: "AppSidebar",
        mounted() {
            this.menus = this.makeMenuTree(this.$store.state.menus,0);
        },
        data(){
            return{
                menus : []
            }
        },
        methods:{
            navigateTo(path){
              console.log(path);
                this.$router.push({path: path});
            },
            makeMenuTree(menuList,parentTreeId){

                let  tree = [];

                for (let i = 0; i < menuList.length; i++) {

                    if(menuList[i].parentTreeId === parentTreeId) {

                        let children = this.makeMenuTree(menuList, menuList[i].treeId);

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
  .sidebar {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 100;
    padding: 48px 0 0;
    height: 100vh;
    overflow-y: auto;
    box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
  }

  @media (max-width: 767.98px) {
    .sidebar {
      top: 5rem;
    }
  }
  .sidebar .nav-link {
    font-weight: 500;
    color: #333;
  }

  .sidebar .nav-link {
    margin-right: 4px;
    color: #727272;
  }

  .sidebar {
    color: #2470dc;
  }

  .sidebar {
    color: inherit;
  }

  .btn-toggle {
    display: inline-flex;
    align-items: center;
    padding: .25rem .5rem;
    font-weight: 600;
    color: rgba(0, 0, 0, .65);
    background-color: transparent;
    border: 0;
  }
  .btn-toggle:hover,
  .btn-toggle:focus {
    color: rgba(0, 0, 0, .85);
    background-color: #d2f4ea;
  }

  .btn-toggle::before {
    width: 1.25em;
    line-height: 0;
    content: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='rgba%280,0,0,.5%29' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 14l6-6-6-6'/%3e%3c/svg%3e");
    transition: transform .35s ease;
    transform-origin: .5em 50%;
  }

  .btn-toggle[aria-expanded="true"] {
    color: rgba(0, 0, 0, .85);
  }
  .btn-toggle[aria-expanded="true"]::before {
    transform: rotate(90deg);
  }

  .btn-toggle-nav a {
    display: inline-flex;
    padding: .1875rem .5rem;
    margin-top: .125rem;
    margin-left: 1.25rem;
    text-decoration: none;
  }
  .btn-toggle-nav a:hover,
  .btn-toggle-nav a:focus {
    background-color: #d2f4ea;
  }
</style>
