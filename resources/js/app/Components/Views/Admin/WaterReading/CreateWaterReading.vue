<template>
  <div class="content-wrapper">
    <div class="row">
      <div class="col-12 mb-primary">
        
        <div class="card card-with-shadow border-0 h-100">
          <div class="card-header p-primary bg-transparent">
            <h5 class="card-title m-0">Create Reading</h5>
          </div>
          <div class="card-body">
            <form id="create-reading-form" method="post" action="/admin/water_readings/create" enctype="multipart/form-data" class="mb-0">
              <div class="form-group row align-items-center">
                <label class="col-md-2 mb-md-0"> User </label>
                <div class="col-md-8">
                  <select
                    id="inputs_status"
                    class="custom-select"
                    style="
                      background-image: url('http://127.0.0.1:8000/images/chevron-down.svg');
                    "
                    name="user_id"
                    v-model="selected_user_id"
                    v-on:change="selectUser(selected_user_id)"
                  >
                    <option value="" selected>Select User</option>
                    <option :value="user.id" v-for="user in users" :key="user.id">{{ user.full_name }}</option>
                  </select>
                  <div>
                    <small class="text-danger validation-error" v-if="this.error.user">
                      {{ this.error.user }}
                    </small>
                  </div>
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-2 mb-md-0"> Current Branch </label>
                <div class="col-md-8">
                  <input
                    type="hidden"
                    name="branch_id"
                    :placeholder="branch_data.name"
                    autocomplete="off"
                    class="form-control"
                    :value="branch"
                  />
                  <input
                    type="text"
                    name="branch"
                    :placeholder="(branch_data.name) ? branch_data.name :'{autofill based on selected user.}'"
                    autocomplete="off"
                    class="form-control"
                    disabled
                  />
                  <div>
                    <small
                      class="text-danger validation-error"
                      v-if="this.error.branch"
                    >
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
                    name="serial_num_demo"
                    placeholder="Place meter serial no."
                    autocomplete="off"
                    class="form-control"
                    v-model="serial_no"
                    v-on:change="getHouseLot()"
                  />
                  <input
                    type="hidden"
                    name="serial_num"
                    placeholder="Place meter serial no."
                    autocomplete="off"
                    class="form-control"
                    :value="this.serial_no"
                  />
                  <div>
                    <small
                      class="text-danger validation-error"
                      v-if="this.error.serial_no"
                    >
                      {{ this.error.serial_no }}
                    </small>
                  </div>
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-2 mb-md-0"> House Lot </label>
                <div class="col-md-8">
                  <input
                    type="hidden"
                    name="house_lot_id"
                    required="required"
                    placeholder="{autofill based on serial no.}"
                    autocomplete="off"
                    class="form-control"
                    :value="this.house_lot_id"
                  />
                  <input
                    type="text"
                    name="inputs_email"
                    required="required"
                    placeholder="{autofill based on serial no.}"
                    autocomplete="off"
                    class="form-control"
                    :value="this.house_lot_no"
                    disabled
                  />
                  <div>
                    <small
                      class="text-danger validation-error"
                      v-if="this.error.house_lot_no"
                    >
                      {{ this.error.house_lot_no }}
                    </small>
                  </div>
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-2 mb-md-0"> Current Reading </label>
                <div class="col-md-8">
                  <input
                    type="text"
                    name="current_reading"
                    max="30"
                    placeholder="Meter current Reading"
                    autocomplete="off"
                    class="form-control"
                    v-model="current_reading"
                  />
                  <div>
                    <small
                      class="text-danger validation-error"
                      v-if="this.error.current_reading"
                    >
                      {{ this.error.current_reading }}
                    </small>
                  </div>
                </div>
              </div>
              <div class="form-group row mb-0">
                <label class="col-sm-2 mb-sm-0"> Upload with preview </label>
                <div class="col-sm-8">
                  <div>
                    <div class="custom-image-upload-wrapper">
                      <div class="image-area d-flex"></div>
                      <div class="input-area">
                        <label id="upload-label" for="inputs_custom_file">
                          Upload your file
                        </label>
                        <input
                          id="inputs_custom_file"
                          type="file"
                          name="image"
                          class="form-control d-none"
                          @change="previewFiles"
                        />
                      </div>
                    </div>
                  </div>
                  <small class="text-muted font-italic">
                    Image format should be jpg, jpeg, png
                  </small>
                  <div>
                    <small
                      class="text-danger validation-error"
                      v-if="this.error.meter_picture"
                    >
                      {{ this.error.meter_picture }}
                    </small>
                  </div>
                </div>
              </div>
              <div class="mt-5 action-buttons">
                <a @click="createReading" class="btn btn-primary mr-2"> Submit </a>
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
  name: "CreateReading",
  mixins: [FormMixin],
  components: {},
  data() {
    return {
      users:[],
      selected_user:[],
      selected_user_id:'',
      branch_data: [],
      house_lot_data: [],
      branch: "",
      serial_no: "",
      house_lot_no: "",
      house_lot_id: "",
      current_reading: "",
      // meter_picture: "",
      error: {
        user:"",
        branch: "",
        serial_no: "",
        house_lot_no: "",
        current_reading: "",
        meter_picture: "",
      },
    };
  },
  methods: {
    previewFiles(event){
      if(!(event.target.files.length > 0)){
        this.error.meter_picture = "Meter Picture is Required"
      }
    },
    clearErrors() {
      this.error.user = "";
      this.error.branch = "";
      this.error.serial_no = "";
      this.error.house_lot_no = "";
      this.error.current_reading = "";
      this.error.meter_picture = "";
    },
    checkValidation() {
      let is_error = false;
      if (this.selected_user_id == "" && !this.selected_user_id) {
        is_error = true;
        this.error.user = "User is required";
      }
      if (this.branch == "" && !this.branch) {
        is_error = true;
        this.error.branch = "Branch is required";
      }
      if (this.serial_no == "" && !this.serial_no) {
        is_error = true;
        this.error.serial_no = "Serial number is required";
      }
      if (this.house_lot_no == "" && !this.house_lot_no) {
        is_error = true;
        this.error.house_lot_no = "House lot is required";
      }
      if (this.current_reading == "" && !this.current_reading) {
        is_error = true;
        this.error.current_reading = "Current Reading is required";
      }
      if(!($('#inputs_custom_file')[0].files.length > 0)){
        is_error = true;
        this.error.meter_picture = "Meter Picture is required";
      }
      return is_error;
    },
    async createReading() {
      this.clearErrors();
      if (!this.checkValidation()) {
        $('#create-reading-form').submit()
      }
      return false;
    },
    getBranch(id) {
      // console.log(id);
      this.axiosGet("/get-branch/" + id)
        .then((response) => {
          if (response.data) {
            this.branch_data = response.data;
            this.branch = response.data.id;
          }
        })
        .catch(({ response }) => {
          this.branch_data = [];
          this.branch = '';
          console.log(response);
        });
    },
    getHouseLot(){
      this.axiosGet("/get-houselot/" + this.serial_no)
      .then((response) => {
        if (response.data) {
          this.error.serial_no = "";
          this.error.house_lot_no = "";
          this.house_lot_data = response.data;
          this.house_lot_id = this.house_lot_data.id;
          this.house_lot_no = this.house_lot_data.house_lot_num;
        }
      })
      .catch(({ response }) => {
        this.error.serial_no = "Enter Valid Serial number";
        this.house_lot_no = '';
        // console.log(response);
      });
    },
    getUsers() {
      this.axiosGet("/admin/get-users")
        .then((response) => {
          this.users = response.data;
        })
        .catch(({ response }) => {
          console.log(response);
        });
    },
    selectUser(id){
      this.axiosGet("/admin/get-user/"+id)
        .then((response) => {
          this.selected_user = response.data;
          // alert(this.selected_use)
          this.getBranch(this.selected_user.branch_id);
        })
        .catch(({ response }) => {
          this.branch_data = [];
          this.branch = '';
          console.log(response);
        });
    }
  },
  created() {
    // this.getBranch(this.user.branch_id);
    this.getUsers();
  },
};
</script>