<template>
    <a :href="data.image" target="_blank">Image</a>
</template>
<script>
export default {
  props:{
      meta:{
      },
      name:{

      },
      value:{

      },
      data:{

      },
  },
  created(){
     
      console.log(this.data)
  }    
}
</script>