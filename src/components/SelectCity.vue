<template>
	<div>
		<div class="container is-fluid">
			<section class="section">
        <div class="columns is-centered">
          <div class="column ">
            
						<div class="modal is-active">
							<div class="modal-background"></div>
							<div class="modal-card" style="width: 440px">
								<header class="modal-card-head">
									<p class="modal-card-title">Select city</p>
								</header>
								<section class="modal-card-body">
										lang: {{ lang }}<br>
								<div class="select is-fullwidth"> 
                  <select v-on:change="changeCity($event.target.value)" v-model="selCity" class="is-fullwidth">
                    <option :value=-1>Select city</option>
                    <option v-for="c in cities" :key="c.id" :value="c.id">{{ c.n }}</option>
                  </select> 
                </div>

								</section>
								<footer class="modal-card-foot">
									<button class="button is-success is-fullwidth">Continue</button>
								</footer>
							</div>
						</div>

            <div class="field">
              <div class="control">
                

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
	name: 'SelectCity',
	data () {
		return {
      selCity: -1
		}
	},
  props: {
		lang: String
	},
	methods: {
    	...mapActions(["getCities", "changeCity"])
	},
	created: function () {
		alert('SelectCity init, lang:', lang);
		if(this.lang != null) {
			alert('No lang value found!');
		} else {
			alert('lang:', lang);
			this.getCities(this.lang);
		}
	},
	watch: {
		cities: function() {

		}
	},
  computed: mapGetters(["cities", "city"])
}
</script>





<style scoped>
.modal-background {
    background-color: #0a0a0aab;
}
.modal-card-foot, .modal-card-head {
    background-color: #fff;
}
.modal-card-head {
    border-bottom: none;
}
.modal-card-foot {
    border-top: none;
}
</style>