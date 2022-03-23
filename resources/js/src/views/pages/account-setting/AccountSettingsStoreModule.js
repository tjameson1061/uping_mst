import axios from '@axios'
import {getUserData} from '@/auth/utils'
const userData = getUserData()

export default {
  namespaced: true,
  state: {
      userData: {
          data: {},
      },



  },
  getters: {},
  mutations: {
      // setUserData: (state, survey) => {
      //     state.setUserData.data = survey.data;
      // },

  },
  actions: {
      getUserData(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .get(`/admin/getUserData/${id}`)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },

      updateAccountForm({commit}, userData) {
          return new Promise((resolve, reject) => {
            axios
              .patch(`/admin/updateAccountInfo/${userData.id}`, userData)
              .then(response => resolve(response))
              .catch(error => reject(error))
          })
      },
      updateCompanyInfo({commit}, userData) {
          return new Promise((resolve, reject) => {
          axios
              .patch(`/admin/updateCompanyInfo/${userData.id}`, userData)
              .then(response => resolve(response))
              .catch(error => reject(error))
      })
      },
      updateUserPaymentInfo({commit}, userData) {
          return new Promise((resolve, reject) => {
          axios
              .patch(`/admin/updatePaymentInfo/${userData.id}`, userData)
              .then(response => resolve(response))
              .catch(error => reject(error))
      })
      }
  },
}
