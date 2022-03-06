<template>
<button  type="button" class="btn btn-primary table-btn mr-2 mb-2 mb-sm-0" data-toggle="modal"
        @click="click(data)"
        data-target="#exampleModal">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
        </svg>
    </button>
    <!-- <button
        type="button"
        >
        View Row {{ data.id }} Modal
    </button> -->
</template>
<script>
export default {
    props: {
        data: {},
        name: {},
        click: {},
        meta: {},
        classes: {},
    },
}
</script>