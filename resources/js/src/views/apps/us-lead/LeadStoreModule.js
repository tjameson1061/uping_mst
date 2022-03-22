import axios from '@axios'

export default {
  namespaced: true,
  state: {},
  getters: {},
  mutations: {},
  actions: {
    fetchUSLeads(ctx, queryParams) {
      return new Promise((resolve, reject) => {
        axios
          .get('/admin/us-lead', { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    fetchUSLead(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/admin/us-lead/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      getUsLeadLog(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/admin/getUsLeadLog/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      fetchFilterData(ctx, queryParams) {
          return new Promise((resolve, reject) => {
              axios
                  .get('/admin/fetchFilterUSData', { params: queryParams })
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },

  },
}
