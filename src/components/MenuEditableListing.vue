<template>
  <div>
                    <!-- ROWS -->
										<div class="field">
											<div class="is-fullwidth">
												<div class="menuRows">
													<span v-for="(sm, idx) in meals" :value="sm.id" :key="sm.id"
														@click.prevent="selMeal = sm"
														> editedMeal: {{ editedMeal }}
														<span v-if="sm.group == selMealGroup"
															class="menuRow" 
															:class="selMeal == sm ? 'selected' : ''">
															<!-- edit meal name form-->
															<span v-if="editedMeal == sm">
																{{ idx+1 }}. 
																<!-- edit name -->
																<input class="input" type="text" 
																		v-model="editedMeal.name"
																		
																		style="width:unset"
																		>
                                    <!--:class="charsLeft(50, editedMeal)[0] ? 'exceedTextLength' : ''"-->
                                <!--
																<span class="is-right">												
																	<span class="textLimiter is-pulled-right is-size-7" 
																			:class="charsLeft(50, editedMeal)[0] 
																			? 'has-text-danger' 
																			: ''">{{ charsLeft(50, editedMeal)[1] }}</span> 
																</span>-->
																<span class="control has-icons-right wide">
																	<!-- edit price -->
																	<input class="input" type="text" v-model="editedMeal.price" style="width:70px;margin-left:6px">
																	<!--<input v-model="newMealPrice" class="input mealPrice" placeholder="0.00" type="text" value="2">-->
																	<span class="priceCurrency priceInputInline">€</span>
																</span> 
																<!--<span @click.prevent="editedMeal = null, sm = origMeal" class="iconButton cancelEditMeal"></span>&nbsp;-->
																<span @click.prevent="addMeal(origMeal, 'cancelEditMeal', sm)" class="iconButton cancelEditMeal"></span>&nbsp;

																<!--<span @click.prevent="sm.name = editedMeal.name, editedMeal = null" class="iconButton saveEditMeal"></span>-->
																<!--<span @click.prevent="sm.name = clean(editedMeal.name), sm.price = cleanPrice(editedMeal.price), editedMeal = null" class="iconButton saveEditMeal"></span>-->
																<span @click.prevent="addMeal(editedMeal.name)" class="iconButton saveEditMeal"></span>
																<!-- edit desc -->
																<input class="input" type="text" v-model="editedMeal.desc" placeholder="Meal description" style="width:100%;margin-top:6px"
                                    ><!--
																		:class="charsLeft(255, editedMeal.desc)[0] ? 'exceedTextLength' : ''">
																<span class="is-right">												
																	<span class="textLimiter is-pulled-right is-size-7" 
																			:class="charsLeft(255, editedMeal.desc)[0] 
																			? 'has-text-danger' 
																			: ''">{{ charsLeft(255, editedMeal.desc)[1] }}
																	</span> 
																</span>-->
															</span>

															<!-- show meal name as text -->
															<span v-else>
																{{ idx+1 }}. 
																{{ sm.name }}
																({{ sm.orderId}})
																<button @click.prevent="deleteItem(meals, sm.id)" class="delete deleteGroup"></button>														
																<!-- <span @click.prevent="editedMeal = sm, origMeal = sm" class="iconButton editMeal"></span>-->
                                <span @click.prevent="editedMeal = sm, origMeal = sm" class="iconButton editMeal"></span>
                                <!--<span @click.prevent="editClicked(sm)" class="iconButton editMeal"></span> new -->
																
																<span class="price">{{ sm.price }} €</span>																
																<p class="mealDesc">{{ sm.desc }}</p>
																<span v-if="showChangeOrderButtons">
																	<button class="iconButton" @click.prevent="move(meals, 'bottom', sm)"><span class="move moveBottom"></span><span class="arrowLineBottom"></span></button> 
																	<button class="iconButton" @click.prevent="move(meals, 'down', sm)"><span class="move moveDown"></span></button> 
																	<button class="iconButton" @click.prevent="move(meals, 'up', sm)"><span class="move moveUp"></span></button> 
																	<button class="iconButton" @click.prevent="move(meals, 'top', sm)"><span class="move moveTop"></span><span class="arrowLineTop"></span></button>
																</span>
															</span>
														</span><!-- new -->
													</span>
												</div><br>										
											</div>
										</div>
  </div>
</template>

<script>
export default {
  name: 'MenuEditableListing',
	data () {
		return {
      editedMeal: null,
      origMeal: null
		}
	},
  props: {
		meals: Array,
		selMeal: Object,
		selMealGroup: Number,
    variations: Array,
    editedMeal: Array,
    showChangeOrderButtons: Boolean
  },
  methods: {
    //onSelection (event) {
    addMeal(editedMeal) {
      this.$emit('newUpdateMealFromEditableListing', editedMeal);
      // this.$emit('clicked', event)
      // editedMeal = sm, 
      // origMeal = sm
    }    
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



.iconButton {
	width: 30px;
    height: 30px;
    border-radius: 50%;
    border: solid 1px #42ac9b;
    float: right;
    display: grid;
    padding: 5px;
	opacity: .7;
}
.iconButton:hover {
	opacity: 1;
    cursor: pointer;
}
#selectFoodTypes select::after {
	border: none !important;
}
.move {
	background-image: url("../assets/arrow-up.svg");
	width: 18px;
    height: 18px;
    background-repeat: no-repeat;
    position: relative;
	opacity: .9;
}
.arrowLineTop, .arrowLineBottom {
	background-image: url("../assets/line.svg");
	width: 16px;
    height: 16px;
    background-repeat: no-repeat;
    position: relative;    
    left: 1px;
	opacity: .9;
}
.arrowLineTop {
	top: -25px;
}
.arrowLineBottom {
	bottom: 8px;
}
.moveDown {
	transform: rotate(180deg);
}
.moveTop {
	top: 2px;
}
.moveBottom {
	transform: rotate(180deg);	
    top: -1px;
}



.changeOrder, .editMeal, .cancelEditMeal, .saveEditMeal {
	border-radius: 0;
    width: 26px;
    height: 26px;
    background-repeat: no-repeat;
    border: none;
    opacity: .65;
}
.changeOrder {
	background-image: url("../assets/upDownArrow.svg");
    margin-left: 0px !important;
}
.deleteGroup {
	float: right;
    height: 28px;
    width: 28px;
    margin: 1px -1px 1px 24px;
}
.mealDesc {
	color: #474747;
  font-size: 16px;
}
.editMeal {	
	background-image: url("../assets/edit.svg");	
    margin-left: 12px;
}
.cancelEditMeal {
	background-image: url("../assets/cancel.svg");
}
.saveEditMeal {
	background-image: url("../assets/save.svg");
}
</style>