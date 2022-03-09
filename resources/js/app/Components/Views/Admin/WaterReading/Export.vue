<template>
  <div class="col-sm-12 col-md-8">
   
    <div class="breadcrumb-side-button">
      <div class="float-md-right mb-3 mb-sm-3 mb-md-0 ml-3">
        <a class="btn btn-primary btn-with-shadow" href="/admin/get-all-export-data">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="25"
            height="25"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="feather feather-download"
          >
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
            <polyline points="7 10 12 15 17 10"></polyline>
            <line x1="12" y1="15" x2="12" y2="3"></line>
          </svg>
          Export Alll Data
        </a>
      </div>
       <div class="breadcrumb-side-button">
      <div class="float-md-right mb-3 mb-sm-3 mb-md-0 ">
        <button class="btn btn-primary btn-with-shadow" @click="download">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="25"
            height="25"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="feather feather-download"
          >
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
            <polyline points="7 10 12 15 17 10"></polyline>
            <line x1="12" y1="15" x2="12" y2="3"></line>
          </svg>
          Export By Date
        </button>
      </div>
    </div>
    </div>
    <date-range-picker
      ref="picker"
      :opens="opens"
      :showWeekNumbers="showWeekNumbers"
      :showDropdowns="showDropdowns"
      :autoApply="autoApply"
      :date-range="dateRange"
      @update="updateValues"
      @toggle="logEvent('event: open', $event)"
      @start-selection="logEvent('event: startSelection', $event)"
      @finish-selection="logEvent('event: finishSelection', $event)"
      :class="'float-md-right mr-3 mb-3 mb-sm-3 mb-md-0'"
    >
      <template v-slot:input="picker" style="min-width: 350px">
        {{ fromdateFormatLocal(picker.startDate) | date }} -
        {{ enddateFormatLocal(picker.endDate) | date }}
      </template>
    </date-range-picker>
  </div>
</template>

<script>
import DateRangePicker from "vue2-daterange-picker";
import "vue2-daterange-picker/dist/vue2-daterange-picker.css";
import { dateFormat } from "./dateFormat.js";

export default {
  components: { DateRangePicker },
  props: {
    branch_id: ''
  },
  data() {
    return {
      opens: "left",
      showWeekNumbers: false,
      timePicker: false,
      autoApply: false,
      showDropdowns: false,
      dateRange: {
        startDate: new Date(),
        endDate: new Date(),
      },
      newdateRange: {
        startDate: null,
        endDate: null,
      },
    };
  },
  methods: {
    updateValues() {},
    logEvent(message, event) {},
    fromdateFormatLocal(date) {
      this.newdateRange.startDate = dateFormat(date, "mmmm dd yyyy");
      return this.newdateRange.startDate;
    },
    enddateFormatLocal(date) {
      this.newdateRange.endDate = dateFormat(date, "mmmm dd yyyy");
      return this.newdateRange.endDate;
    },
    dateLoLocalString(date) {
      return date.toLocaleDateString("en-US");
    },
    download() {
      let self = this;
      let form = {
        startDate: self.newdateRange.startDate,
        endDate: self.newdateRange.endDate,
      };
      axios({
        method: 'post',
        url:'/admin/water_readings/branch/export/'+this.branch_id,
        responseType:'arraybuffer',
        data:form
      }).then(function(response){
          //  console.log(form);
        let blob = new Blob([response.data], {})
        let link = document.createElement('a')
        link.href = window.URL.createObjectURL(blob)
        link.download = 'Water_readings.xlsx'
        link.click()

      }).catch(function(response){
        console.log(response);  
      });
      

    }
  },
};
</script>

<style scoped>
</style>