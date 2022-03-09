<template>
  <div class="content-wrapper">
    <div class="row">
      <div class="col-12 mb-primary">
        
        <div class="card card-with-shadow border-0 h-100">
          <div class="card-header p-primary bg-transparent">
            <h5 class="card-title m-0 float-left">Entered Reading</h5>
            <a class=" card-title btn btn-info float-right rounded-pill" :href="'/edit-reading/'+water_reading.id">Edit</a>
          </div>
          <div class="card-body align-items-center col-md-12">
            <div class="align-items-center row">
              <div class="col-2">
                <p><strong>House Lot:</strong></p>
              </div>
              <div class="col-10">
                <p>{{ house_lot.house_lot_num }}</p>
              </div>
            </div>
            <div class="align-items-center row">
              <div class="col-2">
                <p><strong>Branch:</strong></p>
              </div>
              <div class="col-10">
                <p>{{ branch.name }}</p>
              </div>
            </div>
            <div class="align-items-center row">
              <div class="col-2">
                <p><strong>S/N:</strong></p>
              </div>
              <div class="col-10">
                <p>{{ water_reading.serial_num }}</p>
              </div>
            </div>
            <div class="align-items-center row">
              <div class="col-2">
                <p><strong>Curr. Reading:</strong></p>
              </div>
              <div class="col-10">
                <p>{{ water_reading.current_reading }}</p>
              </div>
              
            </div>
            <div class="align-items-center row">
              <div class="col-2">
                <p><strong>Last Reading:</strong></p>
              </div>
              <div class="col-10">
                <p>{{ water_reading.last_reading }}</p>
              </div>
              
            </div>
            <!-- <div class="align-items-center row">
              <p><span class="col-md-6">Date Submitted</span><span class="col-md-6">{{ water_reading.last_reading ? water_reading.last_reading :'-' }}</span> </p>
            </div> -->
            <div class="align-items-center row">
              <div class="col-2">
                <p><strong>Image:</strong></p>
              </div>
              <div class="col-10">
                <img :src="water_reading.image" alt="" style="width: 250px;">
              </div>
            </div>
            <div class="align-items-center row">
              <div class="col-2">
                <p><strong>Remark:</strong></p>
              </div>
              <div class="col-10">
                <p>{{ water_reading.remark ? water_reading.remark :'N/A' }}</p>
              </div>
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