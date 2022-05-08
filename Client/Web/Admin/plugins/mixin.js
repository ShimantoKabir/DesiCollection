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
        CREATE: 4,
        READ: 5,
        UPDATE: 6,
        DELETE: 7,
        ASK : 8,
        WARNING : 9
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
        alertOpState: this.networkState.LOADING,
      });
    },
    showSuccess(ctx, msg) {
      ctx.$refs.alert.modify({
        isVisible: true,
        needHeader: true,
        needFooter: false,
        alertOpState: this.networkState.SUCCESS,
        bodyMsg: msg,
        autoDismiss: true
      });
    },
    showError(ctx, event) {
      ctx.$refs.alert.modify({
        isVisible: true,
        needHeader: true,
        needFooter: true,
        alertOpState: this.networkState.ERROR,
        bodyMsg: "Something went wrong please try again!",
        eventData: event,
        autoDismiss: true
      });
    },
    showErrorMsg(ctx, event, msg) {
      ctx.$refs.alert.modify({
        isVisible: true,
        needHeader: true,
        needFooter: true,
        alertOpState: this.networkState.ERROR,
        bodyMsg: msg,
        eventData: event,
        autoDismiss: true
      });
    },
    delete(ctx, event){
      ctx.$refs.alert.modify({
        isVisible: true,
        needHeader: true,
        needFooter: true,
        alertOpState: this.opState.ASK,
        bodyMsg: "Are you sure want to delete?",
        eventData: event,
        autoDismiss: false
      });
    }
  }
}

Vue.mixin(mixin)
