import $axios from '../api'

const state = () => ({
    sales_orders: [],
    page:1,
})

const mutations = {}

const actions = {
    getSalesOrder({commit, state}, payload) {
        //MENGECEK PAYLOAD ADA ATAU TIDAK
        let search = typeof payload != 'undefined' ? payload : ''
        return new Promise((resolve, reject) => {
            //REQUEST DATA DENGAN ENDPOINT /OUTLETS
            $axios.get(`/marketing/sales_order?page=${state.page}&q=${search}`)
                .then((response) => {
                    //SIMPAN DATA KE STATE MELALUI MUTATIONS
                    commit('ASSIGN_DATA', response.data)
                    resolve(response.data)
                })
        })
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
