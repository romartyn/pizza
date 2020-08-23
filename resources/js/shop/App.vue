<template>
    <div class="shop-inner" :class="{'shop-loading': products.length == 0}">
        <products-grid></products-grid>
        <checkout></checkout>
    </div>
</template>

<style module>
    .shop-inner {
        position: relative;
    }
</style>

<script>
    import Vue from 'vue';
    import ProductsGrid from "./components/ProductsGrid";
    import HeadCart from "./components/HeadCart";
    import Checkout from "./components/Checkout";

    export default {
        computed: {
            products: function () {
                return this.$store.state.products;
            },
        },
        components: {
            ProductsGrid,
            Checkout
        },
        created: async function () {
            this.$store.dispatch("FETCH_PRODUCTS");
            this.$store.dispatch("FETCH_CATEGORIES");
            await this.$store.dispatch("FETCH_CART");

            new Vue({
                render: h => h(HeadCart), store: this.$store
            }).$mount("#head_cart");
        }
    };
</script>