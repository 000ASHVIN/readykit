<template>
  <div class="content-wrapper">
    <div class="row">
      <div class="col-12 mb-primary">
        <div class="card card-with-shadow border-0 h-100">
          <div class="card-header p-primary bg-transparent">
            <h5 class="card-title m-0">Edit User</h5>
          </div>
          <div class="card-body">
            <form class="mb-0">
              <div class="form-group row align-items-center">
                <label class="col-md-2 mb-md-0"> First Name </label>
                <div class="col-md-8">
                  <input
                    type="text"
                    name="inputs_name"
                    id="inputs_name"
                    placeholder="Type name"
                    autocomplete="off"
                    class="form-control"
                    v-model="first_name"
                  />
                  <div>
                    <small class="text-danger validation-error" v-if="this.error.first_name">
                      {{ this.error.first_name }}
                    </small>
                  </div>
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-2 mb-md-0"> Last Name </label>
                <div class="col-md-8">
                  <input
                    type="text"
                    name="inputs_name"
                    id="inputs_name"
                    placeholder="Type name"
                    autocomplete="off"
                    class="form-control"
                    v-model="last_name"
                  />
                  <div>
                    <small class="text-danger validation-error" v-if="this.error.last_name">
                      {{ this.error.last_name }}
                    </small>
                  </div>
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-2 mb-md-0"> Email </label>
                <div class="col-md-8">
                  <input
                    type="email"
                    name="inputs_email"
                    id="inputs_email"
                    required="required"
                    placeholder="Type email"
                    autocomplete="off"
                    class="form-control"
                    v-model="email"
                  />
                  <div>
                    <small class="text-danger validation-error" v-if="this.error.email">
                      {{ this.error.email }}
                    </small>
                  </div>
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-2 mb-md-0"> Temp Password </label>
                <div class="col-md-8">
                  <input
                    type="text"
                    name="inputs_age"
                    id="inputs_age"
                    max="30"
                    placeholder="Enter temporary password"
                    autocomplete="off"
                    class="form-control"
                    v-model="temp_password"
                  />
                  <div>
                    <small class="text-danger validation-error" v-if="this.error.temp_password">
                      {{ this.error.temp_password }}
                    </small>
                  </div>
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-2 mb-md-0"> Status </label>
                <div class="col-md-8">
                  <select
                    id="inputs_status"
                    class="custom-select"
                    :style='
                      "background-image: url("+dropDownImage+");"
                    '
                    v-model="status"
                  >
                    <option value="">Choose One</option>
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                    <option value="3">Invite</option>
                  </select>
                  <div>
                    <small class="text-danger validation-error" v-if="this.error.status">
                      {{ this.error.status }}
                    </small>
                  </div>
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-2 mb-md-0"> Branch </label>
                <div class="col-md-8">
                  <select
                    id="inputs_status"
                    class="custom-select"
                    :style='
                      "background-image: url("+dropDownImage+");"
                    '
                    v-model="branch"
                  >
                    <option v-for="branch in branches" :key="branch.id" :value="branch.id">{{ branch.name}}</option>
                    
                  </select>
                  <div>
                    <small class="text-danger validation-error" v-if="this.error.branch">
                      {{ this.error.branch }}
                    </small>
                  </div>
                </div>
              </div>
              <div class="mt-5 action-buttons">
                <a @click="updateUser" class="btn btn-primary mr-2">
                  Update
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
  name: "EditUser",
  mixins: [FormMixin],
  props: {
    user: {
      type: Object,
      required: true
    }
  },
  components: {},
  data() {
    return {
        id:'',
        branch:'',
        first_name:'',
        last_name:'',
        email:'',
        temp_password:"",
        status:'',
        branches:[],
        dropDownImage:'',
        error:{
          first_name:'',
          last_name:'',
          email:'',
          temp_password:'',
          status:'',
          branch:''
        }
    };
  },
  methods: {
      clearErrors(){
        this.error.first_name ='';
        this.error.last_name ='';
        this.error.email ='';
        this.error.temp_password ='';
        this.error.status ='';
        this.error.branch ='';
      },
      setUser(){
          this.id=this.user.id;
          this.first_name=this.user.first_name;
          this.last_name=this.user.last_name;
          this.email=this.user.email;
          this.temp_password=this.user.temp_password;
          this.status=this.user.status_id;
          this.branch=this.user.branch_id;
      },
      checkValidation(){
        let is_error = false;
        if(this.first_name == "" && !this.first_name){
          is_error = true;
          this.error.first_name = "First name is required";
        }
        if(this.last_name == "" && !this.last_name){
          is_error = true;
          this.error.last_name = "Last name is required";
        }
        if(this.email == "" && !this.email){
          is_error = true;
          this.error.email = "Email is required";
        }
        if(this.status == "" && !this.status){
          is_error = true;
          this.error.status = "Status is required";
        }
        if(this.branch == "" && !this.branch){
          is_error = true;
          this.error.branch = "Branch is required";
        }
        // if(this.temp_password.length > 30 ){
        //   is_error = true;
        //   this.error.temp_password = "Temporary password can't long then 30 charcaters";
        // }
        return is_error;
        // if( this.error.first_name || this.error.last_name || this.error.email || this.error.temp_password || this.error.status){
        //   return false;
        // }
      },
      async updateUser(){
        this.clearErrors();
        if(this.checkValidation()){
          return false;
        }
        let url = "/admin/users/"+this.id+"/update",payload = {
        first_name:this.first_name,
        last_name:this.last_name,
        email:this.email,
        temp_password:this.temp_password,
        status_id:this.status,
        branch_id:this.branch
        }
        this.axiosPost({url,data:payload})
        .then((response) => {
          if(response.data){
              this.$alert("User Updated !!");
              window.location.replace('/admin/users');
          }
          else{
              this.$alert("There's Problem updating user !!");
          }
        })
        .catch(({ response }) => {
          if(response.status == 422 ){
            if(response.data.errors.first_name){
              this.$toastr.e(response.data.errors.first_name);
            }
            if(response.data.errors.last_name){
              this.$toastr.e(response.data.errors.last_name);
            }
            if(response.data.errors.email){
              this.$toastr.e(response.data.errors.email);
            }
            if(response.data.errors.temp_password){
              this.$toastr.e(response.data.errors.temp_password);
            }
            if(response.data.errors.status_id){
              this.$toastr.e(response.data.errors.status_id);
            }
            if(response.data.errors.branch_id){
              this.$toastr.e(response.data.errors.branch_id);
            }
            
          }
        });
      },
      getBranches(){
        this.axiosGet("/admin/get-branches-for-form")
        .then((response) => {
          this.branches = response.data;
        })
        .catch(({ response }) => {
          console.log(response);
        });
      }
  },
  created() {
      this.dropDownImage = window.location.origin+'/images/chevron-down.svg';
      this.setUser();
      this.getBranches();
  },
};
</script>