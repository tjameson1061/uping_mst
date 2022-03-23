import axios from '@axios'

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
