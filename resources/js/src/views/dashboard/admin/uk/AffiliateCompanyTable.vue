<template>
  <b-card
    v-if="tableData"
    no-body
    class="card-company-table"
  >
      <b-table
      :items="tableData"
      responsive
      :fields="fields"
      class="mb-0"
      :sticky-header="true"
      :noCollapse="true"
      :striped="true"
      :borderless="true"

    >
      <!-- company -->
      <template #cell(vid)="data">
        <div class="d-flex align-items-center">
            <div class="font-weight-bolder">


             <b-badge variant="light-primary">
                 {{data.item.vid}}
             </b-badge>
            </div>
            <div class="font-small-2 text-muted">
<!--              {{ data.item.subtitle }}-->
            </div>
          </div>
      </template>

      <!-- views -->
      <template #cell(leads_today)="data">
        <div class="d-flex flex-column">
          <span class="font-weight-bolder mb-25">   {{data.item.leads_today}}</span>
<!--          <span class="font-small-2 text-muted text-nowrap">123</span>-->
        </div>
      </template>

      <!-- revenue -->
      <template #cell(revenue_today)="data">
        {{ '£'+data.item.revenue_today.toFixed(2) }}
      </template>

        <!-- profit -->
        <template #cell(profit_today)="data">

            <span class="text-success bold">
                 {{ '£'+data.item.profit_today.toFixed(2) }}
            </span>
        </template>



      <!-- sales -->
      <template #cell(ratio_today)="data">
        <div class="d-flex align-items-center">
          <span class="font-weight-bolder mr-1">
              {{ data.item.ratio_today + '%' }}
          </span>
          <feather-icon
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
    tableData: []
  },

  data() {
    return {
      fields: [
        { key: 'vid', label: 'AFFILIATE' },
        { key: 'leads_today', label: 'LEADS' },
        { key: 'revenue_today', label: 'REVENUE' },
        { key: 'profit_today', label: 'PROFIT' },
        { key: 'ratio_today', label: 'RATIO' },
      ],
    }
  },
    // setup(props) {
    //   console.log('1-1--3-4004');
    //   console.log(props.tableData.dashboard_data);
    //   const affiliateTableData = props.tableData.dashboard_data.affiliate_table_data;
    
    //   return {
    //       affiliateTableData
    //   }
    // }
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
