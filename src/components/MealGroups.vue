<template>
  <div>
		<div class="columns is-centered is-fullwidth">
    	<!-- mealGroups select -->
			<label>Group</label>
			<div v-if="mealGroups.length>5" class="field">
				<div class="select is-fullwidth">
					<select v-on:change="onSelection($event.target.value)" v-model="selMealGroup">
						<option :value=-1>Select</option>
						<option v-for="(mg, idx) in mealGroups" 
							:value="mg.id" 
							:key="mg.id"
							>{{ idx+1 }}. {{ mg.name }} - <small>{{ meals.reduce((pre, cur) => (cur.group === mg.id) ? ++pre : pre, 0) }} meals</small>
						</option>
					</select> 
				</div>
			</div>

			<div v-if="mealGroups.length<6" class="field has-addons groupBoxes">
				<p v-for="mg in mealGroups"
									:key="mg.id" 
									class="control">
					<button class="button groupBox"
									v-on:click.prevent="onSelection(mg.id)"
									:class="selMealGroup == mg.id ? 'is-primary' : ''"
									>{{ mg.name }}<br>
									<small>{{ meals.reduce((pre, cur) => (cur.group === mg.id) ? ++pre : pre, 0) }} meals</small>
					</button>
				</p>
			</div> 
		</div>
  </div>
</template>

<script>
export default {
  name: 'MealGroups',
  props: {
		mealGroups: Array,
		selMealGroup: Number,
		meals: Array
  },
  methods: {
    onSelection (event) {
      this.$emit('clicked', event)
    }    
	}
}
</script>

<style scoped>
.button {
	white-space: nowrap;
    padding: 40px 10px 60px 10px;
    min-width: 120px;
}
.groupBoxes {
	display: flex;
  flex-wrap: wrap;
}
.groupBox {
	flex: 1 0 26%;
  white-space: nowrap;
	display: block;
	overflow-wrap: break-word;
}
</style>