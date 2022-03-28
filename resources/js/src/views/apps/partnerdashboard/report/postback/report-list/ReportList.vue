<template>

  <div>

<!--    <report-list-add-new-->
<!--      :is-add-new-report-sidebar-active.sync="isAddNewReportSidebarActive"-->
<!--      :role-options="roleOptions"-->
<!--      :plan-options="planOptions"-->
<!--      @refetch-data="refetchData"-->
<!--    />-->

<!--    &lt;!&ndash; Filters &ndash;&gt;-->
<!--    <reports-list-filters-->
<!--      :role-filter.sync="roleFilter"-->
<!--      :plan-filter.sync="planFilter"-->
<!--      :status-filter.sync="statusFilter"-->
<!--      :role-options="roleOptions"-->
<!--      :plan-options="planOptions"-->
<!--      :status-options="statusOptions"-->
<!--    />-->

    <!-- Table Container Card -->
    <b-card
      no-body
      class="mb-0"
    >

      <div class="m-2">

        <!-- Table Top -->
        <b-row>

          <!-- Per Page -->
          <b-col
            cols="12"
            md="6"
            class="d-flex align-items-center justify-content-start mb-1 mb-md-0"
          >
            <label>Show</label>
            <v-select
              v-model="perPage"
              :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
              :options="perPageOptions"
              :clearable="false"
              class="per-page-selector d-inline-block mx-50"
            />
            <label>entries</label>
          </b-col>

          <!-- Search -->
          <b-col
            cols="12"
            md="6"
          >
            <div class="d-flex align-items-center justify-content-end">
              <b-form-input
                v-model="searchQuery"
                class="d-inline-block mr-1"
                placeholder="Search..."
              />
            </div>
          </b-col>
        </b-row>

      </div>

      <b-table
        ref="refReportListTable"
        class="position-relative"
        :items="fetchReports"
        responsive
        :fields="tableColumns"
        primary-key="id"
        :sort-by.sync="sortBy"
        show-empty
        empty-text="No matching records found"
        :sort-desc.sync="isSortDirDesc"
        :small="true"
        :borderless="true"
        :striped="true"
      >

        <!-- Column: offer_id -->
        <template #cell(offer_id)="data">
          <b-media vertical-align="center">

              {{ data.item.offer_id }}
          </b-media>
        </template>

          <!-- Column: conversion -->
          <template #cell(conversion)="data">
              <b-media vertical-align="center">
                  <template #aside>
                  </template>
                  <b-badge variant="light-success"
                           v-if="data.item.conversion == 1">
                      Conversion
                  </b-badge>
                  <b-badge v-else variant="light-warning">
                      No Conversion
                  </b-badge>
              </b-media>
          </template>

          <!-- Column: totalCost -->
          <template #cell(totalCost)="data">
              <b-media vertical-align="center">
                  <small v-if="data.item.offer_id == 1 || data.item.offer_id == 5 || data.item.offer_id == 6 ">
                      £ {{ data.item.totalCost }}
                  </small>
                  <small v-else>
                      $ {{ data.item.totalCost }}
                  </small>
              </b-media>
          </template>


          <!-- Column: Report -->
          <template #cell(transaction_id)="data">
              <b-media vertical-align="center">
                  <b-badge variant="light-primary">
                      {{ data.item.transaction_id }}

                  </b-badge>

              </b-media>
          </template>



      </b-table>
      <div class="mx-2 mb-2">
        <b-row>

          <b-col
            cols="12"
            sm="6"
            class="d-flex align-items-center justify-content-center justify-content-sm-start"
          >
            <span class="text-muted">Showing {{ dataMeta.from }} to {{ dataMeta.to }} of {{ dataMeta.of }} entries</span>
          </b-col>
          <!-- Pagination -->
          <b-col
            cols="12"
            sm="6"
            class="d-flex align-items-center justify-content-center justify-content-sm-end"
          >

            <b-pagination
              v-model="currentPage"
              :total-rows="totalReports"
              :per-page="perPage"
              first-number
              last-number
              class="mb-0 mt-1 mt-sm-0"
              prev-class="prev-item"
              next-class="next-item"
            >
              <template #prev-text>
                <feather-icon
                  icon="ChevronLeftIcon"
                  size="18"
                />
              </template>
              <template #next-text>
                <feather-icon
                  icon="ChevronRightIcon"
                  size="18"
                />
              </template>
            </b-pagination>

          </b-col>

        </b-row>
      </div>
    </b-card>
  </div>
