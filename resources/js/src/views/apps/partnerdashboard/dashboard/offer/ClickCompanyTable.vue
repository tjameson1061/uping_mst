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
      <template #cell(vid)="data">
        <div class="d-flex align-items-center">
            <div class="font-weight-bolder">


                <b-badge :variant="'light-primary'">
                    {{ data.item.aff_click_id }}
                </b-badge>
            </div>
            <div class="font-small-2 text-muted">
<!--              {{ data.item.subtitle }}-->
            </div>
          </div>
      </template>


      <!-- views -->
      <template #cell(ip)="data">
        <div class="d-flex flex-column">
          <small class="font-weight-bolder mb-25">{{ data.item.ip }}</small>
        </div>
      </template>
        <template #cell(aff_sub)="data">
            <div class="d-flex flex-column">
                <small class="font-weight-bolder mb-25">{{ data.item.aff_sub }}</small>
            </div>
        </template>
        <template #cell(aff_sub2)="data">
            <div class="d-flex flex-column">
                <small class="font-weight-bolder mb-25">{{ data.item.aff_sub2 }}</small>
            </div>
        </template>
        <template #cell(aff_sub3)="data">
            <div class="d-flex flex-column">
                <small class="font-weight-bolder mb-25">{{ data.item.aff_sub3 }}</small>
            </div>
        </template>
        <template #cell(aff_sub4)="data">
            <div class="d-flex flex-column">
                <small class="font-weight-bolder mb-25">{{ data.item.aff_sub4 }}</small>
            </div>
        </template>
        <template #cell(aff_sub5)="data">
            <div class="d-flex flex-column">
                <small class="font-weight-bolder mb-25">{{ data.item.aff_sub5 }}</small>
                <!--          <small class="font-small-2 text-muted text-nowrap">{{ data.item.viewsub }}</span>-->
            </div>
        </template>






      <!-- sales -->
      <template #cell(ratio)="data">
        <div class="d-flex align-items-center">
          <span class="font-weight-bolder mr-1">{{ data.item.sales+'%' }}</span>
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
    tableData: {
      type: Object,
      default: () => [],
    },
  },

  data() {
    return {
      fields: [
        { key: 'aff_click_id', label: 'Click ID' },
        { key: 'ip', label: 'IP Address' },
        { key: 'aff_sub', label: 'aff_sub' },
        { key: 'aff_sub2', label: 'aff_sub2' },
        { key: 'aff_sub3', label: 'aff_sub3' },
        { key: 'aff_sub4', label: 'aff_sub4' },
        { key: 'aff_sub5', label: 'aff_sub5' },
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
