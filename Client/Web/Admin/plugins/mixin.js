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
      headers : { 'Content-Type': 'multipart/form-data' },
      opState: {
        CREATE: 4,
        READ: 5,
        UPDATE: 6,
        DELETE: 7,
        ASK: 8,
        WARNING: 9,
        OTHER: 10
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
    delete(ctx, event) {
      ctx.$refs.alert.modify({
        isVisible: true,
        needHeader: true,
        needFooter: true,
        alertOpState: this.opState.ASK,
        bodyMsg: "Are you sure want to delete?",
        eventData: event,
        autoDismiss: false
      });
    },
    b64toBlob(dataURI) {
      let byteString;

      if (dataURI.split(',')[0].indexOf('base64') >= 0){
        byteString = atob(dataURI.split(',')[1]);
      } else{
        byteString = decodeURIComponent(dataURI.split(',')[1]);
      }

      let mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];

      let ia = new Uint8Array(byteString.length);
      for (let i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
      }

      return new Blob([ia], {type:mimeString});
    },
    formatDate(date,subtractDay=0){
      let month = date.getMonth() + 1;
      let day = date.getDate() - subtractDay;
      return date.getFullYear()+"-"+month.toString().padStart(2,"0")+"-"+day.toString().padStart(2,"0");
    }
  }
}

Vue.mixin(mixin)
