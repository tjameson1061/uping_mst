<template>
    <b-card
        no-body
    >
        <b-card-header>
            <h4 class="mb-0">
               Today
            </h4>
            <b-card-text class="font-medium-5 mb-0">
                <feather-icon
                    icon="HelpCircleIcon"
                    size="21"
                    class="text-muted cursor-pointer"
                    v-ripple.400="'rgba(113, 102, 240, 0.15)'"
                    v-b-tooltip.hover.focus.v-primary
                    title="Earnings For Today"
                    variant="outline-primary"
                />
            </b-card-text>
        </b-card-header>

        <!-- apex chart -->
        <vue-apex-charts
            type="radialBar"
            height="200"
            class="my-2"
            :options="goalOverviewRadialBar"
            :series="[todayRedirection.redirected_ratio]"
        />
        <b-row class="text-center mx-0">
            <b-col
                cols="6"
                class="border-top border-right d-flex align-items-between flex-column py-1"
            >
                <b-card-text class="text-muted mb-0">
                   Leads
                </b-card-text>
                <h3 class="font-weight-bolder mb-0">
                    {{ leadCounts.today }}
                </h3>
            </b-col>

            <b-col
                cols="6"
                class="border-top d-flex align-items-between flex-column py-1"
            >
                <b-card-text class="text-muted mb-0">
                    Commission
                </b-card-text>
                <h3 class="font-weight-bolder mb-0">
                   £ {{ todayEarnings.today_total }}
                </h3>
            </b-col>
        </b-row>
    </b-card>
</template>


<script>
    import {
        BCard, BCardHeader, BRow, BCol, BCardText,VBTooltip
    } from 'bootstrap-vue'
    import VueApexCharts from 'vue-apexcharts'
    import { $themeColors } from '@themeConfig'
    import Ripple from 'vue-ripple-directive'
    const $strokeColor = '#ebe9f1'
    const $textHeadingColor = '#5e5873'
    const $goalStrokeColor2 = '#51e5a8'
    import {getUserData} from '@/auth/utils'
    import axios from 'axios'

    export default {
        components: {
            VueApexCharts,
            BCard,
            BCardHeader,
            BRow,
            BCardText,
            BCol,
            VBTooltip,
        },
        directives: {
            'b-tooltip': VBTooltip,
            Ripple,
        },
        props: {
            leadCounts: {
                type: Object,
                required:true,
            },
            todayEarnings: {
                type: Object,
                required:true,
            },
            userData: {
                type: Object,
                required:true,
            },
            title: {
                type: String,
                default: null,
            },
        },
        data() {
            return {
                todayRedirection: {
                    redirected_ratio :[0]
                },

                series: [10],
                goalOverviewRadialBar: {
                    chart: {
                        height: 180,
                        type: 'radialBar',
                        sparkline: {
                            enabled: true,
                        },
                        dropShadow: {
                            enabled: true,
                            blur: 3,
                            left: 1,
                            top: 1,
                            opacity: 0.1,
                        },
                    },
                    colors: [$goalStrokeColor2],
                    plotOptions: {
                        radialBar: {
                            offsetY: -10,
                            startAngle: -150,
                            endAngle: 150,
                            hollow: {
                                size: '77%',
                            },
                            track: {
                                background: $strokeColor,
                                strokeWidth: '100%',
                            },
                            dataLabels: {
                                name: {
                                    show: false,
                                },
                                value: {
                                    color: $textHeadingColor,
                                    fontSize: '1.86rem',
                                    fontWeight: '600',
                                },
                            },
                        },
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'dark',
                            type: 'horizontal',
                            shadeIntensity: 0.5,
                            gradientToColors: [$themeColors.success],
                            inverseColors: true,
                            opacityFrom: 1,
                            opacityTo: 1,
                            stops: [0, 100],
                        },
                    },
                    stroke: {
                        lineCap: 'round',
                    },
                    grid: {
                        padding: {
                            bottom: 30,
                        },
                    },
                },
            }
        },
        created() {
            this.fetchDashboardData();
        },
        methods: {
            fetchDashboardData() {
                axios
                    .get(`/api/partner/getDashboardLeadDataPartner/uk/${this.userData.id}`)
                    .then((response) => {
                        this.todayRedirection = response.data.dashboard_data.redirectionToday;
                    })
                    .catch((error) => console.log(error));
            },
        },
    }
</script>
