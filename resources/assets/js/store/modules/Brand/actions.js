import request from "../../utils/request"

export const loadProductBrands = ({commit}) => {
    request.get('/mum/product_brands').then(response => {
        let brandArray = []
        response.data.data.data.map(brandName => {
            brandArray.push(brandName.name)
        })
        //console.log(brandArray)
        commit('SET_BRAND', brandArray)
    })
}
