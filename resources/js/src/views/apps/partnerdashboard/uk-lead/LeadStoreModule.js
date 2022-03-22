import axios from '@axios'
import {getUserData} from '@/auth/utils'
const userData = getUserData()


export default {
  namespaced: true,
  state: {
      // loading
  },
  getters: {},
  mutations: {},
  actions: {
    fetchUKLeads(ctx, queryParams) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/partner/uk-lead/${userData.id}`, { params: queryParams })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    fetchUKLead(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/partner/uk-lead/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      getUkLeadLog(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/partner/getUkLeadLog/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      fetchFilterData(ctx, queryParams) {
          return new Promise((resolve, reject) => {
              axios
                  .get(`/partner/fetchFilterData/uk/${userData.id}`, { params: queryParams })
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },

  },
}
