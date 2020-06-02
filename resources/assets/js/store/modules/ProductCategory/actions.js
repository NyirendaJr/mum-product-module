import request from '../../utils/request'

export const loadProductCategories = ({state, commit}) => {
    request.get('/mauzo/product_categories').then(response => {
        //console.log(response.data.data.data)
        commit('SET_PRODUCT_CATEGORY', response.data.data.data)
    })
}
