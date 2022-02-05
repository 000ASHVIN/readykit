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
          <!-- <a
            class="btn btn-primary btn-with-shadow"
            :href="'/admin/get-all-export-data'"
          >
                   <app-icon name="clipboard"/>
       Export All data
          </a> -->
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
        <table class="table mb-0">
          <thead>
            <tr>
              <th track-by="0" class="datatable-th pt-0">
                <span class="font-size-default"><span> Id </span></span>
              </th>
              <th track-by="1" class="datatable-th pt-0">
                <span class="font-size-default"><span> Created By </span></span>
              </th>
              <th track-by="2" class="datatable-th pt-0">
                <span class="font-size-default"><span> Branch </span></span>
              </th>
              <th track-by="3" class="datatable-th pt-0">
                <span class="font-size-default"><span>Serial No</span></span>
              </th>
              <th track-by="4" class="datatable-th pt-0">
                <span class="font-size-default"><span>Image</span></span>
              </th>
              <th track-by="5" class="datatable-th pt-0">
                <span class="font-size-default"><span>Actions</span></span>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="water_reading in water_readings" :key="water_reading.id">
              <td data-title="id" class="datatable-td">
                <span class=""> {{ water_reading.id }} </span>
              </td>
              <td data-title="created_by" class="datatable-td">
                <span class=""> {{ water_reading.user.full_name }} </span>
              </td>
              <td data-title="branch" class="datatable-td">
                <span class=""> {{ water_reading.branch.name }} </span>
              </td>

              <td data-title="serial_no" class="datatable-td">
                <span class=""> {{ water_reading.serial_num }} </span>
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
              <td data-title="Action" class="datatable-td">
                <a
                  :href="getEditUrl(water_reading.id)"
                  type="button"
                  class="btn btn-primary mr-2 mb-2 mb-sm-0"
                >
                  <app-icon name="edit" />
                </a>
                <a
                  @click="deleteConfirm(water_reading.id)"
                  type="button"
                  class="btn btn-danger mr-2 mb-2 mb-sm-0"
                >
                  <app-icon name="trash-2" />
                </a>
                <!-- <a
                  :href="getDownloadUrl(water_reading.id)"
                  type="button"
                  class="btn btn-info mr-2 mb-2 mb-sm-0"
                >
                  <app-icon name="download" />
                </a> -->
              </td>
            </tr>
            <tr v-if="water_readings.length <= 0" v-cloak>
              <td colspan="5" align="center">no data found</td>
            </tr>
          </tbody>
        </table>
        <!---->
      </div>
      <!-- <div class="p-primary">
        <div>
          <div class="d-flex flex-column flex-md-row justify-content-between">
            <div
              class="
                dropdown-menu-filter
                d-flex
                align-items-center
                justify-content-center justify-content-md-start
              "
            >
              <div class="dropdown keep-inside-clicks-open">
                <button
                  type="button"
                  id="show-pagination-responsive-table"
                  data-toggle="dropdown"
                  class="btn btn-filter"
                >
                  10
                  <img
                    src="http://127.0.0.1:8000/images/chevron-down.svg"
                    alt=""
                    style="height: 16px; width: 16px"
                  />
                </button>
                <div
                  aria-labelledby="show-pagination-responsive-table"
                  class="my-2 dropdown-menu dropdown-menu-responsive-table"
                >
                  <a href="#" class="dropdown-item active disabled"> 10 </a
                  ><a href="#" class="dropdown-item"> 20 </a
                  ><a href="#" class="dropdown-item"> 30 </a>
                </div>
              </div>
              <label class="text-muted ml-2 mb-0">Items showing per page</label>
            </div>
            <nav data-v-1ab5eeaf="" style="">
              <ul
                data-v-1ab5eeaf=""
                class="
                  pagination
                  justify-content-center justify-content-md-end
                  mb-0
                "
              >
                <li data-v-1ab5eeaf="" class="d-flex align-items-center mr-3">
                  <p data-v-1ab5eeaf="" class="text-muted mb-0 mr-2">
                    Go to page
                  </p>
                  <input
                    data-v-1ab5eeaf=""
                    type="text"
                    class="form-control width-50"
                  />
                </li>
                <li data-v-1ab5eeaf="" class="page-item disabled">
                  <a
                    data-v-1ab5eeaf=""
                    href="#"
                    aria-label="Previous"
                    class="page-link border-0"
                    ><span data-v-1ab5eeaf=""
                      ><svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="feather feather-arrow-left menu-arrow"
                        data-v-1ab5eeaf=""
                      >
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline
                          points="12 19 5 12 12 5"
                        ></polyline></svg></span
                  ></a>
                </li>
                <li data-v-1ab5eeaf="" class="page-item">
                  <a
                    data-v-1ab5eeaf=""
                    href="#"
                    class="page-link border-0 active disabled"
                    >1</a
                  >
                </li>
                <li data-v-1ab5eeaf="" class="page-item">
                  <a data-v-1ab5eeaf="" href="#" class="page-link border-0"
                    >2</a
                  >
                </li>
                <li data-v-1ab5eeaf="" class="page-item">
                  <a data-v-1ab5eeaf="" href="#" class="page-link border-0"
                    >3</a
                  >
                </li>
                <li data-v-1ab5eeaf="" class="page-item">
                  <a data-v-1ab5eeaf="" href="#" class="page-link border-0"
                    >4</a
                  >
                </li>
                <li data-v-1ab5eeaf="" class="page-item">
                  <a data-v-1ab5eeaf="" href="#" class="page-link border-0"
                    >5</a
                  >
                </li>
                <li data-v-1ab5eeaf="" class="page-item">
                  <a
                    data-v-1ab5eeaf=""
                    href="#"
                    aria-label="Next"
                    class="page-link border-0 align-content-center"
                    ><svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      class="feather feather-arrow-right menu-arrow"
                      data-v-1ab5eeaf=""
                    >
                      <line x1="5" y1="12" x2="19" y2="12"></line>
                      <polyline points="12 5 19 12 12 19"></polyline></svg
                  ></a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div> -->
    </div>
  </div>
</template>

<script>
import { FormMixin } from "../../../../../core/mixins/form/FormMixin";
export default {
  name: "WaterReadings",
  mixins: [FormMixin],
  components: {},
  data() {
    return {
      water_readings: [],
      base_url: "",
    };
  },
  methods: {
    getWaterReadings() {
      this.axiosGet("/admin/get-water_readings")
        .then((response) => {
          this.water_readings = response.data;
          console.log(this.water_readings);
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
    this.getWaterReadings();
  },
};
</script>