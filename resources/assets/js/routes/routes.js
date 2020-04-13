export default {
    path: '',
    component: require('./components/Products'),
    meta: { title: 'Product', icon: 'list'},
    children: [
        {
            path:'/products/all',
            name:'product.list',
            component: require('./components/ProductList'),
            meta: { title: 'All Products'}
        },
        {
            path:'/products/create',
            name:'product.create',
            component: require('./components/ProductFormAdd'),
            meta: { title: 'Register'}
        },
        {
            path:'/products/:id/edit',
            name:'product.create',
            component: require('./components/ProductFormEdit'),
        }
    ]
}