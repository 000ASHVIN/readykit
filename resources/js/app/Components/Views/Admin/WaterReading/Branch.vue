<template>
  <data-table :columns="columns" :url="url" :per-page="['10', '20']" :order-by="created_at" :order-dir="desc" :classes="classes">
      <div slot="pagination" slot-scope="{ links = {}, meta = {} }" class="container mr-6">
        <nav class="row">
            <div class="col-md-6 text-left">
                <span>
                    Showing {{meta.from}} to {{meta.to}} of {{ meta.total }} Entries
                </span>
            </div>
            <div class="col-md-6 text-right">
                <button
                    :disabled="!links.prev"
                    class="btn btn-primary"
                    @click="url = links.prev">
                    Prev
                </button>
                <button
                    :disabled="!links.next"
                    class="btn btn-primary ml-2"
                    @click="url = links.next">
                    Next
                </button>
            </div>      
        </nav>
    </div>
  </data-table>
</template>

<script>
import Image from "./Images/Image.vue";
import TableButton from "./Buttons/TableButton.vue";
export default {
  // props: ["branch_id"],
  props:{
    branch_id:'',
    data:{

    },
  },
  components: {},
  mounted() {
    console.log('hasen',this.data);
  },
  methods: {
    
  },
  data() {
    return {

       classes: { 
                'table-container': {
                    'justify-center': true,
                    'w-full': true,
                    'flex': true,
                    'rounded': true,
                    'mb-6': true,
                    'shadow-md': true,
                },
                table: {
                    'text-left': true,
                    'w-full': true,
                    'border-collapse': true,
                },
                't-head': {
                    'text-grey-dark': true,
                    'bg-black': true,
                    'border-grey-light': true,
                    'py-4': true,
                    'px-6': true,
                },
                "t-body": {
                    'bg-grey-darkest': true,
                    
                },
                "t-head-tr": {
                    
                },
                "t-body-tr": {
                    'stripped-table': true,
                    'bg-grey-darkest': true,
                },
                "td": {
                    'datatable':true
                },
                "th": {
                },
            },
      
      url: "/admin/water_readings/list/" + this.branch_id,
      columns: [
       
        {
          label: "Area",
          name:'area',
          columnName: "area.name",
          searchable: true,
          orderable:true,
        },
        { label: "Branch",name:'branch', columnName: "branch.name", searchable: true,orderable:true },
        {
          label: "House Lot ",
          name: "house_lot_num",
          columnName: "house_lot.house_lot_num",
          searchable: true,
          orderable:true
        },
        { label: "S.N No.", name: "serial_num", columnName: "house_lot.serial_num",searchable: true,orderable:true },
        { label: "Last Reading (liter)", name: "last_reading", searchable: true , orderable:true },
        { label: "Current Reading (liter)", name: "current_reading", searchable: true ,orderable:true},
        { label: "Usage (liter)", name: "usage",searchable:false,orderable:true},
        { label: "Date Submitted", name: "created_at",orderable:true },
        {
          label: "Image",
          name: "image",
          orderable: false,
          searchable: false,
          component: Image,
        },
         {
          label: "User",
          name: "first_name",
          columnName:"users.first_name",
          searchable: true,
          orderable:true        
          },

        {label:'Action', name: 'action',component:TableButton},
      ],

    };
  },
  mounted() {
    console.log(this.url, this, branch_id);
  },
};
</script>

<style scoped>
.datatable.btn {
  height: 28px !important;
}
.datatable svg {
  height: 14px !important;
}

.datatable td {
  padding: 10px 30px 10px 15px;
  vertical-align: middle;
}
.datatable td:first-child {
  padding: 10px 30px;
}
</style>



