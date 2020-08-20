<template>
    <div>
        <products-grid></products-grid>
    </div>
</template>

<script>
    import ProductsGrid from "./components/ProductsGrid";
    export default {
        components: {
            ProductsGrid
        },
        created:
            function () {
                this.$store.dispatch("FETCH_PRODUCTS");
                this.$store.dispatch("FETCH_CATEGORIES");
            }
    };
</script>