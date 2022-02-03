<template>
  <div class="content-wrapper">
    <div class="row">
      <div class="col-12 mb-primary">
        
        <div class="card card-with-shadow border-0 h-100">
          <div class="card-header p-primary bg-transparent">
            <h5 class="card-title m-0 float-left">Entered Reading</h5>
            <a class=" card-title btn btn-info float-right rounded-pill" :href="'/edit-reading/'+water_reading.id">Edit</a>
          </div>
          <div class="card-body align-items-center">
            <div class="align-items-center">
              <p><span>House Lot</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>{{ house_lot.house_lot_num }}</span> </p>
            </div>
            <div class="align-items-center">
              <p><span>Branch</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>{{ branch.name }}</span> </p>
            </div>
            <div class="align-items-center">
              <p><span>S/N</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>{{ water_reading.serial_num }}</span> </p>
            </div>
            <div class="align-items-center">
              <p><span>Curr. Reading</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>{{ water_reading.current_reading }}</span> </p>
            </div>
            <div class="align-items-center">
              <p><span>Last Reading</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>{{ water_reading.last_reading }}</span> </p>
            </div>
            <div class="align-items-center">
              <p><span>Date Submitted</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>{{ water_reading.last_reading ? water_reading.last_reading :'-' }}</span> </p>
            </div>
            <div class="align-items-center">
              <p><span>Image</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <img :src="base_url+'/storage/images/meter_readings/'+water_reading.image" alt="" height="250" width="250">
              </p>
            </div>
            <div class="align-items-center">
              <p><span>Remark</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>{{ water_reading.remark ? water_reading.remark :'N/A' }}</span> </p>
            </div>
            
           
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { FormMixin } from "../../../../../core/mixins/form/FormMixin";
export default {
  name: "CreateReading",
  props: {
    house_lot: {
      type: Object ,
      required: true,
    },
    branch: {
      type: Object ,
      required: true,
    },
    water_reading: {
      type: Object ,
      required: true,
    }
  },
  mixins: [FormMixin],
  components: {},
  data() {
    return {
      base_url:''
    };
  },
  methods: {
    
  },
  created() {
    this.base_url = window.location.origin;
  },
};
</script>