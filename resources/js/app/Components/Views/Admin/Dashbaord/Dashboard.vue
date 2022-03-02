<template>
  <div class="content-wrapper">
    <div class="row" style="margin-bottom: 30px;">
        <div class="col-sm-12 col-md-12">
            <h2 class="mb-0">Dashboard</h2>
        </div>
    </div>
    <div class="row">
      <div class="card-box col-md-3" v-for="branch in branches" :key="branch.id">
        <div class="card">
          <div class="card-body">
            <div class="card-img text-center">
              <img class="" src="/images/logo.png" alt="Card image cap">
            </div>
            
            <p>Area: <span class="area-name text-danger">{{ branch.area ? branch.area.name : '-' }}</span></p>
            <p>Branch: <a :href="'/admin/water_readings/'+ branch.id +'/branch'" target="_blank">{{ branch.name }}</a></p>
            <p><span class="text-danger">{{ branch.house_lot ? branch.house_lot.length : 0 }}</span> of Housing</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { FormMixin } from "../../../../../core/mixins/form/FormMixin";
export default {
  name: "Dashboard",
  mixins: [FormMixin],
  components: {
  },
  props: {
    branches: [],
  },
  data() {
    return {
    };
  },
  methods: {
    
  },
  mounted() {
    // console.log(this.branches)
  },
};
</script>

<style scoped>
.card-box {
  margin-bottom: 30px;
}
.card-body img {
  max-width: 150px;
  margin-bottom: 35px;
}
.card-body p {
  margin-bottom: 0;
}
</style>