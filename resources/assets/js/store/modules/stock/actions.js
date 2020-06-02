import axios from 'axios'

export const loadStock = ({commit}, stockId) => {
    axios.get('mauzo/stock/' + stockId).then(response => {
        commit('STOCK_ADDED', response.data.data)
    })
}