<template>
  <div v-show="isModelVisible" class="modal open-model my-model">
    <div class="modal-dialog">
      <div class="modal-content">
        <div v-show="isModelHeaderVisible" class="modal-header">
          <h5 v-if="title" class="modal-title">{{title}}</h5>
          <h5 v-else-if="networkState === ns.LOADING" >Loading</h5>
          <h5 v-else-if="networkState === ns.ERROR" >Error</h5>
          <h5 v-else-if="networkState === ns.SUCCESS" >Success</h5>
          <h5 v-else >Unknown</h5>
          <button v-on:click="closeModel"  type="button" class="btn-close"></button>
        </div>
        <div class="modal-body">
          <div v-if="networkState === ns.LOADING" class="my-model-body" >
            <i class="fas fa-spinner fa-spin" ></i>
            <p>Loading, Please wait...!</p>
          </div>
          <div v-else-if="networkState === ns.ERROR" class="my-model-body" >
            <i class="fas fa-times-circle" ></i>
            <p v-if="bodyMsg" >{{bodyMsg}}</p>
            <p v-else >Error, Something went wrong please try again!</p>
          </div>
          <div v-else-if="networkState === ns.SUCCESS" class="my-model-body" >
            <i class="fas fa-check-circle" ></i>
            <p v-if="bodyMsg" >{{bodyMsg}}</p>
            <p v-else >Operation successful!</p>
          </div>
          <div v-else class="my-model-body" >
            <i class="fas fa-blind" ></i>
            <p>Unknown..........!</p>
          </div>
        </div>
        <div v-show="isModelFooterVisible" class="modal-footer">
          <button v-on:click="onNegativeClick" type="button" class="btn btn-secondary">
            <span v-if="negativeBtnTxt" >{{negativeBtnTxt}}</span>
            <span v-else >No</span>
          </button>
          <button v-on:click="onPositiveClick" type="button" class="btn btn-primary">
            <span v-if="positiveBtnTxt" >{{positiveBtnTxt}}</span>
            <span v-else >Yes</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import NetworkState from "./../enums/NetworkState";

export default {
  name: "AlertComponent",
  props: {
    onAlertClose: {
      required: false,
      type: Function,
    },
    onPositiveBtnClick: {
      required: false,
      type: Function
    },
    onNegativeBtnClick: {
      required: false,
      type: Function
    }
  },
  mounted() {

  },
  data(){
    return{
      isModelVisible : false,
      isModelFooterVisible: false,
      isModelHeaderVisible: false,
      positiveBtnTxt : "",
      negativeBtnTxt : "",
      ns: NetworkState.NetworkState,
      networkState : NetworkState.NetworkState.NEUTRAL,
      bodyMsg : "",
      title: "",
      eventData: ""
    }
  },
  methods: {
    modify(obj){
      this.isModelVisible =  (obj.isVisible === true) ? true
        : (obj.isVisible === false) ? false
          : this.isModelVisible;
      this.isModelFooterVisible =  (obj.needFooter === true) ? true
        : (obj.needFooter === false) ? false
          : this.isModelFooterVisible;
      this.isModelHeaderVisible =  (obj.needHeader === true) ? true
        : (obj.needHeader === false) ? false
          : this.isModelHeaderVisible;
      this.positiveBtnTxt  =  (obj.positiveBtnTxt) ? obj.positiveBtnTxt : this.positiveBtnTxt;
      this.negativeBtnTxt  =  (obj.negativeBtnTxt) ? obj.negativeBtnTxt : this.negativeBtnTxt;
      this.networkState  =  (obj.networkState) ? obj.networkState : this.networkState;
      this.bodyMsg  =  (obj.bodyMsg) ? obj.bodyMsg : this.bodyMsg;
      this.title =  (obj.title) ? obj.title : this.title;
      this.eventData =  (obj.eventData) ? obj.eventData : this.eventData;
      if(obj.alertAutoClose){
        let self = this;
        setTimeout(function () {
          self.isModelVisible = false;
        },5000);
      }
    },
    closeModel(){
      this.isModelVisible = false;
      if (this.onAlertClose) {
        this.onAlertClose(this.eventData);
      }
    },
    openModel(){
      this.isModelVisible = true;
    },
    onNegativeClick(){
      this.isModelVisible = false;
      if (this.onNegativeBtnClick) {
        this.onNegativeBtnClick(this.eventData);
      }
    },
    onPositiveClick(){
      this.isModelVisible = false;
      if (this.onPositiveBtnClick) {
        this.onPositiveBtnClick(this.eventData);
      }
    }
  }
}
</script>

<style scoped>
  .my-model{
    background-color: rgba(0,0,0,.2);
    z-index: 1056;
  }
  .open-model{
    display: block;
  }
  .my-model-body{
    display: flex;
    align-items: center;
    justify-content: flex-start;
  }
  .my-model-body > i{
    font-size: 20px;
  }
  .my-model-body > p{
    margin-left: 10px;
    margin-top: revert;
  }
</style>
