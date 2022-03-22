<template>
  <b-card-body>
    <div class="mt-4 mb-2 text-center">
      <b-card-text>Approved creatives. Click the creative to preview or download</b-card-text>
    </div>

    <!-- Swiper -->
      <b-table
          small
          :fields="fields"
          :items="offerData.creatives"
          responsive="sm"
          :small="true"
          :borderless="true"
          :striped="true"
      >
          <!-- A virtual column -->
          <template #cell(id)="data">
              {{ data.item.id }}
          </template>

          <!-- A custom formatted column -->
          <template #cell(name)="data">
              {{ data.item.name }}
          </template>


          <template #cell(status)="data">
              <b-badge
                  pill
                  variant="light-primary"
                  v-if="data.item.status == 1"
              >
                  Active
              </b-badge>
              <b-badge
                  pill
                  variant="light-primary"
                  v-else
              >
                  Inactive
              </b-badge>
          </template>

             <template #cell(view)="data">
              <b-badge
                  pill
                  variant="light-primary"
              >
                  View
              </b-badge>
          </template>



          <!-- A virtual composite column -->


          <!-- Optional default data cell scoped slot -->
          <template #cell()="data">
             View
          </template>
      </b-table>

  </b-card-body>
</template>

<script>
import {
  BCardBody, BCardText, BImg, BLink,  BTable,
    BProgress,
    BBadge,
} from 'bootstrap-vue'

export default {
  components: {
    BCardBody,
    BCardText,
    BImg,
    BLink,
      BTable,
      BProgress,
      BBadge,
    // 3rd Party
  },
    props: {
      offerData: {
          type: Object,
          required:true,
      }
    },
    data() {
        return {
            fields: [
                // A virtual column that doesn't exist in items
                'id',
                // A column that needs custom formatting
                { key: 'name', label: 'Name' },
                // A regular column
                { key: 'Type', label: 'Type' },
                { key: 'status', label: 'Status' },
                { key: 'view', label: 'View' },

            ],
            creativeData: {},
        }
    },



  setup() {


    return {
    }
  },
}
</script>

<style lang="scss">
@import '@core/scss/vue/libs/swiper.scss';
@import '~swiper/css/swiper.css';
</style>
