<template>
  <b-card no-body>


    <b-card-body>
      <vue-apex-charts
        type="area"
        height="400"
        :options="chartOptions"
        :series="series.series"
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
      clicks: [],
      conversions: [],
      revenue: [],
        userData: {},
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
    series() {
      return {
        series: [
          {
            name: "Clicks",
            data: this.chartData.clicks,
          },
          {
            name: "Conversions",
            data: this.chartData.conversions,
          },
          {
            name: "Revenue",
            data: this.chartData.revenue,
          },
        ],
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
        .get(`/api/admin/revenueOfferChartData`)
        .then((response) => {
            // console.log(response)
            // debugger
          this.chartData = response.data;
          this.dates = response.data.dates;
          this.clicks = response.data.clicks;
          this.conversions = response.data.conversions;
          this.revenue = response.data.revenue;
        })
        .catch((error) => console.log(error));
    },
  },
};
</script>
