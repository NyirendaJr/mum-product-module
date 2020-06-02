import state from './state'
import getters from './getters'
import actions from './actions'
import mutations from './mutations'
import Product from './modules/Product'


export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
    modules: {
        Product
    }
}