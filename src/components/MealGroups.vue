<template>
  <div>
		<div v-if="mealGroups.length>1" class="columns is-centered is-fullwidth">
    	<!-- mealGroups select -->
			<label>{{menuGroupSelect}}</label>
			<!--<div v-if="mealGroups.length>5" class="field"> -->
				<div v-if="displayAs!=='boxes'" class="select is-fullwidth"> <!-- $data.__selMealGroup -->
					<select v-on:change="onSelection($event.target.value)" v-model="selMealGroup" class="is-fullwidth">
						<!--<option :value=-1>Select</option>-->
						<option v-for="mg in mealGroups" 
							:value="mg.id" 
							:key="mg.id"
							>{{ mg.name }} - <small style="float:right">{{ meals.reduce((pre, cur) => (cur.group === mg.id) ? ++pre : pre, 0) }} {{numberOfMealsText}}</small>
						</option>
					</select> 
				</div>
			</div>

			<div v-if="displayAs=='boxes'" class="field has-addons groupBoxes">
				<p v-for="mg in mealGroups"
									:key="mg.id" 
									class="control">
					<button class="button groupBox"
									v-on:click.prevent="onSelection(mg.id)"
									:class="selMealGroup == mg.id ? 'is-primary' : ''"
									>{{ mg.name }}<br>
									<small>{{ meals.reduce((pre, cur) => (cur.groupId === mg.id) ? ++pre : pre, 0) }} {{numberOfMealsText}}</small>
					</button>
				</p>
			</div> 
			<button class="button smallBtn" @click.prevent="displayChanged">
				<span v-if="__displayAs=='boxes'">Droplist</span>
				<span v-else>Boxes</span>
			</button>
		</div>
  </div>
</template>

<script>
export default {
  name: 'MealGroups',
  props: {
		mealGroups: Array,
		selMealGroup: Number,
		meals: Array,
		numberOfMealsText: String
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