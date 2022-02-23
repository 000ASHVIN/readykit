<template>
  <div class="content-wrapper">
    <div class="row">
      <div class="col-12 mb-primary">
        <div class="card card-with-shadow border-0 h-100">
          <div class="card-header p-primary bg-transparent">
            <h5 class="card-title m-0">Create Branch</h5>
          </div>
          <div class="card-body">
            <form class="mb-0">
              <div class="form-group row align-items-center">
                <label class="col-md-2 mb-md-0"> Branch Name </label>
                <div class="col-md-8">
                  <input
                    type="text"
                    name="inputs_name"
                    id="inputs_name"
                    placeholder="Type branch name"
                    autocomplete="off"
                    class="form-control"
                    v-model="name"
                  />
                  <div>
                    <small class="text-danger validation-error" v-if="this.error.name">
                      {{ this.error.name }}
                    </small>
                  </div>
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label class="col-md-2 mb-md-0"> Area </label>
                <div class="col-md-8">
                  <select
                    id="inputs_status"
                    class="custom-select"
                    :style='
                      "background-image: url("+dropDownImage+");"
                    '
                    v-model="area"
                  >
                    <option value="">Select Area</option>
                    <option :value="area.id" v-for="area in areas" :key="area.id"> {{ area.name }}</option>
                  </select>
                  <div>
                    <small class="text-danger validation-error" v-if="this.error.area">
                      {{ this.error.area }}
                    </small>
                  </div>
                </div>
              </div>
              <div class="mt-5 action-buttons">
                <a @click="createBranch" class="btn btn-primary mr-2">
                  Add Branch
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
  name: "CreateBranch",
  mixins: [FormMixin],
  components: {},
  data() {
    return {
        id:'',
        name:'',
        area:'',
        areas:[],
        dropDownImage:'',
        error:{
          name:'',
          area:''
        }
    };
  },
  methods: {
      clearErrors(){
        this.error.name ='';
        this.error.area ='';
      },
      checkValidation(){
        let is_error = false;
        if(this.name == "" && !this.name){
          is_error = true;
          this.error.name = "Name is required";
        }
        if(this.area == "" && !this.area){
          is_error = true;
          this.error.area = "Area is required";
        }
        return is_error;
      },
      async createBranch(){
        this.clearErrors();
        if(this.checkValidation()){
          return false;
        }
        let url = "/admin/branches/create",
        payload = {
        name:this.name,
        area_id:this.area
        }
        this.axiosPost({url,data:payload})
        .then((response) => {
          if(response.data){
              this.$alert("Branch created !!");
              window.location.replace('/admin/branches');
          }
          else{
              this.$alert("There's Problem creating Branch !!");
          }
        })
        .catch(({ response }) => {
          if(response.status == 422 ){
            if(response.data.errors.name){
              this.$toastr.e(response.data.errors.name);
            }
          }
        });
      },
      getAreas(){
        this.axiosGet("/admin/get-areas-for-form")
        .then((response) => {
          this.areas = response.data;
        })
        .catch(({ response }) => {
          console.log(response);
        });
      }
  },
  created(){
    this.dropDownImage = window.location.origin+'/images/chevron-down.svg';
    this.getAreas();
  }
};
</script>