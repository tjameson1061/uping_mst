import axios from '@axios'
import {getUserData} from "@/auth/utils";
const userData = getUserData()

export default {
  namespaced: true,
  state: {},
  getters: {},
  mutations: {},
  actions: {
      fetchReports(ctx, queryParams) {
          return new Promise((resolve, reject) => {
              axios
                  .get(`/partner/getUKReports/${userData.id}`,  { params: queryParams })
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
