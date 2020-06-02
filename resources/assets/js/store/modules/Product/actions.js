import request from '../../utils/request'

export const loadProduct = (_, productId) => {
    return request.get('mum/products/' + productId)
}
