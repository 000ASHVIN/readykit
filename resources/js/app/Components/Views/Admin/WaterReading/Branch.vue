<template>
  <div>
    <data-table
      :columns="columns"
      :url="url"
      :per-page="['10', '20']"
      :classes="classes"
    >
      
    </data-table>
    <edit-water-reading-modal
      :water_reading="water_reading"
      :props_houseLotList="houseLotList"
      :props_serial_no="serial_no"
      :props_house_lot_no="house_lot_no"
      :props_house_lot_id="house_lot_id"
      :props_current_reading="current_reading"
      :props_remark="remark"
      :props_dropDownImage="dropDownImage"
      :props_serial_no_process="serial_no_process"
      :props_serial_no_done="serial_no_done"
      :props_serial_no_invalid="serial_no_invalid"
      :props_selectedHouseLot="selectedHouseLot"
      :props_error_house_lot_no="error_house_lot_no"
      :props_error_serial_no="error_serial_no"
      :props_id="id"
      :props_branch_data="branch_data"
      :props_branch="branch"
      v-if="showModal"
      @modalOff="changeShowModal"
      
    ></edit-water-reading-modal>
  </div>
</template>

<script>
import Image from "./Images/Image.vue";
import TableButton from "./Buttons/TableButton.vue";
import EditButton from "./Buttons/EditButton";
import EditWaterReadingModal from "./Modals/EditWaterReadingModal.vue";
import { timeInterval } from "../../../../Helpers/Helpers";
export default {
  // props: ["branch_id"],
  props: {
    branch_id: "",
    data: {},
  },
  components: {
    EditButton,
    EditWaterReadingModal,
  },

  methods: {
    changeShowModal() {
      this.showModal = false;
      this.branch_data="";
      this.branch="";
      this.serial_no;
    },
    async getBranch(id) {
      let self = this;
      await axios
        .get("/get-branch/" + id)
        .then((response) => {
          if (response.data) {
            self.branch_data = response.data;
            self.branch = response.data.id;

            self.getHouseLotList(self.branch);
          }
        })
        .catch(({ response }) => {});
    },
    async getHouseLotList(branch_id) {
      let self = this;
      await axios
        .get("/branch/" + branch_id + "/house_lots")
        .then((response) => {
          let data = response.data;
          data.forEach((houseLot) => {
            self.houseLotList.push({
              value: houseLot.id,
              text: houseLot.house_lot_num,
            });
          });
        })
        .catch(({ error }) => {});
    },
    async setReading() {
      this.id = this.water_reading.id;
      // this.branch = this.water_reading.branch_id;
      this.house_lot_id = this.water_reading.house_lot_id;
      console.log("house_lot" + this.house_lot_id);
      this.house_lot_no = this.water_reading.house_lot_num;
      // this.getSerialNum();
      this.current_reading = this.water_reading.current_reading;
      this.remark = this.water_reading.remark;

      this.selectedHouseLot = {
        value: this.house_lot_id,
        text: this.water_reading.house_lot_num,
      };
    },
    async getSerialNum() {
      this.serial_no_done = false;
      this.serial_no_process = true;
      this.serial_no_invalid = false;
      let self = this;
      await axios
        .get("/get-serialnum/" + this.house_lot_id)
        .then((response) => {
          console.log("serial" + response.data);
          if (response.data) {
            self.error_serial_no = "";
            self.error_house_lot_no = "";
            self.serial_no_process = false;
            self.serial_no_done = true;
            self.house_lot_data = response.data;
            self.serial_no = self.house_lot_data.serial_num;
            self.house_lot_id = self.house_lot_data.id;
          }
        })
        .catch(({ response }) => {
          console.log("error" + response);
          // self.serial_no_process = false;
          // self.serial_no_invalid = true;
          // self.error_house_lot_no = "Enter Valid House lot number";
          self.serial_no = "";
        });
      console.log(this.serial_no);
    },
   
    async updateSelectedModal(data) {
      this.water_reading = data;
      this.serial_no = this.water_reading.serial_num;
      this.error_serial_no = "";
      this.error_house_lot_no = "";
      this.serial_no_process = false;
      this.serial_no_done = true;
      this.dropDownImage = window.location.origin + "/images/chevron-down.svg";
      this.getBranch(this.water_reading.branch_id);

      this.setReading();
      console.log("branch" + this.branch);
      console.log("branch_data" + this.branch_data);
      console.log("hosuseLotList" + this.houseLotList);
      this.showModal = true;
    },
  },
  data() {
    return {
      water_reading: {},
      branch_data: {},
      house_lot_data: [],
      branch: "",
      houseLotList: [],
      id: "",
      serial_no: "",
      house_lot_no: "",
      house_lot_id: "",
      current_reading: "",
      remark: "",
      dropDownImage: "",
      serial_no_process: false,
      serial_no_done: false,
      serial_no_invalid: false,
      selectedHouseLot: "",
      error_house_lot_no: "",
      error_serial_no: "",
      showModal: false,
      base_url: "",

      classes: {
        "table-container": {
          "justify-center": true,
          "w-full": true,
          flex: true,
          rounded: true,
          "mb-6": true,
          "shadow-md": true,
        },
        table: {
          "text-left": true,
          "w-full": true,
          "border-collapse": true,
        },
        "t-head": {
          "text-grey-dark": true,
          "bg-black": true,
          "border-grey-light": true,
          "py-4": true,
          "px-6": true,
        },
        "t-body": {
          "bg-grey-darkest": true,
        },
        "t-head-tr": {},
        "t-body-tr": {
          "stripped-table": true,
          "bg-grey-darkest": true,
        },
        td: {
          datatable: true,
        },
        th: {},
      },

      url: "/admin/water_readings/list/" + this.branch_id,
      columns: [
        {
          label: "Area",
          name: "area",
          columnName: "area.name",
          searchable: true,
          orderable: true,
        },
        {
          label: "Branch",
          name: "branch",
          columnName: "branch.name",
          searchable: true,
          orderable: true,
        },
        {
          label: "House Lot ",
          name: "house_lot_num",
          columnName: "house_lot.house_lot_num",
          searchable: true,
          orderable: true,
        },
        {
          label: "S.N No.",
          name: "serial_num",
          columnName: "house_lot.serial_num",
          searchable: true,
          orderable: true,
        },
        {
          label: "Last Reading (liter)",
          name: "last_reading",
          searchable: true,
          orderable: true,
        },
        {
          label: "Current Reading (liter)",
          name: "current_reading",
          searchable: true,
          orderable: true,
        },
        {
          label: "Usage (liter)",
          name: "usage",
          searchable: false,
          orderable: true,
        },
        { label: "Date Submitted", name: "created_at", orderable: true },
        {
          label: "Image",
          name: "image",
          orderable: false,
          searchable: false,
          component: Image,
        },
        {
          label: "User",
          name: "first_name",
          columnName: "users.first_name",
          searchable: true,
          orderable: true,
        },
        {
          label: "Edit",
          component: EditButton,
          orderable: false,
          event: "click",
          handler: this.updateSelectedModal,
        },
        { label: "Action", name: "action", component: TableButton },
      ],
    };
  },
};
</script>

<style scoped>
.datatable.btn {
  height: 28px !important;
}
.datatable svg {
  height: 14px !important;
}

.datatable td {
  padding: 10px 30px 10px 15px;
  vertical-align: middle;
}
.datatable td:first-child {
  padding: 10px 30px;
}
</style>



