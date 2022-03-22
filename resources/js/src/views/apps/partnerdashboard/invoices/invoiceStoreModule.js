import axios from '@axios'
import {getUserData} from "@/auth/utils";
const userData = getUserData()

export default {
  namespaced: true,
  state: {},
  getters: {},
  mutations: {},
  actions: {
      fetchInvoices(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .get(`/partner/GetPartnerInvoiceData/${userData.id}`)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
    fetchInvoice(ctx, { id }) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/partner/invoices/${id}`)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      fetchBuyerInvoice(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .get(`/partner/invoices/${id}`)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
      fetchBuyerInvoices(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .get(`/partner/getBuyerInvoices/${id}`)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
      fetchTierInvoices(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .get(`/partner/getTierInvoices/${id}`)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
      fetchPartnerInvoices(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .get(`/partner/getPartnerInvoices/${id}`)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
      fetchAdvertiserInvoices(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .get(`/partner/getAdvertiserInvoices/${id}`)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
      fetchCompanyInvoices(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .get(`/partner/getCompanyInvoices/${id}`)
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
    fetchClients() {
      return new Promise((resolve, reject) => {
        axios
          .get('/partner/getAllCompanyData')
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
      deleteInvoice(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .delete(`/partner/invoices/${id}` )
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },
      sendInvoice(ctx, { id }) {
          return new Promise((resolve, reject) => {
              axios
                  .get(`/partner/sendInvoice/${id}` )
                  .then(response => resolve(response))
                  .catch(error => reject(error))
          })
      },

  },
}
