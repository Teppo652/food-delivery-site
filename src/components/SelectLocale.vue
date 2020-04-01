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
									<p class="modal-card-title">Select country</p>
								</header>
								<section class="modal-card-body">
										country: {{ locale }}<br>
								<div class="select is-fullwidth"> 
                  <select v-on:change="changeLocale($event.target.value)" class="is-fullwidth">
                    <option :value=-1>Select country</option>
                    <option v-for="c in locales" :key="c.code" :value="c.code">{{ c.name }}</option>
                  </select> 
                </div>

								</section><!--
								<footer class="modal-card-foot">
									<button class="button is-success is-fullwidth">Continue</button>
								</footer>-->
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
	name: 'SelectLocale',
	data () {
		return {
		}
	},
	methods: {
		changeLocale(val) {
			//console.log('Child - watch locale:', this.locale);
			this.changeLocale(val);
	}, /*
	watch: {
		locale: function() {
			//console.log('Min - watch locale:', this.locale);
			//this.$emit('selected', this.locale);
		}	
	}, */
		/*
  methods: {
    
    addItems () {
      this.$emit('add', this.items);
      this.items = null;
    }   
  }
		*/
		...mapActions(["getLocales", "changeLocale"])
	},
	created: function () {		
		this.getLocales();
	},
  computed: mapGetters(["locales", "locale"])
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