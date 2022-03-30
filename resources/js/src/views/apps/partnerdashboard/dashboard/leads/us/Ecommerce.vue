<template>
    <section id="dashboard-ecommerce">

        <!--Stat Cards-->
        <b-row class="match-height">
            <b-col
                    xl="4"
                    md="4"
            >
                <earnings-today :today-earnings="todayEarnings"
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
                <u-s-lead-list/>
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
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'


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
            ToastificationContent,

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
            this.fetchPartnerStatus();
            this.fetchDashboardData();
        },
        methods: {
            approvalModal() {
                this.$swal({
                    title: '<span class="font-weight-bolder">Approval <u>Required</u></span>',
                    icon: 'warning',
                    html:
                        '<p><small>  Contact your account manager: </small></p>'
                        + '<p><span class="font-weight-bolder small">Name:  Tom Jameson </span><br>'
                        + ' <span class="font-weight-bolder small">Email:  tom@uping.co.uk </span><br>'
                        + ' <span class="font-weight-bolder small">Skype:  live:.cid.aea911675f20a46c </span><br></p>',
                    showConfirmButton: false,
                    buttonsStyling: false,
                })
            },

            fetchDashboardData() {
                const userData = getUserData()
                this.userData = userData
                axios
                    .get(`/api/partner/getDashboardLeadDataPartner/us/${userData.id}`)
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
                    .catch((error) => {

                    });
            },
            fetchPartnerStatus() {
                const userData = getUserData()
                this.userData = userData
                axios
                    .get(`/api/partner/getPartnerStatusUS/${userData.id}`)
                    .then((response) => {
                        console.log(response.data)
                        debugger
                        if (response.data == 'Partner Active') {

                        } else if (response.data ==  'Partner Inactive') {
                            this.approvalModal()
                        }
                    })
                    .catch((error) => {
                        console.log(error)
                    })
            },
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/pages/dashboard-ecommerce.scss';
    @import '~@core/scss/vue/libs/chart-apex.scss';
</style>
