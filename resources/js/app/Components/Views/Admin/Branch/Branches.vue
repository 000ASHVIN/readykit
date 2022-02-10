<template>
  <div class="content-wrapper">
     <div class="row">
      <div class="col-sm-12 col-md-6">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb p-0 d-flex align-items-center mb-primary">
            <li class="breadcrumb-item page-header d-flex align-items-center">
              <h4 class="mb-0">Branches</h4>
            </li>
          </ol>
        </nav>
      </div>
      <div class="col-sm-12 col-md-6 breadcrumb-side-button">
        <div class="float-md-right mb-3 mb-sm-3 mb-md-0">
          
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
        <table class="table mb-0">
          <thead>
            <tr>
              <th track-by="0" class="datatable-th pt-0">
                <span class="font-size-default"><span> id </span></span>
              </th>
              <th track-by="1" class="datatable-th pt-0">
                <span class="font-size-default"><span> Name </span></span>
              </th>
              <th track-by="2" class="datatable-th pt-0">
                <span class="font-size-default"><span> Created On  </span></span>
              </th>
              <th track-by="4" class="datatable-th pt-0">
                <span class="font-size-default"><span> Actions </span></span>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="branch in branches.data" :key="branch.id">
              <td data-title="id" class="datatable-td">
                <span class=""> {{ branch.id }} </span>
              </td>
              <td data-title="Name" class="datatable-td">
                <span class=""> {{ branch.name }} </span>
              </td>

              <td data-title="Email" class="datatable-td">
                <span class=""> {{ (branch.created_at).substring(0,10) }} </span>
              </td>
              <td data-title="Action" class="datatable-td">
                <a
                  :href="getEditUrl(branch.id)"
                  type="button"
                  class="btn btn-primary mr-2 mb-2 mb-sm-0"
                >
                  <app-icon name="edit" />
                </a>
                <a
                  @click="deleteConfirm(branch.id)"
                  type="button"
                  class="btn btn-danger mr-2 mb-2 mb-sm-0"
                >
                  <app-icon name="trash-2" />
                </a>
              </td>
            </tr>
            <tr v-if="branches.length <= 0 && !fetching" v-cloak>
              <td colspan="5" align="center">no data found</td>
            </tr>
          </tbody>
        </table>
        <!---->
      </div>
      <pagination align="right" :data="branches" @pagination-change-page="getBranches" style=" margin-top: 10px;"></pagination>
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
import pagination from 'laravel-vue-pagination';
export default {
  name: "Branches",
  mixins: [FormMixin],
  components: {
    pagination
  },
  data() {
    return {
      branches: {},
      fetching : false,
      base_url:''
    };
  },
  methods: {
    async getBranches(page=1) {
      this.axiosGet(`/admin/get-branches?page=${page}`)
        .then((response) => {
          this.branches = response.data;
          this.fetching = false;
          console.log(this.branches);
        })
        .catch(({ response }) => {
          console.log(response);
        });
    },
    getEditUrl(id) {
      return "/admin/branches/" + id + "/edit";
    },
    deleteConfirm(id) {
      this.$confirm("Are you sure to delete?").then(() => {
        this.deleteBranch(id);
      });
    },
    deleteBranch(id){
        this.axiosDelete("/admin/branches/"+id+"/delete")
          .then((response) => {
              if(response.data){
                  this.$alert("Branch Deleted !!");
                  this.getBranches();
              }
              else{
                  this.$alert("There's Problem deleting Branch !!");
              }
          })
          .catch(({ response }) => {
            console.log(response);
          });
    },
  },
  created() {
    this.base_url = window.location.origin;
    this.fetching = true;
    this.getBranches();
  },
};
</script>
<style scoped>
.pagination .page-item .page-link{
  border: none !important;
}
.pagination .page-item.active{
  color: #5b74f2 !important;
}
</style>