<template>
  <div class="content-wrapper">
    <div class="row">
      <div class="col-sm-12 col-md-6">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb p-0 d-flex align-items-center mb-primary">
            <li class="breadcrumb-item page-header d-flex align-items-center">
              <h4 class="mb-0">Users</h4>
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
                <span class="font-size-default"><span> Name </span></span>
              </th>
              <th track-by="2" class="datatable-th pt-0">
                <span class="font-size-default"><span> Email </span></span>
              </th>
              <th track-by="3" class="datatable-th pt-0">
                <span class="font-size-default"><span>Status</span></span>
              </th>
              <th track-by="4" class="datatable-th pt-0">
                <span class="font-size-default"><span> Actions </span></span>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users.data" :key="user.id">
              <td data-title="id" class="datatable-td">
                <span class=""> {{ user.id }} </span>
              </td>
              <td data-title="Name" class="datatable-td">
                <span class=""> {{ user.full_name }} </span>
              </td>

              <td data-title="Email" class="datatable-td">
                <span class=""> {{ user.email }} </span>
              </td>
              <td data-title="Status" class="datatable-td">
                <span>
                  <span
                    v-if="user.status_id == 1"
                    class="badge badge-sm badge-pill badge-success"
                    >Active</span
                  >
                  <span v-else class="badge badge-sm badge-pill badge-warning"
                    >inactive</span
                  ></span
                >
              </td>
              <td data-title="Action" class="datatable-td">
                <a
                  :href="getEditUrl(user.id)"
                  type="button"
                  class="btn btn-primary mr-2 mb-2 mb-sm-0"
                >
                  <app-icon name="edit" />
                </a>
                <a
                  @click="deleteConfirm(user.id)"
                  type="button"
                  class="btn btn-danger mr-2 mb-2 mb-sm-0"
                >
                  <app-icon name="trash-2" />
                </a>
              </td>
            </tr>
            <tr v-if="users.length <= 0 && !fetching" v-cloak>
              <td colspan="5" align="center">no data found</td>
            </tr>
          </tbody>
        </table>
        <!---->
      </div>
      <pagination align="right" :data="users" @pagination-change-page="getUsers" style=" margin-top: 10px;"></pagination>
    </div>
  </div>
</template>

<script>
import { FormMixin } from "../../../../../core/mixins/form/FormMixin";
import pagination from 'laravel-vue-pagination';
export default {
  name: "Users",
  mixins: [FormMixin],
  components: {
    pagination
  },
  data() {
    return {
      users: {},
      fetching:false,
      base_url:''
    };
  },
  methods: {
    async getUsers(page=1) {
      this.axiosGet(`/admin/get-users?page=${page}`)
        .then((response) => {
          this.users = response.data;
          this.fetching = false;
        })
        .catch(({ response }) => {
          console.log(response);
        });
    },
    getEditUrl(id) {
      return "/admin/users/" + id + "/edit";
    },
    deleteConfirm(id) {
      this.$confirm("Are you sure to delete?").then(() => {
        this.deleteUser(id);
      });
    },
    deleteUser(id){
        this.axiosDelete("/admin/users/"+id+"/delete")
          .then((response) => {
              if(response.data){
                  this.$alert("User Deleted !!");
                  this.getUsers();
              }
              else{
                  this.$alert("There's Problem deleting user !!");
              }
          })
          .catch(({ response }) => {
            console.log(response);
          });
    },
    // getDeleteUrl(id){
    //     return 'admin/users/'+id+'/delete';
    // },
    editUser(id) {},
  },
  created() {
    this.base_url = window.location.origin;
    this.fetching = true;
    this.getUsers();
  },
};
</script>