<template>
    <div class="component-wrap">
        <v-card>
            <div class="d-flex flex-row">
                <div class="flex-grow-1 pa-2">
                    <v-icon>mdi-pencil</v-icon> Edit product
                </div>
                <div class="flex-grow-1 pa-2">
                    <v-chip label class="float-right" color="primary">
                        <v-icon left>assessment</v-icon>
                        {{ stock.stock_number }}
                    </v-chip>
                </div>
            </div>
        </v-card>
        <!-- divider -->
        <v-divider class="pb-1"/>

        <v-card>
            <v-card-text>
                <v-alert outlined type="info">
                    * Indicate the required field
                </v-alert>
                <v-container>
                    <v-form ref="productFormAdd">
                        <v-row>

                            <!-- product name-->
                            <v-col cols="12" md="6">
                                <v-label>Name</v-label>
                                <v-text-field
                                    single-line filled dense v-model="productParams.name"
                                    :rules="nameRules"
                                    hint="product name" required>
                                </v-text-field>
                            </v-col>

                            <!-- category-->
                            <v-col cols="12" md="6">
                                <v-label>Category</v-label>
                                <v-select
                                    label="Select category" single-line filled dense
                                    v-model="productParams.product_category_id"
                                    item-text="name"
                                    :items="productCategories"
                                    item-value="id">
                                </v-select>
                            </v-col>

                            <!-- Manufacturing date-->
                            <v-col cols="12" md="6">
                                <v-label>Manufacturing Date</v-label>
                                <v-dialog
                                    persistent lazy full-width ref="manufacturing_date_dialog"
                                    v-model="manufacturing_date_modal"
                                    :return-value.sync="productParams.manufacturing_date"
                                    width="290px">
                                    <template v-slot:activator="{ on }">
                                        <v-text-field
                                            single-line filled v-model="productParams.manufacturing_date"
                                            label="Pick date"
                                            append-icon="event"
                                            readonly
                                            dense
                                            filled
                                            v-on="on">
                                        </v-text-field>
                                    </template>
                                    <v-date-picker v-model="productParams.manufacturing_date" scrollable>
                                        <v-spacer></v-spacer>
                                        <v-btn text color="primary"
                                               @click="manufacturing_date_modal = false">Cancel</v-btn>
                                        <v-btn text color="primary"
                                               @click="$refs.manufacturing_date_dialog.save(productParams.manufacturing_date)">
                                            OK
                                        </v-btn>
                                    </v-date-picker>
                                </v-dialog>
                            </v-col>

                            <!-- Expire date-->
                            <v-col cols="12" md="6">
                                <v-label>Expire Date</v-label>
                                <v-dialog persistent lazy full-width ref="expire_date_dialog"
                                          v-model="expire_date_modal"
                                          :return-value.sync="productParams.expire_date"
                                          width="290px">
                                    <template v-slot:activator="{ on }">
                                        <v-text-field
                                            single-line filled dense readonly
                                            v-model="productParams.expire_date"
                                            label="Picker in dialog"
                                            append-icon="event"
                                            v-on="on">
                                        </v-text-field>
                                    </template>
                                    <v-date-picker v-model="productParams.expire_date" scrollable>
                                        <v-spacer></v-spacer>
                                        <v-btn color="primary" @click="expire_date_modal = false">Cancel</v-btn>
                                        <v-btn color="primary"
                                               @click="$refs.expire_date_dialog.save(productParams.expire_date)">
                                            OK
                                        </v-btn>
                                    </v-date-picker>
                                </v-dialog>
                            </v-col>

                            <!--Buying price-->
                            <v-col cols="12" md="6">
                                <v-label>Buying price</v-label>
                                <v-text-field
                                    dense filled single-line
                                    v-model="productParams.buying_price">
                                </v-text-field>
                            </v-col>

                            <!--Selling price-->
                            <v-col cols="12" sm="6">
                                <v-label>Selling price</v-label>
                                <v-text-field
                                    filled single-line dense
                                    v-model="productParams.selling_price"
                                    single-line>
                                </v-text-field>
                            </v-col>

                            <!--Description-->
                            <v-col cols="12">
                                <v-label>Description</v-label>
                                <v-textarea
                                    filled dense full-width counter
                                    v-model="productParams.description"
                                    maxlength="120"
                                    single-line>
                                </v-textarea>
                            </v-col>
                            <v-col cols="12">
                                <v-checkbox color="primary" v-model="productParams.is_active">
                                    <template v-slot:label>
                                        <div @click.stop="">Activate Product</div>
                                    </template>
                                </v-checkbox>
                            </v-col>
                            <v-col cols="12">
                                <v-btn @click="save()" color="primary" dark>Update</v-btn>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-container>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
    import { mapActions, mapState } from 'vuex'
    export default {
        props: {
            propProductId: {
                required: true
            }
        },
        data () {
            return {
                manufacturing_date_modal: false,
                expire_date_modal: false,
                errors: [],

                productParams: {
                    name: '',
                    product_category_id: null,
                    manufacturing_date: '',
                    expire_date: '',
                    description: '',
                    buying_price: 0,
                    selling_price: 0,
                    is_active: false
                },
                nameRules: [
                    (v) => !!v || 'Product name is required'
                ],
                // priceRules: [
                //     (v) => v && v.isNumeric || 'This field requires number'
                // ]
            }
        },
        mounted () {
            const self = this

            self.$store.commit('setBreadcrumbs', [
                {label: 'Back', to: {name: 'product.list'}},
                {label: 'Edit product', to: ''}
            ])

            //self.callToLoadStock()

            self.callToLoadProductCategories()

            self.callToLoadProduct()
        },

        computed: {

            ...mapState('stock', ['stock']),

            ...mapState('ProductCategory', ['productCategories']),

            compProductId () {
                return this.propProductId
            }
        },
        methods: {

            //...mapActions('stock', ['loadStock']),

            ...mapActions('ProductCategory', ['loadProductCategories']),

            ...mapActions('Product', ['loadProduct']),

            callToLoadStock () {
                this.loadStock(this.compStockPropId)
            },

            callToLoadProductCategories () {
                this.loadProductCategories(()=>{})
            },

            callToLoadProduct () {
                this.loadProduct(this.compProductId).then(response => {

                    let Product = response.data.data

                    this.productParams.name = Product.name
                    this.productParams.product_category_id = Product.product_category_id
                    this.productParams.manufacturing_date = Product.manufacturing_date
                    this.productParams.expire_date = Product.expire_date
                    this.productParams.buying_price = Product.buying_price
                    this.productParams.selling_price = Product.selling_price
                    this.productParams.description = Product.description
                    this.productParams.is_active = Product.is_active

                })
            },

            save () {
                const self = this

                let payload = {
                    name: self.productParams.name,
                    product_category_id: self.productParams.product_category_id,
                    buying_price: self.productParams.buying_price,
                    selling_price: self.productParams.selling_price,
                    description: self.productParams.description,
                    is_active: self.productParams.is_active,
                    manufacturing_date: self.productParams.manufacturing_date,
                    expire_date: self.productParams.expire_date,
                    stocks_id: self.compStockPropId
                }

                self.$store.commit('showLoader')

                axios.put('/mum/products/' + self.compProductId, payload).then(response => {

                    self.$store.commit('showSnackbar', {
                        message: response.data.message,
                        color: 'success',
                        duration: 3000
                    })

                    //commit mutation
                    self.$eventBus.$emit('PRODUCT_UPDATED')
                    //hide loader
                    self.$store.commit('hideLoader')

                    self.$router.push({name: 'product.list'})

                }).catch (error => {
                    self.$store.commit('hideLoader')

                    if (error.response) {
                        self.errors = error.response.data.errors
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
            }
        }
    }
</script>

<style scoped>

</style>
