<template>
  <div class="content-wrapper">
    <div class="row">
      <div class="col-12 mb-primary">
        <div class="card card-with-shadow border-0 h-100">
          <div class="card-header p-primary bg-transparent">
            <h5 class="card-title m-0">Edit House Lot</h5>
          </div>
          <div class="card-body">
            <form class="mb-0">
              <div class="form-group row align-items-center">
                <label class="col-md-2 mb-md-0"> Branch </label>
                <div class="col-md-8">
                  <select
                    id="inputs_status"
                    class="custom-select"
                    :style='
                      "background-image: url("+dropDownImage+");"
                    '
                    v-model="branch_id"
                  >
                    <option value="">Select Branch</option>
                    <option :value="branch.id" v-for="branch in branches" :key="branch.id" :selected="branch.id == branch_id"> {{ branch.name }}</option>
                  </select>
                  <div>
                    <small class="text-danger validation-error" v-if="this.error.branch">
                      {{ this.error.branch }}
                    </small>
                  </div>
                </div>
              </div>

              <div class="form-group row align-items-center">
                <label class="col-md-2 mb-md-0"> Serial No </label>
                <div class="col-md-8">
                  <input
                    type="text"
                    name="inputs_name"
                    id="inputs_name"
                    placeholder="Type Serial number"
                    autocomplete="off"
                    class="form-control"
                    v-model="serial_no"
                  />
                  <div>
                    <small class="text-danger validation-error" v-if="this.error.serial_no">
                      {{ this.error.serial_no }}
                    </small>
                  </div>
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-2 mb-md-0"> House Lot No </label>
                <div class="col-md-8">
                  <input
                    type="text"
                    name="inputs_name"
                    id="inputs_name"
                    placeholder="Type house lot number"
                    autocomplete="off"
                    class="form-control"
                    v-model="house_lot_no"
                  />
                  <div>
                    <small class="text-danger validation-error" v-if="this.error.house_lot_no">
                      {{ this.error.house_lot_no }}
                    </small>
                  </div>
                </div>
              </div>
              <div class="mt-5 action-buttons">
                <a @click="updateHouseLot" class="btn btn-primary mr-2">
                  Update House Lot
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { WindowScrollController } from '@fullcalendar/common';
import { FormMixin } from "../../../../../core/mixins/form/FormMixin";
export default {
  name: "EditHouseLot",
  mixins: [FormMixin],
  props: {
    houselot: {
      type: Object,
      required: true
    }
  },
  components: {},
  data() {
    return {
        id:'',
        serial_no:'',
        house_lot_no:'',
        branch_id: '',
        branches: [],
        dropDownImage: '',
        error:{
          serial_no:'',
          house_lot_no:''
        }
    };
  },
  methods: {
      clearErrors(){
        this.error.serial_no ='';
        this.error.house_lot_no ='';
      },
      setHouseLot(){
          this.id=this.houselot.id;
          this.serial_no=this.houselot.serial_num;
          this.house_lot_no=this.houselot.house_lot_num;
          this.branch_id = this.houselot.branch_id;
      },
      checkValidation(){
        let is_error = false;
        if(this.serial_no == "" && !this.serial_no){
          is_error = true;
          this.error.serial_no = "Serial Number is required";
        }
        if(this.house_lot_no == "" && !this.house_lot_no){
          is_error = true;
          this.error.house_lot_no = "House Lot Number is required";
        }
        return is_error;
      },
      async updateHouseLot(){
        this.clearErrors();
        if(this.checkValidation()){
          return false;
        }
        let url = "/admin/houselots/"+this.id+"/update",payload = {
        serial_no:this.serial_no,
        house_lot_no:this.house_lot_no,
        branch: this.branch_id
        }
        this.axiosPost({url,data:payload})
        .then((response) => {
          if(response.data == true){
              this.$alert("House Lot Updated !!");
              window.location.replace('/admin/houselots');
          }
          if(response.data == 'error'){
              // this.$alert("House Lot created !!");
              window.location.replace(window.location.href);
          }
          if(response.data == false){
              this.$alert("There's Problem creating House Lot !!");
          }
        })
        .catch(({ response }) => {
          if(response.status == 422 ){
            if(response.data.errors.serial_no){
              this.$toastr.e(response.data.errors.serial_no);
            }
            if(response.data.errors.house_lot_no){
              this.$toastr.e(response.data.errors.house_lot_no);
            }
          }
        });
      },
      async getBranches(){
        await this.axiosGet("/admin/get-branches-for-form")
        .then((response) => {
          this.branches = response.data;
        })
        .catch(({error}) => {
          console.log(error);
        });
      },
  },
  created() {
      this.dropDownImage = window.location.origin+'/images/chevron-down.svg'; 
      this.getBranches();
      this.setHouseLot();
  },
};
</script>