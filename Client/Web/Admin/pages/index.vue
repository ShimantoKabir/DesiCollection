<template>
  <div class="main" >
    <form class="container-sm login-form needs-validation" novalidate>
      <div class="mb-3 login-header" >
        <h6>Admin Panel Login</h6>
        <h3>Desi Collection</h3>
      </div>
      <div v-if="response.hasError" class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Error!</strong> {{response.errorMsg}}
        <button v-on:click="onErrorMsgClose" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
      </div>
      <br>
      <div class="mb-3">
        <label for="exampleInputEmail" class="form-label">Email address</label>
        <input v-model="userInfo.email" type="email" class="form-control" id="exampleInputEmail" required>
        <div class="invalid-feedback">
          Please give your email address!
        </div>
        <div class="valid-feedback">
          Looks good!
        </div>
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword" class="form-label">Password</label>
        <input v-model="userInfo.password"
               type="password"
               class="form-control"
               id="exampleInputPassword"
               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
               autocomplete="true" required>
        <div class="form-text">
          Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters.
        </div>
        <div class="invalid-feedback">
          Please give your password and follow the above instruction!
        </div>
        <div class="valid-feedback">
          Looks good!
        </div>
      </div>
      <div class="d-grid gap-2">
        <button v-on:click="verifyInput('login')" type="submit" class="btn btn-primary">
          <span v-if="isNetworkOpStarted" class="spinner-border spinner-border-sm" role="status" aria-hidden="true">
          </span>
          <span v-else>Login</span>
        </button>
      </div>
    </form>
  </div>
</template>

<script>
    export default {
        name: "login",
        mounted() {
            console.log("login");
        },
        data(){
          return{
              userInfo: {
                  email : "",
                  password: ""
              },
              isNetworkOpStarted: false,
              response : {
                  hasError : false,
                  errorMsg : ""
              }
          }
        },
        methods:{
            onErrorMsgClose(){
                this.response.hasError = false;
                this.response.errorMsg = "";
            },
            verifyInput(which){
                if (which === 'login') {
                    console.log(this);
                    let isFormValidate = false;
                    let loginForm = document.querySelectorAll('.needs-validation');
                    loginForm.forEach(function (form) {
                        form.addEventListener('submit', function (event) {
                            isFormValidate++;
                            event.preventDefault();
                            event.stopPropagation();
                            form.classList.add('was-validated');
                        }, false);
                        isFormValidate = form.checkValidity();
                    });

                    if(isFormValidate){
                        this.isNetworkOpStarted = true;
                        this.login();
                    }
                }
            },
            login(){
                this.$axios.$post('/user-info/login',{
                    userInfo : this.userInfo
                }).then(res=>{
                    if(res.code !== 200){
                      this.response.hasError = true;
                      this.response.errorMsg = res.msg;
                    }else {
                        this.response.hasError = false;
                        this.response.errorMsg = "";

                        // localStorage.setItem("userInfo",JSON.stringify(res.userInfo));
                        this.$store.commit("setMenusAndPaths", res.userInfo);
                        this.$cookies.set("userInfo", {
                            email: res.userInfo.email,
                            sessionId : res.userInfo.sessionId
                        });
                        this.$router.push({path: '/dashboard/home'});
                    }
                }).catch(err=>{

                    this.response.hasError = true;
                    this.response.errorMsg = "Something went wrong, please try again!";
                }).finally(end=>{
                    this.isNetworkOpStarted = false;
                });
            }
        }
    }
</script>
<style>
  .main{
    height: 100vh;
    display: flex;
    width: 100%;
    justify-content: center;
    align-items: center;
  }
  .login-form{
    border: 1px solid lightgray;
    padding: 50px;
    max-width: 500px;
    border-radius: 5px;
    margin: 20px;
  }
  .login-header{
    text-align: center;
  }
</style>
