import Vue from 'vue'

// axios
import axios from 'axios'

const axiosIns = axios.create({
  // You can add your headers here
  // ================================
  baseURL: 'https://portal.uping.co.uk/api/', //1
  // baseURL: 'http://127.0.0.1:8000/api/',
  timeout: 1000,
  // headers: {'X-Custom-Header': 'foobar'}
})

Vue.prototype.$http = axiosIns

export default axiosIns
