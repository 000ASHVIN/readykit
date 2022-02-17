<template>
  <div class="content-wrapper">
    <div class="row">
      <div class="col-12 mb-primary">
        <div class="card card-with-shadow border-0 h-100">
          <div class="card-header p-primary bg-transparent">
            <h5 class="card-title m-0">Edit Reading</h5>
          </div>
          <div class="card-body">
            <form
              id="update-reading-form"
              method="post"
              :action="getUpdateLink()"
              enctype="multipart/form-data"
              class="mb-0"
            >
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
                    :placeholder="branch_data.name"
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
              <div class="form-group row align-items-center house-lot-select">
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
                  <img :src="base_url+'/images/Spinner-2.gif'" alt="loadiing.." id="voicebutton" v-if="serial_no_process">
                  <svg v-if="serial_no_done" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle" data-v-5516bb02="" id="verifiedbutton"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                  <svg v-if="serial_no_invalid" id="invalidbutton" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                  <!-- <input
                    type="text"
                    name="inputs_email"
                    required="required"
                    placeholder="Place House Lot no."
                    autocomplete="off"
                    class="form-control"
                    v-model="house_lot_no"
                    v-on:change="getSerialNum()"
                  /> -->
                  <model-select :options="houseLotList"
                              v-model="house_lot_no"
                              :isDisabled="houseLotList.length == 0"
                              :selectedOption="selectedHouseLot"
                              v-on:change="getSerialNum()"
                              placeholder="select house lot no.">
                  </model-select>
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
                <label class="col-md-2 mb-md-0"> Serial No </label>
                <div class="col-md-8">
                  <input
                    type="hidden"
                    name="serial_num"
                    placeholder="Place meter serial no."
                    autocomplete="off"
                    class="form-control"
                    :value="this.serial_no"
                  />
                  <input
                    type="text"
                    name="serial_num_demo"
                    placeholder="{autofill based on house lot no.}"
                    autocomplete="off"
                    class="form-control"
                    v-model="serial_no"
                    disabled
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
              <div class="form-group row align-items-center">
                <label class="col-md-2 mb-md-0"> Remark </label>
                <div class="col-md-8">
                  <input
                    type="text"
                    name="remark"
                    max="30"
                    placeholder="Enter Remark"
                    autocomplete="off"
                    class="form-control"
                    v-model="remark"
                    required
                  />
                  <div>
                    <small
                      class="text-danger validation-error"
                      v-if="this.error.remark"
                    >
                      {{ this.error.remark }}
                    </small>
                  </div>
                </div>
              </div>
              <div class="form-group row mb-0">
                <label class="col-sm-2 mb-sm-0"> Upload with preview </label>
                <div class="col-sm-8">
                  <div>
                    <div class="custom-image-upload-wrapper">
                      <img
                        class="image-area d-flex"
                        id="output"
                        :src="
                          base_url +
                          '/storage/images/meter_readings/' +
                          water_reading.image
                        "
                      />
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
                <a @click="updateReading" class="btn btn-primary mr-2">
                  Submit
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
import { ModelSelect } from 'vue-search-select';

export default {
  name: "EditReading",
  props: {
    // user: {
    //   type: Object,
    //   required: true,
    // },
    water_reading: {
      type: Object,
      required: true,
    },
  },
  mixins: [FormMixin],
  components: {
    ModelSelect
  },
  data() {
    return {
      branch_data: [],
      house_lot_data: [],
      id: "",
      branch: "",
      serial_no: "",
      house_lot_no: "",
      house_lot_id: "",
      current_reading: "",
      remark: "",
      serial_no_process:false,
      serial_no_done:false,
      serial_no_invalid:false,
      houseLotList: [],
      selectedHouseLot: '',
      error: {
        branch: "",
        serial_no: "",
        house_lot_no: "",
        current_reading: "",
        meter_picture: "",
        remark: "",
      },
    };
  },
  watch: {
    house_lot_no: function(val) {
      this.getSerialNum();
    }
  },
  methods: {
    getUpdateLink() {
      return "/update-reading/" + this.water_reading.id;
    },
    previewFiles(event) {
      if (event.target.files.length > 0) {
        var image = document.getElementById("output");
        image.src = URL.createObjectURL(event.target.files[0]);
      }
    },
    setReading() {
      this.id = this.water_reading.id;
      this.branch = this.water_reading.branch_id;
      this.house_lot_id = this.water_reading.house_lot_id;
      this.house_lot_no = this.water_reading.house_lot.id;
      this.getSerialNum();
      this.current_reading = this.water_reading.current_reading;
      this.remark = this.water_reading.remark;

      this.selectedHouseLot = {
        value: this.house_lot_no,
        text: this.water_reading.house_lot.house_lot_num
      };
    },
    clearErrors() {
      this.error.branch = "";
      this.error.serial_no = "";
      this.error.house_lot_no = "";
      this.error.current_reading = "";
      this.error.meter_picture = "";
      this.error.remark = "";
    },
    checkValidation() {
      let is_error = false;
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
      if (this.remark == "" || !this.remark) {
        is_error = true;
        this.error.remark = "Remark is required";
      }
      return is_error;
    },
    async updateReading() {
      this.clearErrors();
      if (!this.checkValidation()) {
        $("#update-reading-form").submit();
      }
    },
    async getBranch(id) {
      await this.axiosGet("/get-branch/" + id)
        .then((response) => {
          if (response.data) {
            this.branch_data = response.data;
            this.branch = response.data.id;

            this.getHouseLotList(this.branch);
          }
        })
        .catch(({ response }) => {
          console.log(response);
        });
    },
    getSerialNum() {
      this.serial_no_done = false;
      this.serial_no_process = true;
      this.serial_no_invalid =false;
      this.axiosGet("/get-serialnum/" + this.house_lot_no)
      .then((response) => {
        if (response.data) {
          console.log(response.data);
          this.error.serial_no = "";
          this.error.house_lot_no = "";
          this.serial_no_process = false;
          this.serial_no_done = true;
          this.house_lot_data = response.data;
          this.serial_no = this.house_lot_data.serial_num
          this.house_lot_id = this.house_lot_data.id;
        }
      })
      .catch(({ response }) => {
        this.serial_no_process = false;
        this.serial_no_invalid = true;
        this.error.house_lot_no = "Enter Valid House lot number";
        this.serial_no = '';
      });
    },
    async getHouseLotList(branch_id){
      await this.axiosGet("/branch/"+ branch_id + "/house_lots")
      .then((response) => {
        let data = response.data[0];
        data.forEach(houseLot => {
          this.houseLotList.push({
            value: houseLot.id,
            text: houseLot.house_lot_num
          });
        });
      })
      .catch(({error}) => {
        console.log(error);
      });
    },

  },
  created() {
    this.base_url = window.location.origin;
    this.getBranch(this.water_reading.branch_id);
    this.setReading();
  },
};
</script>
<style scoped>
 #voicebutton{
      width: 23px;
      height: 23px;
      position: absolute;
      right: 20px;
      top: 10px;
    }
    #verifiedbutton{
      width: 23px;
      height: 23px;
      position: absolute;
      right: 20px;
      top: 10px;
      color:green;
    }
    #invalidbutton{
      width: 23px;
      height: 23px;
      position: absolute;
      right: 20px;
      top: 10px;
      color:red;
    }
  .house-lot-select >>> .ui.selection.dropdown {
    min-height: unset !important;
    height: 38px;
  }
</style>