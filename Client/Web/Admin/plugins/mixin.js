import Vue from 'vue'
import NetworkState from "../enums/NetworkState";

let mixin = {
  mounted() {
    this.cookieUserInfo = this.$cookies.get('userInfo');
  },
  data() {
    return {
      networkState: NetworkState.NetworkState,
      cookieUserInfo: "",
      formClassNames: ["needs-validation"],
      showValidation: false,
      opState: {
        CREATE: 1,
        READ: 2,
        UPDATE: 3,
        DELETE: 4
      }
    }
  },
  methods: {
    getAuthInfo() {
      return {
        email: this.cookieUserInfo.email,
        sessionId: this.cookieUserInfo.sessionId,
        href: window.location.pathname
      }
    },
    showLoader(ctx) {
      ctx.$refs.alert.modify({
        isVisible: true,
        opState: this.networkState.LOADING,
      });
    },
    showSuccess(ctx, msg) {
      ctx.$refs.alert.modify({
        isVisible: true,
        needHeader: true,
        needFooter: false,
        opState: this.networkState.SUCCESS,
        bodyMsg: msg,
        autoDismiss: true
      });
    },
    showError(ctx, event) {
      ctx.$refs.alert.modify({
        isVisible: true,
        needHeader: true,
        needFooter: true,
        opState: this.networkState.ERROR,
        bodyMsg: "Something went wrong please try again!",
        eventData: event
      });
    }
  }
}

Vue.mixin(mixin)
