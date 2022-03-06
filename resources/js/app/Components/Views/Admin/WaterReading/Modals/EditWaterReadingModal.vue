<template>
  <div class="modal" id="exampleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Water Reading</h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
            @click="clickEvent"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
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
                      @submit.prevent="submitData"
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
                      <div
                        class="
                          form-group
                          row
                          align-items-center
                          house-lot-select
                        "
                      >
                        <label class="col-md-2 mb-md-0"> House Lot </label>
                        <div class="col-md-8">
                          <input
                            type="hidden"
                            name="house_lot_id"
                            required="required"
                            placeholder="{autofill based on serial no.}"
                            autocomplete="off"
                            class="form-control"
                            :value="house_lot_id"
                          />
                          <img
                            :src="base_url + '/images/Spinner-2.gif'"
                            alt="loadiing.."
                            id="voicebutton"
                            v-if="serial_no_process"
                          />
                          <svg
                            v-if="serial_no_done"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-check-circle"
                            data-v-5516bb02=""
                            id="verifiedbutton"
                          >
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                          </svg>
                          <svg
                            v-if="serial_no_invalid"
                            id="invalidbutton"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-x-circle"
                          >
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                          </svg>
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
                          <model-select
                            :options="houseLotList"
                            v-model="house_lot_id"
                            :isDisabled="houseLotList.length == 0"
                            :selectedOption="selectedHouseLot"
                            placeholder="select house lot no."
                          >
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
                            :value="serial_no"
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
                              v-if="error.serial_no"
                            >
                              {{ error.serial_no }}
                            </small>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row align-items-center">
                        <label class="col-md-2 mb-md-0">
                          Current Reading
                        </label>
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
                        <label class="col-sm-2 mb-sm-0">
                          Upload with preview
                        </label>
                        <div class="col-sm-8">
                          <div>
                            <div class="custom-image-upload-wrapper">
                              <img
                                class="image-area d-flex"
                                id="output"
                                :src="water_reading.image"
                              />
                              <div class="input-area">
                                <label
                                  id="upload-label"
                                  for="inputs_custom_file"
                                >
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
                        <button
                          :disabled="disabled"
                          type="submit"
                          class="btn btn-primary mr-2"
                          id="submit_button"
                        >
                          {{ buttonText }}
                        </button>
                      </div>
                      
                    </form>
                    <div
                        class="alert alert-success mt-3"
                        v-if="successMessage"
                      >
                        {{ this.successMessage }}
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-dismiss="modal"
            @click="clickEvent"
          >
            Close
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script >
// import { FormMixin } from "../../../../../../core/mixins/form/FormMixin";
import { ModelSelect } from "vue-search-select";
export default {
  name: "EditReading",
  props: {
    water_reading: {},
    props_branch_data: {},
    props_house_lot_data: [],
    props_branch: "",
    props_houseLotList: [],
    props_id: "",
    props_serial_no: "",
    props_house_lot_no: "",
    props_house_lot_id: "",
    props_current_reading: "",
    props_remark: "",
    props_dropDownImage: "",
    props_serial_no_process: false,
    props_serial_no_done: false,
    props_serial_no_invalid: false,
    props_selectedHouseLot: "",
    props_error_house_lot_no: "",
    props_error_serial_no: "",
  },
  // mixins: [FormMixin],
  components: {
    ModelSelect,
  },
  data() {
    return {
      successMessage: "",
      branch_data: this.props_branch_data,
      house_lot_data: this.props_house_lot_data,
      new_branch: this.props_branch,
      new_branch_data: this.props_branch_data,
      branch: this.props_branch,
      serial_no: this.props_serial_no,
      house_lot_no: this.props_house_lot_no,
      house_lot_id: this.props_house_lot_id,
      current_reading: this.props_current_reading,
      remark: this.props_remark,
      dropDownImage: this.props_dropDownImage,
      serial_no_process: this.props_serial_no_process,
      serial_no_done: this.props_serial_no_done,
      serial_no_invalid: this.props_serial_no_invalid,
      houseLotList: this.props_houseLotList,
      selectedHouseLot: this.props_selectedHouseLot,
      id: this.props_id,
      base_url: window.location.origin,
      image: "",
      disabled: false,
      buttonText: "Submit",
      error: {
        branch: "",
        serial_no: this.props_error_serial_no,
        house_lot_no: this.props_error_house_lot_no,
        current_reading: "",
        meter_picture: "",
        remark: "",
      },
    };
  },
  watch: {
    house_lot_id: function (val) {
      this.getSerialNum();
    },
    props_branch_data: function (val) {
      this.branch_data = val;
    },
    props_branch: function (val) {
      this.branch = val;
    },
    props_serial_no: function (val) {
      this.serial_no = val;
    },
  },
  methods: {
    submitData() {
      this.disabled = true;
      this.buttonText = "submitting";

      let self = this;
      let data = new FormData();
      if (this.serial_no !== null) {
        data.append("serial_num", this.serial_no);
      }
      if (this.house_lot_id !== null) {
        data.append("house_lot_id", this.house_lot_id);
      }
      if (this.image !== null) {
        data.append("image", this.image);
      }
      if (this.current_reading !== null) {
        data.append("current_reading", this.current_reading);
      }
      if (this.branch !== null) {
        data.append("branch_id", this.branch);
      }
      if (this.remark !== null) {
        data.append("remark", this.remark);
      }

      console.log(data);
      axios
        .post(
          "/admin/water_readings/" + this.water_reading.id + "/update",
          data
        )
        .then(function (response) {
          self.successMessage = "water reading updated successfully";
          window.scrollTo(0, 0);
          window.location.reload();
        })
        .catch(function (error) {
          this.disabled  = false;
          this.buttonText = "submit";
          let status = error.response.status;
          let data = error.response.data;
          if (status == "422") {
            if (data.branch_id) {
              self.error.branch = data.branch_id[0];
            }
            if (data.image) {
              self.error.meter_picture = data.image[0];
            }
            if (data.remark) {
              self.error.remark = data.remark[0];
            }
            if (data.current_reading) {
              self.error.current_reading = data.current_reading[0];
            }
            if (data.serial_num) {
              self.error.serial_no = data.serial_num[0];
            }
            if (data.house_lot_id) {
              self.error.house_lot_no = data.house_lot_id[0];
            }
          }
        });
    },

    clickEvent() {
      console.log("event created");
      this.$emit("modalOff");
    },

    previewFiles(event) {
      if (event.target.files.length > 0) {
        var image = document.getElementById("output");
        image.src = URL.createObjectURL(event.target.files[0]);
        this.image = event.target.files[0];
      }
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

    async getWaterReadingData(id) {
      await axios
        .get(this.edit_url)
        .then(function (response) {
          this.water_reading = response.data;
        })
        .catch(function (error) {});
    },

    getSerialNum() {
      let self = this;
      this.serial_no_done = false;
      this.serial_no_process = true;
      this.serial_no_invalid = false;
      console.log(this.house_lot_id);
      axios
        .get("/get-serialnum/" + this.house_lot_id)
        .then((response) => {
          if (response.data) {
            self.error.serial_no = "";
            self.error.house_lot_no = "";
            self.serial_no_process = false;
            self.serial_no_done = true;
            self.house_lot_data = response.data;
            self.serial_no = self.house_lot_data.serial_num;
            self.house_lot_id = self.house_lot_data.id;
          }
        })
        .catch(({ response }) => {
          self.serial_no_process = false;
          self.serial_no_invalid = true;
          self.error.house_lot_no = "Enter Valid House lot number";
          self.serial_no = "";
        });
    },
  },
};
</script>
<style scoped>
#voicebutton {
  width: 23px;
  height: 23px;
  position: absolute;
  right: 20px;
  top: 10px;
}
#verifiedbutton {
  width: 23px;
  height: 23px;
  position: absolute;
  right: 20px;
  top: 10px;
  color: green;
}
#invalidbutton {
  width: 23px;
  height: 23px;
  position: absolute;
  right: 20px;
  top: 10px;
  color: red;
}
.house-lot-select >>> .ui.selection.dropdown {
  min-height: unset !important;
  height: 38px;
}
</style>