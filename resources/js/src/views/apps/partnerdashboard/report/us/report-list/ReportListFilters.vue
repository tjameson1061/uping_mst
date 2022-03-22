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


                    <label>SUB ID  </label>
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :value="subIdFilter"
                        :options="subIdData"
                        label="subid"
                        class="w-100"
                        :reduce="val => val.subid"
                        @input="(val) => $emit('update:subIdFilter', val)"
                    />
                </b-col>
                <b-col
                    cols="12"
                    md="2"
                    class="mb-md-0 mb-2"
                >
                    <label>TIER ID</label>
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :value="tierFilter"
                        :options="tierIdData"
                        label="tier"
                        class="w-100"
                        :reduce="val => val.tier"
                        @input="(val) => $emit('update:tierFilter', val)"
                    />
                </b-col>
                <b-col
                    cols="12"
                    md="2"
                    class="mb-md-0 mb-2"
                >
                    <label>Vendor Price</label>
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :value="vendorPriceFilter"
                        :options="vendorLeadPriceData"
                        label="vidLeadPrice"
                        class="w-100"
                        :reduce="val => val.vidLeadPrice"
                        @input="(val) => $emit('update:vidLeadPriceFilter', val)"
                    />
                </b-col>
                <b-col
                    cols="12"
                    md="3"
                    class="mb-md-0 mb-2"
                >
                    <label>Status</label>
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :value="statusFilter"
                        :options="statusOptions"
                        class="w-100"
                        :reduce="val => val.value"
                        @input="(val) => $emit('update:statusFilter', val)"
                    />
                </b-col>
                <b-col
                    cols="12"
                    md="3"
                    class="mb-md-0 mb-2"
                >
                    <label>Redirection</label>
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :value="redirectionFilter"
                        :options="redirectionOptions"
                        class="w-100"
                        :reduce="val => val.value"
                        @input="(val) => $emit('update:redirectionFilter', val)"
                    />
                </b-col>
            </b-row>
        </b-card-body>
    </b-card>
</template>

<script>
    import { BCard, BCardHeader, BCardBody, BRow, BCol } from 'bootstrap-vue'
    import vSelect from 'vue-select'

    export default {
        components: {
            BRow,
            BCol,
            BCard,
            BCardHeader,
            BCardBody,
            vSelect,
        },
        props: {
            subIdFilter: {
                type: [String, null],
                default: null,
            },
            tierFilter: {
                type: [Number, null],
                default: null,
            },
            vendorPriceFilter: {
                type: [Number, null],
                default: null,
            },
            statusFilter: {
                type: [Number, null],
                default: null,
            },
            redirectionFilter: {
                type: [Number, null],
                default: null,
            },

            redirectionOptions: {
                type: Array,
                required: true,
            },
            statusOptions: {
                type: Array,
                required: true,
            },
            subIdData: {
                type: Array,
                required: true,
            },
            tierIdData: {
                type: Array,
                required: true,
            },
            vendorLeadPriceData: {
                type: Array,
                required: true,
            },
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';
</style>
