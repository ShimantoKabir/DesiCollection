import Vue from 'vue'
import NetworkState from "../enums/NetworkState";

let mixin = {
  mounted() {
    this.cookieUserInfo = this.$cookies.get('userInfo');
  },
  data() {
    return {
      networkState: NetworkState.NetworkState,
      cookieUserInfo : "",
      formClassNames : ["needs-validation"],
      showValidation : false,
    }
  }
}

Vue.mixin(mixin)