</template>

<script>
import {
  BCard,
  BRow,
  BCol,
  BFormInput,
  BButton,
  BTable,
  BMedia,
  BAvatar,
  BLink,
  BBadge,
  BDropdown,
  BDropdownItem,
  BPagination,
} from 'bootstrap-vue'
import vSelect from 'vue-select'
import store from '@/store'
import { ref, onUnmounted } from '@vue/composition-api'
import { avatarText } from '@core/utils/filter'
import ReportsListFilters from './ReportListFilters.vue'
import useReportsList from './useReportList'
import reportStoreModule from '../ReportStoreModule'
import ReportListAddNew from './ReportListAddNew.vue'

export default {
  components: {
    ReportsListFilters,
    ReportListAddNew,

    BCard,
    BRow,
    BCol,
    BFormInput,
    BButton,
    BTable,
    BMedia,
    BAvatar,
    BLink,
    BBadge,
    BDropdown,
    BDropdownItem,
    BPagination,

    vSelect,
  },
  setup() {
    const PARTNER_REPORT = 'app-report'

    // Register module
    if (!store.hasModule(PARTNER_REPORT)) store.registerModule(PARTNER_REPORT, reportStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(PARTNER_REPORT)) store.unregisterModule(PARTNER_REPORT)
    })

    const isAddNewReportSidebarActive = ref(false)

    const roleOptions = [
      { label: 'Conver', value: 'admin' },
      { label: 'Author', value: 'author' },
      { label: 'Editor', value: 'editor' },
      { label: 'Maintainer', value: 'maintainer' },
      { label: 'Subscriber', value: 'subscriber' },
    ]

    const planOptions = [
      { label: 'Basic', value: 'basic' },
      { label: 'Company', value: 'company' },
      { label: 'Enterprise', value: 'enterprise' },
      { label: 'Team', value: 'team' },
    ]

    const statusOptions = [
      { label: 'Pending', value: 'pending' },
      { label: 'Active', value: 'active' },
      { label: 'Inactive', value: 'inactive' },
    ]

    const {
      fetchReports,
      tableColumns,
      perPage,
      currentPage,
      totalReports,
      dataMeta,
      perPageOptions,
      searchQuery,
      sortBy,
      isSortDirDesc,
      refReportListTable,
      refetchData,

      // UI
      resolveReportRoleVariant,
      resolveReportRoleIcon,
      resolveReportStatusVariant,

      // Extra Filters
      roleFilter,
      planFilter,
      statusFilter,
    } = useReportsList()

    return {
      // Sidebar
      isAddNewReportSidebarActive,

      fetchReports,
      tableColumns,
      perPage,
      currentPage,
      totalReports,
      dataMeta,
      perPageOptions,
      searchQuery,
      sortBy,
      isSortDirDesc,
      refReportListTable,
      refetchData,

      // Filter
      avatarText,

      // UI
      resolveReportRoleVariant,
      resolveReportRoleIcon,
      resolveReportStatusVariant,

      roleOptions,
      planOptions,
      statusOptions,

      // Extra Filters
      roleFilter,
      planFilter,
      statusFilter,
    }
  },
}
</script>

<style lang="scss" scoped>
.per-page-selector {
  width: 90px;
}
</style>

<style lang="scss">
@import '~@core/scss/vue/libs/vue-select.scss';
</style>
