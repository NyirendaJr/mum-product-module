<template>
    <div class="component-wrap">
        <!-- search -->
        <v-card class="pt-3">
            <div class="d-flex flex-row">
                <div class="flex-grow-1 pa-2">
                    <v-btn
                        @click="$router.push({name:'product.create'})"
                        class="primary lighten-1"
                        dark>
                        New Product
                        <v-icon right dark>add</v-icon>
                    </v-btn>
                </div>
                <!--<div class="flex-grow-1 pa-2">-->
                <!--<v-chip label class="float-right" color="primary">-->
                <!--<v-icon left>assessment</v-icon>-->
                <!--{{ stock.stock_number }}-->
                <!--</v-chip>-->
                <!--</div>-->
            </div>
            <div class="d-flex flex-lg-row flex-sm-column">
                <div class="flex-grow-1 pa-2">
                    <v-text-field filled prepend-inner-icon="search" label="Filter By Name"
                                  v-model="filters.name">
                    </v-text-field>
                </div>
                <div class="flex-grow-1 pa-2">
                    <v-text-field filled prepend-inner-icon="search" label="Filter By Category"></v-text-field>
                </div>
            </div>
        </v-card>
        <!-- /search -->


        <v-divider class="pb-2"/>


        <!-- data table -->
        <v-data-table
            dense
            hide-default-header
            v-bind:headers="headers"
            :options.sync="pagination"
            :items="items"
            :server-items-length="totalItems"
            class="elevation-1">
            <template v-slot:header="{props:{headers}}">
                <thead>
                <tr>
                    <th v-for="(header, index) in headers" :key="index">
                        <div v-if="header.value=='mfg'" :class="`text-${header.align}`">
                            <v-icon>event</v-icon>
                            {{header.text}}
                        </div>
                        <div v-else-if="header.value=='exp'" :class="`text-${header.align}`">
                            <v-icon>event</v-icon>
                            {{header.text}}
                        </div>
                        <div v-else :class="`text-${header.align}`">{{header.text}}</div>
                    </th>
                </tr>
                </thead>
            </template>

            <template v-slot:body="{items}">
                <tbody>
                <tr v-for="item in items" :key="item.id">
                    <td>
                        <div class="d-flex align-content-space-around flex-wrap">
                            <v-btn
                                @click="$router.push({name:'product.edit' ,params:{id: item.id}})"
                                class="pa-1" small color="info">
                                <v-icon small>mdi-pencil</v-icon>
                            </v-btn>
<!--                            <v-btn @click="trash(item)" class="pa-1 ml-2" small color="red">-->
<!--                                <v-icon small>mdi-delete</v-icon>-->
<!--                            </v-btn>-->
                            <v-btn
                                @click="$router.push({name:'product.edit' ,params:{id: item.id}})"
                                class="pa-1" small color="info">
                                <v-icon small>mdi-eye</v-icon>
                            </v-btn>
                        </div>
                    </td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.category.name }}</td>
                    <!--<td>{{ $appFormatters.formatDate(item.mfg) }}</td>-->
                    <!--<td>{{ $appFormatters.formatDate(item.exp) }}</td>-->
                    <td>{{ item.buying_price }}</td>
                    <td>{{ item.selling_price }}</td>
                    <td>{{ item.stock.stock_number }}</td>
                    <td class="text-center">
                        <v-avatar outlined>
                            <v-icon v-if="item.is_active" class="green--text">check_circle</v-icon>
                            <v-icon class="red--text" v-else>error</v-icon>
                        </v-avatar>
                    </td>
                </tr>
                </tbody>
            </template>
        </v-data-table>
    </div>
</template>

<script>
    import {mapActions, mapState} from 'vuex'

    export default {
        props: {
            // propStockId: {
            //     required: true
            // }
        },
        data() {
            return {
                headers: [
                    {text: 'Action', value: false, align: 'left', sortable: false},
                    {text: 'Name', value: 'name', align: 'left', sortable: false},
                    {text: 'Category', value: 'category', align: 'left', sortable: false},
                    // { text: 'EXP', value: 'exp', align: 'left', sortable: false },
                    // { text: 'mfg', value: 'mfg', align: 'left', sortable: false },
                    {text: 'Buying Price (Tsh)', value: 'buying_price', align: 'left', sortable: false},
                    {text: 'Selling Price (Tsh)', value: 'selling_price', align: 'left', sortable: false},
                    {text: 'Stock', value: 'created_at', align: 'left', sortable: false},
                    {text: 'Active', value: 'active', align: 'center', sortable: false},
                ],
                items: [],
                totalItems: 0,
                pagination: {
                    itemsPerPage: 10
                },
                filters: {
                    name: '',
                    category: '',
                    mfg: '',
                    exp: '',
                    buying_price: '',
                    selling_price: '',
                    created_at: ''
                }
            }
        },
        mounted() {
            const self = this;
            self.$store.commit('setBreadcrumbs', [
                {label: 'Stock', to: {name: 'stock.list'}},
                {label: 'Products', to: ''}
            ])

            self.$eventBus.$on(['PRODUCT_DELETED'], () => {
                self.loadProducts(() => {
                })
            })

            self.loadProducts(() => {
            })

            //self.callToLoadStock()
        },

        computed: {

            //...mapState('stock', ['stock']),

            // compStockId () {
            //     return this.propStockId
            // },
        },

        watch: {
            pagination: {
                handler() {
                    this.loadProducts(() => {
                    });
                },
            },
            'filters.name': _.debounce(function () {
                const self = this;
                self.loadProducts(() => {
                });
            }, 700)
        },

        methods: {

            loadProducts(cb) {

                const self = this

                let params = {
                    name: self.filters.name,
                    //product_category_id: self.filters.category
                    page: self.pagination.page,
                    per_page: self.pagination.itemsPerPage,
                }

                axios.get('/mum/products', {params: params}).then(response => {
                    self.items = response.data.data.data;
                    self.totalItems = response.data.data.total;
                    self.pagination.totalItems = response.data.data.total
                });
            },

            trash(product) {
                const self = this

                self.$store.commit('showDialog', {
                    type: 'confirm',
                    icon: 'warning',
                    title: 'Confirm Deletion',
                    message: 'Are you sure you want to delete this product.?',
                    okCb: () => {

                        self.$store.commit('showLoader')

                        axios.delete('/mum/products/' + product.id).then(response => {
                            self.$store.commit('showSnackbar', {
                                message: 'Product deleted',
                                color: 'success',
                                duration: 3000
                            })

                            self.$eventBus.$emit('PRODUCT_DELETED')
                            self.$store.commit('hideLoader')

                        }).catch(error => {
                            self.$store.commit('hideLoader')

                            if (error.response) {
                                self.$store.commit('showSnackbar', {
                                    message: error.response.data.message,
                                    color: 'error',
                                    duration: 3000
                                })
                            } else if (error.request) {
                                console.log(error.request)
                            } else {
                                console.log('Error', error.message)
                            }
                        })
                    },
                    cancelCb: () => {
                        console.log('CANCEL')
                    }
                })
            }
        }
    }
</script>

<style scoped>

</style>
