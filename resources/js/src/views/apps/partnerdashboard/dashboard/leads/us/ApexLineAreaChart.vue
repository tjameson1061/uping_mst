<template>
    <b-card no-body>
        <!--    <b-card-header>-->
        <!--      &lt;!&ndash; title and subtitle &ndash;&gt;-->
        <!--      <div>-->
        <!--        <b-card-title class="mb-1">-->
        <!--          Revenue Report-->
        <!--        </b-card-title>-->
        <!--        <b-card-sub-title>CLeads submissions</b-card-sub-title>-->
        <!--      </div>-->
        <!--      &lt;!&ndash;/ title and subtitle &ndash;&gt;-->

        <!--      &lt;!&ndash; datepicker &ndash;&gt;-->
        <!--      <div class="d-flex align-items-center">-->
        <!--        <feather-icon-->
        <!--          icon="CalendarIcon"-->
        <!--          size="16"-->
        <!--        />-->
        <!--        <flat-pickr-->
        <!--          v-model="rangePicker"-->
        <!--          :config="{ mode: 'range'}"-->
        <!--          class="form-control flat-picker bg-transparent border-0 shadow-none"-->
        <!--          placeholder="YYYY-MM-DD"-->
        <!--        />-->
        <!--      </div>-->
        <!--      &lt;!&ndash; datepicker &ndash;&gt;-->
        <!--    </b-card-header>-->

        <b-card-body>
            <vue-apex-charts
                type="area"
                height="400"
                :options="chartOptions"
                :series="series"
            />
            <!--        :series="lineAreaChartSpline.series"-->
        </b-card-body>
    </b-card>
</template>

<script>
    import {
        BCard,
        BCardHeader,
        BCardBody,
        BCardTitle,
        BCardSubTitle,
    } from "bootstrap-vue";
    import VueApexCharts from "vue-apexcharts";
    import flatPickr from "vue-flatpickr-component";
    import apexChatData from "./apexChartData";
    import axios from "axios";
    // import rangePicker
    import {getUserData} from '@/auth/utils'


    export default {
        components: {
            BCard,
            VueApexCharts,
            BCardHeader,
            BCardBody,
            BCardTitle,
            BCardSubTitle,
            flatPickr,
        },
        data() {
            return {
                apexChatData,
                rangePicker: ["2019-05-01", "2019-05-10"],
                chartData: {},
                dates: [],
                accepted: [],
                pending: [],
                rejected: [],
                userData: {},
                series : [],
            };
        },
        computed: {
            chartOptions() {
                return {
                    chart: {
                        toolbar: {
                            show: true,
                        },
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    stroke: {
                        show: true,
                        curve: "smooth",
                    },
                    legend: {
                        show: true,
                        position: "top",
                        horizontalAlign: "left",
                        fontSize: "14px",
                        fontFamily: "Montserrat",
                    },
                    grid: {
                        xaxis: {
                            lines: {
                                show: true,
                            },
                        },
                    },
                    xaxis: {
                        categories: this.dates,
                    },
                    yaxis: {
                        // opposite: isRtl
                    },
                    fill: {
                        opacity: 1,
                        type: "solid",
                    },
                    tooltip: {
                        shared: false,
                    },
                };
            },
        },
        created() {
            this.fetchChartData();
        },
        methods: {
            fetchChartData() {
                const userData = getUserData()
                axios
                    .get(`/api/partner/revenueChartUSData/${userData.id}`)
                    .then((response) => {
                        this.chartData = response.data;
                        this.dates = response.data.dates;
                        this.accepted = response.data.accepted;
                        this.pending = response.data.pending;
                        this.rejected = response.data.rejected;
                        this.series= [
                        {
                            name: "Accept",
                            data: this.chartData.accepted,
                        },
                        {
                            name: "Pending",
                            data: this.chartData.pending,
                        },
                        {
                            name: "Reject",
                            data: this.chartData.rejected,
                        },
                    ];
                    })
                    .catch((error) => console.log(error));
            },
        },
    };
</script>
