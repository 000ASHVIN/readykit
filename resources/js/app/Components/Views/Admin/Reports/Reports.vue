<template>
  <div class="content-wrapper">
    <div class="row" style="margin-bottom: 30px;">
        <div class="col-sm-12 col-md-12">
            <h2 class="mb-0">Reports by Area</h2>
        </div>
    </div>
    

      <div class="row" v-for="area in areas" :key="area.id">
        
        <div class="col-md-12">
          <h4>{{ area.name }}</h4>

          <div v-if="area.branches.length > 0">
            <div class="row">
              <div class="card-box col-md-3" v-for="branch in area.branches" :key="branch.id">
                <div class="branch d-flex justify-content-between">
                  <span class="name">{{ branch.name }}</span>
                  <span>
                    <a :href="'/admin/water_readings/'+ branch.id +'/branch'" target="_blank"><img src="/images/icons/copy.png" alt=""></a>
                  </span>
                </div>
                <div class="card">
                  <div class="card-body">
                    <span class="total_houselot">{{ branch.total_houselot > 0 ? branch.total_houselot : 0 }}</span>
                    <span class="unit">Unit of Houses</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div v-else>
            <div>
              <p>No Branches are available</p>
            </div>
          </div>
        </div>
        
      </div>
  </div>
</template>

<script>
import { FormMixin } from "../../../../../core/mixins/form/FormMixin";
export default {
  name: "Reports",
  mixins: [FormMixin],
  components: {
  },
  props: {
    areas: [],
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
.branch .name {
  font-size: 18px;
  font-weight: 500;
}
.branch {
  padding: 0 5px;
  margin-bottom: 10px;
}
.total_houselot {
  padding: 5px 20px;
  border-radius: 5px;
  color: white;
  background: #19B5FE;
  font-weight: 500;
  margin-right: 10px;
}
.unit {
  font-weight: 500;
}
</style>