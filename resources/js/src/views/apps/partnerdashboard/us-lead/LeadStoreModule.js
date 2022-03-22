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
        fetchUSLeads(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .get(`/partner/us-lead/${userData.id}`, { params: queryParams })
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        fetchUSLead(ctx, { id }) {
            return new Promise((resolve, reject) => {
                axios
                    .get(`/partner/us-lead/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        getUSLeadLog(ctx, { id }) {
            return new Promise((resolve, reject) => {
                axios
                    .get(`/partner/getUSLeadLog/${id}`)
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },
        fetchFilterData(ctx, queryParams) {
            return new Promise((resolve, reject) => {
                axios
                    .get(`/partner/fetchFilterData/us/${userData.id}`, { params: queryParams })
                    .then(response => resolve(response))
                    .catch(error => reject(error))
            })
        },

    },
}
