<template>
	<div>
		<h1>Lorem!</h1>
		<p>foo: {{ foo }}</p>
		<p>rand: {{ rand }}</p>
	</div>
</template>

<script>
    // import BookingList from "./components/BookingList";
    // import QuestSelect from "./../components/vue/QuestSelect";

    export default {
    	data: function () {
    	    return {
    	    	foo: 'bar'
    	    }
    	},
    	mounted: function () {
    		console.log(this.foo);
    		this.foo = 'asdfsdf';
    	},
        computed: {
            rand: function () {
                return Math.random();
            }
        },
        // components: {
        //     QuestSelect,
        //     BookingList,
        // },
    };
</script>