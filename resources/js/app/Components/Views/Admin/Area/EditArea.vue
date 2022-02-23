<template>
  <div class="content-wrapper">
    <div class="row">
      <div class="col-12 mb-primary">
        <div class="card card-with-shadow border-0 h-100">
          <div class="card-header p-primary bg-transparent">
            <h5 class="card-title m-0">Edit Area</h5>
          </div>
          <div class="card-body">
            <form class="mb-0">
              <div class="form-group row align-items-center">
                <label class="col-md-2 mb-md-0"> Area Name </label>
                <div class="col-md-8">
                  <input
                    type="text"
                    name="inputs_name"
                    id="inputs_name"
                    placeholder="Type area name"
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
              <div class="mt-5">
                <button @click="updateArea" class="btn btn-primary mr-2">
                  Update Area
                </button>
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
  name: "EditArea",
  mixins: [FormMixin],
  props: {
    area: {
      type: Object,
      required: true
    }
  },
  components: {},
  data() {
    return {
        id:'',
        name:'',
        error:{
          name:''
        }
    };
  },
  methods: {
      clearErrors(){
        this.error.name ='';
      },
      setArea(){
          this.id=this.area.id;
          this.name=this.area.name;
      },
      checkValidation(){
        let is_error = false;
        if(this.name == "" && !this.name){
          is_error = true;
          this.error.name = "Name is required";
        }
        return is_error;
      },
      async updateArea(){
        this.clearErrors();
        if(this.checkValidation()){
          return false;
        }
        let url = "/admin/areas/"+this.id+"/update",payload = {
        name:this.name
        }
        this.axiosPost({url,data:payload})
        .then((response) => {
          if(response.data){
              this.$alert("area Updated !!");
              window.location.replace('/admin/areas');
          }
          else{
              this.$alert("There's Problem updating area !!");
          }
        })
        .catch(({ response }) => {
          if(response.status == 422 ){
            if(response.data.errors.name){
              this.$toastr.e(response.data.errors.name);
            }
          }
        });
      }
  },
  created() {
      this.setArea();
  },
};
</script>