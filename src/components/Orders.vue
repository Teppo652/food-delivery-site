<template>
	<div>
		<div class="container is-fluid">
			<section class="section">
			<div class="container has-text-centered">


				<h1>Orders</h1>
			</div>
			</section>
		</div>
	</div>
</template>

<script>
import { mapGetters, mapActions } from "vuex"
export default {
	name: 'Orders',
	data () {
		return {

		}
	},
	methods: {
		xxxxxx: function() {
		// console.log('xxxxxx');
		},
		...mapActions(["saveXxxxxx"]),
		// calculates number of characters left, returns array: [is limit exceeded, characters left / max]
		charsLeft(maxLen, str) {
			return [ str.length > maxLen ? true : false,
			maxLen - str.length + " / " + maxLen ];
		},
		forwardToNextPage() {
			// this.$router.replace({name: 'xxxxxxx'});
		}
	},
	watch: {
		xxxxx: function() {

		}
	},
	computed: mapGetters(["xxxx"])
}
</script>

<style scoped>
</style>
