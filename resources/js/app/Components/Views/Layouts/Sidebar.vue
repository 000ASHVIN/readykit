<template>
    <sidebar :data="data"
             :logo-url="urlGenerator('/')"
             :logo-src="urlGenerator(logo)"
             :logo-icon-src="urlGenerator(logoIcon)"
             :is_admin="is_admin"
    />
</template>

<script>
import {urlGenerator} from "../../../Helpers/AxiosHelper";

export default {
    name: 'DashboardSidebar',
    props: {
        data: {
            required: true
        },
        logo: {
            type: String,
        },
        logoIcon: {
            type: String,
        },
        is_admin: ''
    },
    data() {
        return {
            urlGenerator,
        }
    }
}
</script>
