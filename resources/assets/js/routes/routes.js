export default {
    path: '',
    component: require('./components/Products'),
    meta: {title: 'Product', icon: 'list'},
    hidden:false,
    children: [
        {
            path: '/products/all',
            hidden: false,
            name: 'product.list',
            component: require('./components/ProductList'),
            meta: {title: 'All Products'}
        },
        {
            path: '/products/create',
            hidden: false,
            name: 'product.create',
            component: require('./components/ProductFormAdd'),
            meta: {title: 'Register'}
        },
        {
            path: '/products/:id/edit',
            name: 'product.edit',
            hidden: true,
            component: require('./components/ProductFormEdit'),
            props: (route) => ({propProductId: route.params.id}),
            meta: {title: 'some other thing goes here'}
        }
    ]
}
