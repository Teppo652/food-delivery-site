<template>
	<div>
		<div class="container is-fluid">
			<section class="section">
			<div class="container has-text-centered">

				<h1>Main</h1>

				<div v-if="!locale" >      
      		<SelectLocale @selected="localeSelected" />
					<!-- localeSelected  
					<MealGroups 
					   @clicked="mealGroupChildSel"  />								
					-->
    		</div>
				<div v-else > 
					locale:{{ locale }}<br>
					<SearchBox @searchMade="searchMade" :locale=locale :foodTypes=foodTypes :t=JSON.parse(JSON.stringify(t)) />
    		</div>
				<!--
					 "cities", "lang", "t", "foodTypes"
				<SearchBox />
				

				<br>foodTypes: {{ foodTypes }}-->

			</div>
			</section>
		</div>
	</div>
</template>

<script>
import SelectLocale from './SelectLocale'
import SearchBox from './SearchBox'
import { mapGetters, mapActions } from "vuex"
export default {
	name: 'Main',
	data () {
		return {

		}
	},
	components: {
    SelectLocale,
		SearchBox
	},
	methods: {
		localeSelected (val) {
				alert('1 Main localeSelected:', val);				
		},
		searchMade (val) {
			this.searchMade(val);
		},
		//...mapActions(["getCities", "getTranslations", "getUser", "getFoodTypes", "changeCity"]),
		//...mapActions(["getTranslations", "initLocale", "getLocales", "initFoodTypes", "getFoodTypes"]),
		...mapActions(["getTranslations", "getFoodTypes", "searchMade"]),
	},
	created(){
		//this.initLocale(null);
		//this.getLocales();
		//this.initFoodTypes();
		
		//this.getFoodTypes('en');
		// this.getCities();
		//this.changeLang('en');	
		/*
watch: {		
		lang: function() {
			console.log('watch lang');
			this.getFoodTypes('fi');
		*/
	},
	watch: {
		locale: function() {

			console.log('Main - watch locale:', this.locale);
			let lang = this.locale.split('-')[0];
			console.log('Main - watch lang:', lang);
			//this.getFoodTypes('fi-fi');
			this.getFoodTypes(lang);
			//this.getFoodTypes('en');
			// this.getFoodTypes(lang);
			
			
			this.getTranslations(lang); // getTranslations
		},
		t: function() {
			console.log('main watch t:', this.t);
			
		}, /*		
		cities: function() {
			console.log('watch cities');			
		},		
		lang: function() {
			console.log('watch lang');
			//this.getFoodTypes('fi');
		},
		forwardToNextPage() {
			// this.$router.replace({name: 'xxxxxxx'});
		} */
	},
	//computed: mapGetters(["locale", "cities", "lang", "t", "user", "foodTypes"])
	computed: mapGetters(["t", "locales", "locale", "foodTypes"])
}
</script>

<style scoped>
</style>
