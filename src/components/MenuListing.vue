<template>
  <div>
                  <div class="field">
										<!-- ROWS -->
										<div class="is-fullwidth">
											<div class="menuRows">
												<span v-for="sm in meals" :value="sm.id" :key="sm.id"
													@click.prevent="selMeal = sm"
													>
													<span v-if="sm.group == selMealGroup"
														class="menuRow" 
														:class="selMeal == sm ? 'selected' : ''">
														{{ sm.name }} 
														({{ sm.orderId}}) 
														<span class="price">{{ sm.price }} €</span>
														<!-- ingredients -->
														<span class="menuRowIngredients">
															<small v-for="i in sm.ingredients" :value="i.id" :key="i.id">
																{{ i.name }}
															</small>
														</span>
														<!-- variations -->
														<div v-if="sm.variations">
															<span v-for="vId in sm.variations.split(',')" :value="vId" :key="vId"
																class="">
																{{ variations.find(v => v.id == vId).name }}
																+{{ variations.find(v => v.id == vId).priceAdd }} €, &nbsp;
															</span>
														</div>

                            <!--
													<button @click.prevent="deleteItem(mealGroups, m.id)" class="delete deleteGroup"></button>
													<span v-if="showChangeOrderButtons && mealGroups.length>1">
														<button class="iconButton" @click.prevent="move(mealGroups, 'bottom', m)"><span class="move moveBottom"></span><span class="arrowLineBottom"></span></button> 
														<button class="iconButton" @click.prevent="move(mealGroups, 'down', m)"><span class="move moveDown"></span></button> 
														<button class="iconButton" @click.prevent="move(mealGroups, 'up', m)"><span class="move moveUp"></span></button> 
														<button class="iconButton" @click.prevent="move(mealGroups, 'top', m)"><span class="move moveTop"></span><span class="arrowLineTop"></span></button>
													</span>
                          -->
													</span>
												</span>
											</div>
										</div>
									</div>

			<!--<button @click.prevent="addItems" class="button is-primary">Add</button>-->	
      <!--
      <MenuListing
      -->	
  </div>
</template>

<script>
export default {
  name: 'MenuListing',
	data () {
		return {

		}
	},
  props: {
		meals: Array,
		selMeal: Object,
		selMealGroup: Number,
		variations: Array
  },
  methods: {
    /*
    addItems () {
      this.$emit('add', this.items);
      this.items = null;
    } */   
  }
}
</script>

<style scoped>
.menuRow {
	float: left;
    width: 100%;
    background-color: #9dd1c9;
    padding: 6px 12px;
    margin: 4px 0;
    color: #fff;
    text-align: left;
    font-size: 1.3rem;
    border-radius: 4px;
	border: solid 2px #fff;
}
.menuRow:hover {
	cursor: pointer;
}
.menuRow small {
	font-size: .8rem;
	color: gray;
}
.menuRows .selected {
	border: solid 2px red;
	background-color: #72c8bb;
	border: solid 2px #42ac9b;
}
.menuRows .tag {
	background-color: #f7fffe;
	color: #0ba088;
	margin-right: 3px;
}
.menuRows .price {
	float: right;
    font-size: 1.05rem;
    margin: 3px 0 0 15px;
    color: #077060;
    width: 60px;
    text-align: right;
}
.menuRows .menuRowIngredients {
	clear: left;
	float: left;
	
}
.menuRows .priceInputInline { 
	float: unset; 
	top: 4px; 
}
.menuRows .tag .delete {
	background-color: #72c8bb;
}
.menuRows .tag .delete:hover {
	background-color: #db0e64;
}
</style>
