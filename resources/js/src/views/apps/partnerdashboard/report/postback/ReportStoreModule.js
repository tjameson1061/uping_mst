import axios from '@axios'
import {getUserData} from "@/auth/utils";
const userData = getUserData()

export default {
  namespaced: true,
  state: {},
  getters: {},
  mutations: {},
  actions: {
    fetchReports(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
            .get(`/partner/getPostbackReports/${userData.id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
  },
}
