<template>
  <div class="content-wrapper">
     <div class="row">
      <div class="col-sm-12 col-md-6">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb p-0 d-flex align-items-center mb-primary">
            <li class="breadcrumb-item page-header d-flex align-items-center">
              <h4 class="mb-0">House Lots</h4>
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
        <table v-else class="table mb-0">
          <thead>
            <tr>
              <th track-by="0" class="datatable-th pt-0">
                <span class="font-size-default"><span> id </span></span>
              </th>
              <th track-by="1" class="datatable-th pt-0">
                <span class="font-size-default"><span> Serial No </span></span>
              </th>
              <th track-by="2" class="datatable-th pt-0">
                <span class="font-size-default"><span> House Lot  </span></span>
              </th>
              <th track-by="2" class="datatable-th pt-0">
                <span class="font-size-default"><span> Created on  </span></span>
              </th>
              <th track-by="4" class="datatable-th pt-0">
                <span class="font-size-default"><span> Actions </span></span>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="houselot in houselots.data" :key="houselot.id">
              <td data-title="id" class="datatable-td">
                <span class=""> {{ houselot.id }} </span>
              </td>
              <td data-title="Name" class="datatable-td">
                <span class=""> {{ houselot.serial_num }} </span>
              </td>
              <td data-title="Name" class="datatable-td">
                <span class=""> {{ houselot.house_lot_num }} </span>
              </td>

              <td data-title="Email" class="datatable-td">
                <span class=""> {{ (houselot.created_at).substring(0,10) }} </span>
              </td>
              <td data-title="Action" class="datatable-td">
                <a
                  :href="getEditUrl(houselot.id)"
                  type="button"
                  class="btn btn-primary mr-2 mb-2 mb-sm-0"
                >
                  <app-icon name="edit" />
                </a>
                <a
                  @click="deleteConfirm(houselot.id)"
                  type="button"
                  class="btn btn-danger mr-2 mb-2 mb-sm-0"
                >
                  <app-icon name="trash-2" />
                </a>
              </td>
            </tr>
            <tr v-if="houselots.length <= 0 && !fetching" v-cloak>
              <td colspan="5" align="center">no data found</td>
            </tr>
          </tbody>
        </table>
        <!---->
      </div>
      <pagination align="right" :data="houselots" @pagination-change-page="getHouseLots" style=" margin-top: 10px;"></pagination>
      
    </div>
  </div>
</template>

<script>
import { FormMixin } from "../../../../../core/mixins/form/FormMixin";
import pagination from 'laravel-vue-pagination';
export default {
  name: "HouseLots",
  mixins: [FormMixin],
  components: {
    pagination
  },
  data() {
    return {
      houselots: {},
      fetching: false,
      base_url:""
    };
  },
  methods: {
    async getHouseLots(page = 1) {
      this.axiosGet(`/admin/get-houselots?page=${page}`)
        .then((response) => {
          this.houselots = response.data;
          this.fetching = false;
          console.log(this.houselots);
        })
        .catch(({ response }) => {
          console.log(response);
        });
    },
    getEditUrl(id) {
      return "/admin/houselots/" + id + "/edit";
    },
    deleteConfirm(id) {
      this.$confirm("Are you sure to delete?").then(() => {
        this.deleteHouseLot(id);
      });
    },
    deleteHouseLot(id){
        this.axiosDelete("/admin/houselots/"+id+"/delete")
          .then((response) => {
              if(response.data){
                  this.$alert("HouseLot Deleted !!");
                  this.getHouseLots();
              }
              else{
                  this.$alert("There's Problem deleting HouseLot !!");
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
    this.getHouseLots();
  },
};
</script>