<template>
    <b-card no-body>
        <b-card-header class="pb-50">
            <h5>
                Filters
            </h5>
        </b-card-header>
        <b-card-body>
            <b-row>
                <b-col
                    cols="12"
                    md="2"
                    class="mb-md-0 mb-2"
                >
                    <label>AFF ID</label>
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :value="affIdFilter"
                        :options="filterData.vendor_ids"
                        label="vendor_id"
                        class="w-100"
                        :reduce="val => val.value"
                        @input="(val) => $emit('update:affIdFilter', val)"
                    />
                </b-col>
                <b-col
                    cols="12"
                    md="3"
                    class="mb-md-0 mb-2"
                >
                    <label>Conversion</label>
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :value="conversionFilter"
                        :options="conversionOptions"
                        class="w-100"
                        :reduce="val => val.value"
                        @input="(val) => $emit('update:conversionFilter', val)"
                    />
                </b-col>

            </b-row>
        </b-card-body>
    </b-card>
</template>

<script>
    import {BCard, BCardHeader, BCardBody, BRow, BCol, BFormSelect} from 'bootstrap-vue'
    import vSelect from 'vue-select'

    export default {
        components: {
            BRow,
            BCol,
            BCard,
            BCardHeader,
            BCardBody,
            BFormSelect,
            vSelect,
        },
        props: {
            affIdFilter: {
                type: [Number, null],
                default: null,
            },
            conversionFilter: {
                type: [Number, null],
                default: null,
            },
            statusFilter: {
                type: [String, null],
                default: null,
            },

            filterData: {
                type: [Object, null],
                required: true,
            },
            conversionOptions: {
                type: Array,
                required: true,
            },

        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
