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
  components: {},
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
  methods: {
    getUpdateLink() {
      return "/admin/water_readings/" + this.water_reading.id + "/update";
    },
    // previewFiles(event){
    //   if(!(event.target.files.length > 0)){
    //     this.error.meter_picture = "Meter Picture is Required"
    //   }
    // },
    setReading() {
      this.id = this.water_reading.id;
      this.branch = this.water_reading.branch_id;
      this.serial_no = this.water_reading.serial_num;
      this.getHouseLot();
      // this.house_lot_id = this.water_reading.house_lot_id;
      this.current_reading = this.water_reading.current_reading;
      this.remark = this.water_reading.remark;
    },
    clearErrors() {
      this.error.branch = "";
      this.error.serial_no = "";
      this.error.house_lot_no = "";
      this.error.current_reading = "";
      this.error.meter_picture = "";
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
      return is_error;
    },
    async updateReading() {
      this.clearErrors();
      if (!this.checkValidation()) {
        $("#update-reading-form").submit();
      }
      return false;
    },
    getBranch(id) {
      this.axiosGet("/get-branch/" + id)
        .then((response) => {
          if (response.data) {
            this.branch_data = response.data;
            this.branch = response.data.id;
          }
        })
        .catch(({ response }) => {
          console.log(response);
        });
    },
    getHouseLot() {
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
          alert("inerror");
          this.error.serial_no = "Enter Valid Serial number";
          this.house_lot_no = "";
        });
    },
  },
  created() {
    this.getBranch(this.water_reading.branch_id);
    this.setReading();
  },
};
</script>