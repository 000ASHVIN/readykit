<template>
  <div class="content-wrapper">
    <div class="row">
      <div class="col-12 mb-primary">
        <div class="card card-with-shadow border-0 h-100">
          <div class="card-header p-primary bg-transparent">
            <h5 class="card-title m-0">Create House Lot</h5>
          </div>
          <div class="card-body">
            <form class="mb-0">
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
                <a @click="createHouseLot" class="btn btn-primary mr-2">
                  Add House Lot
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
import { FormMixin } from "../../../../../core/mixins/form/FormMixin";
export default {
  name: "CreateHouseLot",
  mixins: [FormMixin],
  components: {},
  data() {
    return {
        id:'',
        serial_no:'',
        house_lot_no:'',
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
      checkValidation(){
        let is_error = false;
        if(this.house_lot_no == "" && !this.house_lot_no){
          is_error = true;
          this.error.house_lot_no = "Name is required";
        }
        if(this.serial_no == "" && !this.serial_no){
          is_error = true;
          this.error.serial_no = "Name is required";
        }
        return is_error;
      },
      async createHouseLot(){
        this.clearErrors();
        if(this.checkValidation()){
          return false;
        }
        let url = "/admin/houselots/create",
        payload = {
        serial_no : this.serial_no,
        house_lot_no : this.house_lot_no,
        }
        this.axiosPost({url,data:payload})
        .then((response) => {
          if(response.data){
              this.$alert("House Lot created !!");
              window.location.replace('/admin/houselots');
          }
          else{
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
      }
  },
};
</script>