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
            <tr v-for="user in users" :key="user.id">
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
  name: "Users",
  mixins: [FormMixin],
  components: {},
  data() {
    return {
      users: [],
      fetching:false,
      base_url:''
    };
  },
  methods: {
    getUsers() {
      this.axiosGet("/admin/get-users")
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