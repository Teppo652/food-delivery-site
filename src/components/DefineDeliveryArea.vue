@@ -0,0 +1,103 @@
<template>
	<div>
		<div class="container is-fluid">
			<section class="section">
        <div class="columns is-centered">
          <div class="column is-5 is-3-desktop">

						{{ areas1.geonames[0] }}
            						
            <div class="field">
              <div class="control">
								<!-- areas1 -->
                <div v-if="areas1" class="select is-medium">            
                  <select v-on:change="changeCity($event.target.value)" v-model="selCity" class="is-fullwidth">
                    <option :value=-1>Select city</option>
                    <option v-for="a in areas1.geonames" :key="a.geonameId" :value="a.geonameId">{{ a.name }}</option>
                  </select> 
                </div>
              </div>
            </div> 
						
            <div class="field">
              <div class="control">
								<!-- areas2 -->
                <div v-if="areas2" class="select is-medium">            
                  <select v-on:change="changeCity($event.target.value)" v-model="selCity" class="is-fullwidth">
                    <option :value=-1>Select city</option>
                    <option v-for="a in areas2.geonames" :key="a.geonameId" :value="a.geonameId">{{ a.name }}</option>
                  </select> 
                </div>
              </div>
            </div> 
						
            <div class="field">
              <div class="control">
								<!-- areas3 -->
                <div v-if="areas3" class="select is-medium">            
                  <select v-on:change="changeCity($event.target.value)" v-model="selCity" class="is-fullwidth">
                    <option :value=-1>Select city</option>
                    <option v-for="a in areas3.geonames" :key="a.geonameId" :value="a.geonameId">{{ a.name }}</option>
                  </select> 
                </div>
              </div>
            </div> 
						
            <div class="field">
              <div class="control">
								<!-- areas4 -->
                <div v-if="areas4" class="select is-medium">            
                  <select v-on:change="changeCity($event.target.value)" v-model="selCity" class="is-fullwidth">
                    <option :value=-1>Select city</option>
                    <option v-for="a in areas4.geonames" :key="a.geonameId" :value="a.geonameId">{{ a.name }}</option>
                  </select> 
                </div>
              </div>
            </div> 
						
            <div class="field">
              <div class="control">
								<!-- areas5 -->
                <div v-if="areas5" class="select is-medium">            
                  <select v-on:change="changeCity($event.target.value)" v-model="selCity" class="is-fullwidth">
                    <option :value=-1>Select city</option>
                    <option v-for="a in areas5.geonames" :key="a.geonameId" :value="a.geonameId">{{ a.name }}</option>
                  </select> 
                </div>
              </div>
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
	name: 'DefineDeliveryArea',
	data () {
		return {
      selCity: -1
		}
	},
	methods: {
    	...mapActions(["getAreas", "getAreas2", "getAreas3", "getAreas4", "getAreas5"])
	},
	created: function () {
		this.getAreas('660013'); // finland
	},
	watch: {
		cities: function() {

		}
	},
  computed: mapGetters(["areas1", "areas2", "areas3", "areas4", "areas5"])
}
</script>

<style scoped>
</style>