<template>
  <div class="content-wrapper">
    <div class="row">
      <div class="col-sm-12 col-md-6">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb p-0 d-flex align-items-center mb-primary">
            <li class="breadcrumb-item page-header d-flex align-items-center">
              <h4 class="mb-0">Water Tank Readings</h4>
            </li>
          </ol>
        </nav>
      </div>
      <div class="col-sm-12 col-md-6 breadcrumb-side-button">
        <div class="float-md-right mb-3 mb-sm-3 mb-md-0">
          <a
            class="btn btn-primary btn-with-shadow"
            :href="'/admin/get-all-export-data'"
          >
                   <app-icon name="clipboard"/>
       Export All data
          </a>
        </div>
      </div>
    </div>
    <div class="datatable">
      <div
        class="
          table-responsive
          custom-scrollbar
          table-view-responsive
          shadow
          pt-primary
        "
      >
      <table v-if="fetching">
          <img :src="base_url+'/images/Circle-Preloader-1.gif'" alt="fetching..">
        </table>
        <table v-else class="table mb-0">
          <thead>
            <tr>
              <th track-by="0" class="datatable-th pt-0">
                <span class="font-size-default"><span> House Lot </span></span>
              </th>
              <th track-by="1" class="datatable-th pt-0">
                <span class="font-size-default"><span> Branch </span></span>
              </th>
              <th track-by="2" class="datatable-th pt-0">
                <span class="font-size-default"><span>Serial No</span></span>
              </th>
              <th track-by="3" class="datatable-th pt-0">
                <span class="font-size-default"><span>Curr. Reading</span></span>
              </th>
              <th track-by="4" class="datatable-th pt-0">
                <span class="font-size-default"><span>Last Reading</span></span>
              </th>
              <th track-by="4" class="datatable-th pt-0">
                <span class="font-size-default"><span>Date Submitted</span></span>
              </th>
              <th track-by="5" class="datatable-th pt-0">
                <span class="font-size-default"><span>Image</span></span>
              </th>
              <th track-by="6" class="datatable-th pt-0">
                <span class="font-size-default"><span>Create By</span></span>
              </th>
              <th track-by="7" class="datatable-th pt-0">
                <span class="font-size-default"><span>Actions</span></span>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="water_reading in water_readings.data" :key="water_reading.id">
              <td data-title="id" class="datatable-td">
                <span class=""> {{ water_reading.house_lot.house_lot_num }} </span>
              </td>
              <td data-title="created_by" class="datatable-td">
                <span class=""> {{ water_reading.branch.name }} </span>
              </td>
              <td data-title="branch" class="datatable-td">
                <span class=""> {{ water_reading.serial_num }} </span>
              </td>
              <td data-title="serial_no" class="datatable-td">
                <span class="">  {{ water_reading.current_reading ? (water_reading.current_reading.length > 5 ? (water_reading.current_reading ).substring(0,5)+'..' :water_reading.current_reading )  : '-' }}</span>
              </td>
              <td data-title="serial_no" class="datatable-td">
                <span class=""> {{ water_reading.last_reading ? (water_reading.last_reading.length > 5 ? (water_reading.last_reading ).substring(0,5)+'..' :water_reading.last_reading )  : '-' }} </span>
              </td>
              <td data-title="serial_no" class="datatable-td">
                <span class=""> {{ (water_reading.created_at).substring(0,10) }} </span>
              </td>
              <td data-title="Status" class="datatable-td">
                <div class="avatars-w-50">
                  <img
                    :src="
                      base_url +
                      '/storage/images/meter_readings/' +
                      water_reading.image
                    "
                    alt="Clarissa Kerluke"
                    class="rounded-circle"
                  />
                </div>
              </td>
              <td data-title="serial_no" class="datatable-td">
                <span class=""> {{ water_reading.user.first_name }} </span>
              </td>
              <td data-title="Action" class="datatable-td">
                <a
                  :href="getEditUrl(water_reading.id)"
                  type="button"
                  class="btn btn-primary table-btn mr-2 mb-2 mb-sm-0"
                >
                  <app-icon name="edit" />
                </a>
                <a
                  @click="deleteConfirm(water_reading.id)"
                  type="button"
                  class="btn btn-danger table-btn mr-2 mb-2 mb-sm-0"
                >
                  <app-icon name="trash-2" />
                </a>
                <a
                  :href="getDownloadUrl(water_reading.id)"
                  type="button"
                  class="btn btn-info table-btn mr-2 mb-2 mb-sm-0"
                >
                  <app-icon name="download" />
                </a>
              </td>
            </tr>
            <tr v-if="water_readings.length <= 0  && !fetching" v-cloak>
              <td colspan="5" align="center">no data found</td>
            </tr>
          </tbody>
        </table>
        <!---->
      </div>
      <pagination align="right" :data="water_readings" @pagination-change-page="getWaterReadings" style=" margin-top: 10px;"></pagination>
       
    </div>
  </div>
</template>

<script>
import { FormMixin } from "../../../../../core/mixins/form/FormMixin";
import pagination from 'laravel-vue-pagination'
export default {
  name: "WaterReadings",
  mixins: [FormMixin],
  components: {
    pagination
  },
  data() {
    return {
      water_readings: {},
      base_url: "",
      fetching:false
    };
  },
  methods: {
    async getWaterReadings(page = 1) {
      this.axiosGet(`/admin/get-water_readings?page=${page}`)
        .then((response) => {
          this.water_readings = response.data;
          this.fetching = false;
          // console.log(this.water_readings.data);
        })
        .catch(({ response }) => {
          console.log(response);
        });
    },
    getUserData(){

    },
    getDownloadUrl(id) {
      return "/admin/get-reading-info/" + id;
    },
    getEditUrl(id) {
      return "/admin/water_readings/" + id + "/edit";
    },
    deleteConfirm(id) {
      this.$confirm("Are you sure to delete?").then(() => {
        this.deleteWaterReading(id);
      });
    },
    deleteWaterReading(id) {
      this.axiosDelete("/admin/water_readings/" + id + "/delete")
        .then((response) => {
          if (response.data) {
            this.$alert("Water Reading Deleted !!");
            this.getWaterReadings();
          } else {
            this.$alert("There's Problem deleting water reading !!");
          }
        })
        .catch(({ response }) => {
          console.log(response);
        });
    },
  },
  created() {
    this.base_url = window.location.origin;
    // console.log(this.water_readings);
    this.fetching = true;
    this.getWaterReadings();
  },
};
</script>
<style scoped>
 .table-btn{
   margin-top: 3px;
 }
 /* .page-link{
   border: none;
   color: #4466F2;
 } */

</style>