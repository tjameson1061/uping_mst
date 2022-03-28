<template>
    <section id="dashboard-ecommerce">

        <!--Stat Cards-->
        <b-row class="match-height">
            <b-col
                xl="4"
                md="4"
            >
                <earnings-today  v-if="userData"
                                 :data="data.dashboard_data" v-if="data.dashboard_data"
                                 :user-data="userData"
                                 title="Today"/>

            </b-col>
<!--                                 :today-earnings="todayEarnings"-->
<!--                                 :lead-counts="leadCounts"-->
            <b-col
                xl="4"
                md="4"
            >
<!--                <earnings-week :week-earnings="weekEarnings"-->
<!--                               :lead-counts="leadCounts"-->
<!--                               :user-data="userData"-->
<!--                               title="Week"/>-->
<!--            </b-col>-->
<!--            <b-col-->
<!--                xl="4"-->
<!--                md="4"-->
<!--            >-->
<!--                <earnings-month :month-earnings="monthEarnings"-->
<!--                                :lead-counts="leadCounts"-->
<!--                                :user-data="userData"-->
<!--                                title="Month"/>-->
<!--            </b-col>-->
        </b-row>


        <!-- Revenue Report Card -->
        <b-col lg="12">
            <apex-line-area-chart :user-data="userData"/>
        </b-col>

        <!-- Affiliate Overview-->
        <b-row class="match-height">
            <b-col lg="12">

               <u-s-lead-list />
            </b-col>


        </b-row>
    </section>
</template>

<script>
    import {BRow, BCol} from 'bootstrap-vue'

    import {getUserData} from '@/auth/utils'
    import EcommerceMedal from './EcommerceMedal.vue'
    import EcommerceRevenueReport from './EcommerceRevenueReport.vue'
    import EcommerceOrderChart from './EcommerceOrderChart.vue'
    import EcommerceProfitChart from './EcommerceProfitChart.vue'
    import CompanyTable from './CompanyTable.vue'
    import LenderCompanyTable from './LenderCompanyTable.vue'
    import AffiliateRedirectRates from './AffiliateRedirectRates.vue'
    import LenderRedirectRates from './LenderRedirectRates.vue'
    import RedirectionTotalOverview from './RedirectionTotalOverview.vue'
    import ApexLineAreaChart from "./ApexLineAreaChart.vue";

    import CardAnalyticGoalOverview from './CardAnalyticGoalOverview'

    import EarningsToday from "./EarningsToday.vue";
    import EarningsWeek from "./EarningsWeek.vue";
    import EarningsMonth from "./EarningsMonth.vue";
    import EarningsProfit from "./EarningsProfit.vue";
    import ReportList from "../../../report/us/report-list/ReportList.vue";
    import USLeadList from '../../../us-lead/us-lead-list/LeadList.vue'
    import axios from 'axios'




    export default {
        components: {
            ReportList,
            USLeadList,
            ApexLineAreaChart,
            BRow,
            BCol,

            EcommerceMedal,
            EcommerceRevenueReport,
            EcommerceOrderChart,
            EcommerceProfitChart,
            CompanyTable,
            LenderCompanyTable,
            AffiliateRedirectRates,
            LenderRedirectRates,
            RedirectionTotalOverview,

            EarningsToday,
            EarningsWeek,
            EarningsMonth,
            EarningsProfit,
            CardAnalyticGoalOverview,


        },
        data() {
            return {
                data: {},
                // weekRedirection: {},
                // monthRedirection: {},
                // todayEarnings: {},
                // weekEarnings: {},
                // monthEarnings: {},
                // affiliate_table_data: {},
                // leadCounts: {},
                userData: {},
            }
        },
        created() {
            this.fetchDashboardData();
        },
        data() {
            return {
                data: {
                    dashboard_data : {affiliate_table_data : [],
                        todayEarnings : {redirection : { redirected_ratio : []},today_revenue : 0 },
                        weekEarnings :  {redirection : { redirected_ratio : []},week_revenue : 0 },
                        monthEarnings :  {redirection : { redirected_ratio : []},month_revenue : 0 },
                        profitEarnings :  {redirection : { redirected_ratio : []},profit : 0 },
                        lead_count : {today : 0, week :0 , month : 0},

                    }
                },
            }
        },

        methods: {
            fetchDashboardData() {
                const userData = getUserData()
                this.userData = userData
                axios
                    .get(`/api/partner/getDashboardLeadDataPartner/us/${userData.id}`)
                    .then((response) => {
                        // this.todayEarnings = response.data.dashboard_data.todayEarnings;
                        // this.todayRedirection = response.data.dashboard_data.redirectionToday;
                        // this.weekEarnings = response.data.dashboard_data.weekEarnings;
                        // this.weekRedirection = response.data.dashboard_data.redirectionWeek;
                        // this.monthEarnings = response.data.dashboard_data.monthEarnings;
                        // this.monthRedirection = response.data.dashboard_data.redirectionMonth;
                        // this.affiliate_table_data = response.data.dashboard_data.affiliate_table_data;
                        // this.leadCounts = response.data.dashboard_data.leadCounts;
                        this.data = response.data

                    })
                    .catch((error) => console.log(error));
            },
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/pages/dashboard-ecommerce.scss';
    @import '~@core/scss/vue/libs/chart-apex.scss';
</style>
