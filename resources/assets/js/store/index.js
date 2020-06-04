import state from './state'
import getters from './getters'
import actions from './actions'
import mutations from './mutations'
import Product from './modules/Product'
import Brand from './modules/Brand'
import ProductCategory from './modules/ProductCategory'

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
    modules: {
        Product,
        Brand,
        ProductCategory
    }
}
