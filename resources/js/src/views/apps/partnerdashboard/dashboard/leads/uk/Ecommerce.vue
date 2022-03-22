<template>
    <section id="dashboard-ecommerce">

        <!--Stat Cards-->
        <b-row class="match-height">
            <b-col
                xl="4"
                md="4"
            >
                <earnings-today  :today-earnings="todayEarnings"
                                 :lead-counts="leadCounts"
                                 :user-data="userData"
                                 title="Today"/>

            </b-col>
            <b-col
                xl="4"
                md="4"
            >
                <earnings-week :week-earnings="weekEarnings"
                               :lead-counts="leadCounts"
                               :user-data="userData"
                               title="Week"/>
            </b-col>
            <b-col
                xl="4"
                md="4"
            >
                <earnings-month :month-earnings="monthEarnings"
                                :lead-counts="leadCounts"
                                :user-data="userData"
                                title="Month"/>
            </b-col>
        </b-row>


        <!-- Revenue Report Card -->
        <b-col lg="12">
            <apex-line-area-chart :user-data="userData"/>
        </b-col>

        <!-- Affiliate Overview-->
        <b-row class="match-height">
            <b-col lg="12">
<!--               <report-list />-->
               <u-k-lead-list />
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
    import ReportList from "../../../report/uk/report-list/ReportList.vue";
    import UKLeadList from './../../../uk-lead/uk-lead-list/LeadList.vue'
    import axios from 'axios'




    export default {
        components: {
            ReportList,
            UKLeadList,
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
                todayRedirection: {},
                weekRedirection: {},
                monthRedirection: {},
                todayEarnings: {},
                weekEarnings: {},
                monthEarnings: {},
                affiliate_table_data: {},
                leadCounts: {},
                userData: {},
            }
        },
        created() {
            this.fetchDashboardData();
        },
        methods: {
            fetchDashboardData() {
                const userData = getUserData()
                this.userData = userData
                axios
                    .get(`/api/partner/getDashboardLeadDataPartner/uk/${userData.id}`)
                    .then((response) => {
                        this.todayEarnings = response.data.dashboard_data.todayEarnings;
                        this.todayRedirection = response.data.dashboard_data.redirectionToday;
                        this.weekEarnings = response.data.dashboard_data.weekEarnings;
                        this.weekRedirection = response.data.dashboard_data.redirectionWeek;
                        this.monthEarnings = response.data.dashboard_data.monthEarnings;
                        this.monthRedirection = response.data.dashboard_data.redirectionMonth;
                        this.affiliate_table_data = response.data.dashboard_data.affiliate_table_data;
                        this.leadCounts = response.data.dashboard_data.leadCounts;
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
