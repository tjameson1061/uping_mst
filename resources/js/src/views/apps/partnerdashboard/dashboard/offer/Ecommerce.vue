<template>
    <section id="dashboard-ecommerce">

        <b-row>
            <b-col
                    lg="4"
                    sm="4"
            >
                <statistic-card-horizontal
                        icon="NavigationIcon"
                        v-if="dashboardData.dashboard_data"
                        :statistic="dashboardData.dashboard_data.todayMetrics.original.today_metrics.clicks"
                        statistic-title="Clicks"


                />
            </b-col>
            <b-col
                    lg="4"
                    sm="4"
            >
                <statistic-card-horizontal
                        v-if="dashboardData.dashboard_data"
                        icon="ActivityIcon"
                        color="secondary"
                        :statistic="dashboardData.dashboard_data.todayMetrics.original.today_metrics.conversions"
                        statistic-title="Conversions"  />
            </b-col>
            <b-col
                    lg="4"
                    sm="4"
            >
                <profit-statistic-card-horizontal
                        icon="DollarSignIcon"
                        color="info"
                        :statistic="dashboardData.dashboard_data.todayMetrics.original.today_metrics.revenue"
                        statistic-title="Revenue"
                />
            </b-col>

        </b-row>


        <!-- Revenue Report Card -->
        <b-col lg="12">
            <apex-line-area-chart />
        </b-col>

        <!-- Affiliate Overview-->
        <b-row class="match-height">
            <b-col lg="12">
                <click-company-table :table-data="dashboardData" />
            </b-col>


        </b-row>
    </section>
</template>

<script>
    import { BRow, BCol } from 'bootstrap-vue'

    import EcommerceMedal from './EcommerceMedal.vue'
    import EcommerceStatistics from './EcommerceStatistics.vue'
    import EcommerceRevenueReport from './EcommerceRevenueReport.vue'
    import EcommerceOrderChart from './EcommerceOrderChart.vue'
    import EcommerceProfitChart from './EcommerceProfitChart.vue'
    import EcommerceEarningsChart from './EcommerceEarningsChart.vue'
    import ClickCompanyTable from './ClickCompanyTable.vue'
    import ConversionCompanyTable from './ConversionCompanyTable.vue'
    import EcommerceMeetup from './EcommerceMeetup.vue'
    import LenderRedirectRates from './LenderRedirectRates.vue'
    import EcommerceTransactions from './EcommerceTransactions.vue'
    import ApexLineAreaChart from "./ApexLineAreaChart";
    import StatisticCardHorizontal from './StatisticCardHorizontal.vue'
    import ProfitStatisticCardHorizontal from './ProfitStatisticCardHorizontal.vue'
    import {getUserData} from '@/auth/utils'


    export default {
        components: {
            ApexLineAreaChart,
            BRow,
            BCol,

            EcommerceMedal,
            EcommerceStatistics,
            EcommerceRevenueReport,
            EcommerceOrderChart,
            EcommerceProfitChart,
            EcommerceEarningsChart,
            ClickCompanyTable,
            ConversionCompanyTable,
            EcommerceMeetup,
            LenderRedirectRates,
            EcommerceTransactions,
            StatisticCardHorizontal,
            ProfitStatisticCardHorizontal,


        },
        data() {
            return {
                dashboardData: { dashboard_data : { todayMetrics : { header : [], original : { today_metrics : {}}}}},
                userData: {},
            }
        },
        created() {
            // data
            const userData = getUserData()


            this.$http.get(`/partner/getDashboardOfferDataPartner/${userData.id}`).then(response => {
                this.dashboardData = response.data

                // ? Your API will return name of logged in user or you might just directly get name of logged in user
                // ? This is just for demo purpose
                // const userData = getUserData()
                // this.data.congratulations.name = userData.fullName.split(' ')[0] || userData.username
            })
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/pages/dashboard-ecommerce.scss';
    @import '~@core/scss/vue/libs/chart-apex.scss';
</style>
