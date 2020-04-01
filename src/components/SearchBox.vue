<template>
	<div>
		<div v-if="t" class="container is-fluid">
			<section class="section">
			<div class="container has-text-centered">
				
				<h1>SearchBox</h1>
				
 				<!-- kitchen -->
				<div class="select is-fullwidth"> 
          <select v-model="kitchen" class="is-fullwidth">
            <option :value=-1>{{ t.search_selectKitchen }}</option>
						<option :value=999>{{ t.search_allKitchens }}</option>
            <option v-for="c in foodTypes" :key="c.id" :value="c.id">{{ c.name }}</option>
          </select> 
        </div>
				
			 <!-- postalCode -->
				<div class="field">
          <div class="control">
            <label for="postalCode">{{ t.postalCode }}</label>
            <input id="postalCode"
            type="text"
            class="input"
            :placeholder=t.postalCode
            name="postalCode"
            v-model="postalCode"
          />
          </div>
        </div>

 				<!-- delivery/pickup/booking -->	
				<div class="select is-fullwidth"> 
          <select v-model="how" class="is-fullwidth">
						<option key="-1" value="-1">{{ t.search_how }}</option>
            <option key="d" value="d">{{ t.search_how_delivery }}</option>
						<option key="p" value="p">{{ t.search_how_pickup }}</option>
						<option key="b" value="b">{{ t.search_how_booking }}</option>
          </select> 
        </div>
				<!-- login btn -->  
        <div class="field">
          <div class="control">
            <button 
                class="button is-primary is-fullwidth"
								@click.prevent="search()">{{ t.search }}</button>
          </div>
        </div>


			</div>
			</section>
		</div>
	</div>
</template>

<script>
import { mapGetters, mapActions } from "vuex"
export default {
	name: 'SearchBox',
  data() {
    return {
			kitchen: -1,
			postalCode: null,
			how: -1
		}
	},
  props: { 
		foodTypes: Array, /*
		selMealGroup: Number,
		meals: Array, */
		locale: String,
		t: Object
  },
  methods: {
    search() {
			let valArr = [];
			valArr[0] = this.kitchen;
			valArr[1] = this.postalCode;	
			valArr[2] = this.how;	
			console.log('valArr:', valArr);		
			if(valArr[0] != -1 && valArr[1] != null && valArr[1] != '' && valArr[2] != -1 ) {
				this.$emit('searchMade', valArr);
			}
			console.log('go to listing page');
			this.$router.push('Listing');
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
