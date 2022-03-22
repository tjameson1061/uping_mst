<template>
    <b-card
        v-if="tableData"
        no-body
        class="card-company-table"
    >


        <b-table
            :items="tableData.dashboard_data.click_table_data"
            responsive
            :fields="fields"
            class="mb-0"
            :small="true"
            :borderless="true"
            :striped="true"
            :hover="true"
        >
            <!-- company -->
            <template #cell(offer_id)="data">
                <div class="d-flex align-items-center">
                    <div class="font-weight-bolder">


                        <b-badge variant="light-primary">
                            {{ data.item.offer_id }}
                        </b-badge>
                    </div>
                </div>
            </template>


            <!-- views -->
            <template #cell(conversion)="data">
                <div class="d-flex flex-column">
                    <small class="font-weight-bolder mb-25" v-if="data.item.conversion == '1'">
                           <b-badge variant="light-success">
                    Converted
                           </b-badge>
                    </small>
                    <span class="font-weight-bolder mb-25" v-else>
                    Not Converted
                    </span>
                    <!--          <span class="font-small-2 text-muted text-nowrap">{{ data.item.viewsub }}</span>-->
                </div>
            </template>
            <template #cell(totalCost)="data">
                <div class="d-flex flex-column">
                    <small class="font-weight-bolder mb-25" v-if="data.item.totalCost == null">

                        Not available
                    </small>
                <small class="font-weight-bolder mb-25" v-else>
                        £
                    {{ data.item.totalCost }}
                    </small>

                </div>

            </template>
            <template #cell(info)="data">
                <div class="d-flex flex-column">
                    <feather-icon
                        class="right"
                        :icon="data.item.loss ? 'TrendingDownIcon':'TrendingUpIcon'"
                        :class="data.item.loss ? 'text-danger':'text-success'"
                    />

                </div>

            </template>




        </b-table>
    </b-card>
</template>

<script>
    import {
        BCard, BTable, BAvatar, BImg, BBadge,
    } from 'bootstrap-vue'

    export default {
        components: {
            BCard,
            BTable,
            BAvatar,
            BImg,
            BBadge
        },
        props: {
            tableData: {
                type: Object,
                default: () => [],
            },
        },

        data() {
            return {
                fields: [
                    { key: 'offer_id', label: 'Offer ID' },
                    { key: 'conversion', label: 'Conversion' },
                    { key: 'totalCost', label: 'Commission' },
                ],
            }
        },
    }
</script>

<style lang="scss" scoped>
    @import '~@core/scss/base/bootstrap-extended/include';
    @import '~@core/scss/base/components/variables-dark';

    .card-company-table ::v-deep td .b-avatar.badge-light-company {
        .dark-layout & {
            background: $theme-dark-body-bg !important;
        }
    }
</style>
