<template>
	<div>
		<div class="container is-fluid">
			<section class="section">
				<div class="container has-text-centered">
					
					<div class="columns is-centered">
						<div class="column is-8">

							<p class="subtitle is-3">Create online menu 
								<small v-if="!isSaved" class="unSaved">Not saved</small>
								<small v-else class="saved">Saved</small>
							</p>
														
							<div class="steps">
								<div v-for="(s, index) in steps" :key="index"
										class="step-item"
										:class="[s.id === step ? 'is-active' : '',
										s.id === step ? 'current-step-item' : '', 
										s.isCompleted ? 'is-active is-completed' : '']">
									<div class="step-marker">										
										<span @click.prevent="s.isCompleted ? step=s.id : ''" class="noSelect">{{ index+1 }}</span>
									</div>
									<div class="step-details">
										<p @click.prevent="s.isCompleted ? step=s.id : ''" class="stepTitle noSelect">{{ s.title }}</p>
									</div>
								</div>
							</div>

							<form>
								<!-- add food types -->			
								<span v-if="step==1">
									<p class="subtitle is-3">1. Select food types</p>
									<small>For example: Pizza, Texmex, Kebab, Vegetarian</small>
									<small class="instruction">This list is visible in retaurant listing for customers to quickly know what types of foods do you offer. They are presented in the order you select them.</small>
									<br><br>
									<!-- add FoodType -->
									<br>foodTypes: {{ foodTypes }}<br>
									<label>Add foodtype <small>(Max 8)</small></label>
									<span class="is-5" style="float:left; margin: 0 30px 20px 0">
										<div class="field">
											<div id="selectFoodTypes" class="select is-halfwidth is-multiple" style="display:contents">
												<select v-on:change="addFoodType($event.target.value)" v-model="selFoodType" multiple> <!-- multiple> -->
													<option v-for="k in foodTypes" 
														:value="k.id" 
														:key="k.id"
														>{{ k.name }}
													</option>
												</select>
											</div>
										</div>
									</span>									
									<span class="is-5">
										<!-- selected FoodTypes -->
										<label>Selected:</label>
										<div class="tags">
											<span v-for="sk in selFoodTypes" :key="sk.id"
												class="tag is-primary is-medium">										
													{{ sk.name }}
												<button @click.prevent="deleteItem(selFoodTypes, sk.id)" class="delete is-small"></button>
											</span>
										</div>
									</span>
								</span>
				

								<!-- Create groups -->
								<span v-if="step==2">								
									<p class="subtitle is-3">2. Create menu groups</p>
									<small>Example of typical groups: Appetizers, Pizzas, Pastas, Sallads, Beverges</small>
									<small class="instruction">These are groups under which you can add individual dishes. They can be same or different than Food groups.</small>									
									<br><br>
									<label>Add group name(s)</label>
									<!--
									<div class="field has-addons is-fullWidth" style="clear:left">
										<p class="control has-icons-right wide">
										<input class="input wide" type="text" 
												placeholder="Example: Sallads"
												v-model="newMealGroup"                            
												style="z-index:0"
												:class="charsLeft(50, newMealGroup)[0] ? 'exceedTextLength' : ''
												">                      
										<span class="is-right">
											<span class="textLimiter is-pulled-right is-size-7" 
													:class="charsLeft(50, newMealGroup)[0] 
													? 'has-text-danger' 
													: ''">{{ charsLeft(50, newMealGroup)[1] }}</span> 
										</span>
										</p>
										<div class="control">
										<!--<select v-on:change="addFoodType($event.target.value)" v-model="selFoodType">
										<a @click.prevent="addMealGroup(newMealGroup), newMealGroup = ''" class="button is-primary"
												:disabled="charsLeft(50, newMealGroup)[0]"
											>Add</a>
										</div>
									</div><br> -->

									<!-- import groups names -->										
									<label>Import groups names</label>
									<div class="columns">
  									<div class="column is-6">
											<button @click.prevent="copyFoodGroupsIntoMenuGroups()" class="button is-primary">Use food types as menu groups</button>
										</div>
										<div class="column is-6">
												<ImportMultiple @add="addMultipleMealGroups" placeholderText="Menu group name(s)" />
										</div>
									</div>
									<!--
									<div class="field has-addons is-fullWidth" style="clear:left">
										<p class="control has-icons-right wide">
											<textarea v-model="importGroups"
													style="z-index:0"
													:class="charsLeft(2000, importGroups)[0] ? 'exceedTextLength' : ''"											
													class="input wide" type="text"
											></textarea>
											<span class="is-right">												
												<span style="margin-top:1px" class="textLimiter is-pulled-right is-size-7" 
														:class="charsLeft(2000, importGroups)[0] 
														? 'has-text-danger' 
														: ''">{{ charsLeft(2000, importGroups)[1] }}</span> 
											</span>
										</p>
										<button @click.prevent="addMultipleMealGroups" class="button is-primary is-outlined">Import</button>
									</div>-->

									<div v-if="mealGroups.length>1" class="is-pulled-right">	
										
										<button @click.prevent="showChangeOrderButtons ? showChangeOrderButtons = false : showChangeOrderButtons = true"
												class="button is-rounded is-small is-pulled-right">
											<span class="icon">
												<i class="fas fa-arrows-alt-v"></i>
											</span>
											<span>Change order</span>
										</button>
									</div>
									
									<!-- ROWS -->
									<div class="field">
										<div class="is-fullwidth">
											<div class="menuRows">
												<span v-for="(m, index) in mealGroups" :key="index"
													class="menuRow"
													@click.prevent="selMealGroup = m"
													>
													{{ m.name }}
													<button @click.prevent="deleteItem(mealGroups, m.id)" class="delete deleteGroup"></button>
													<span v-if="showChangeOrderButtons && mealGroups.length>1">
														<button class="iconButton" @click.prevent="move(mealGroups, 'bottom', m)"><span class="move moveBottom"></span><span class="arrowLineBottom"></span></button> 
														<button class="iconButton" @click.prevent="move(mealGroups, 'down', m)"><span class="move moveDown"></span></button> 
														<button class="iconButton" @click.prevent="move(mealGroups, 'up', m)"><span class="move moveUp"></span></button> 
														<button class="iconButton" @click.prevent="move(mealGroups, 'top', m)"><span class="move moveTop"></span><span class="arrowLineTop"></span></button>
													</span>
												</span>
											</div>										
										</div> 
									</div>
									<br><br>
								</span>

								<!-- Create meals/dishes -->
								<span v-if="step==3">
									<p class="subtitle is-3">3. Create dishes</p>
									<small>For example: Margherita, Bolognese, Perfetto</small>
									<br><br>
									
									<!-- mealGroups select     v-if="mealGroups.length>1"
									set only mealGroup selected -->
									<MealGroups @clicked="mealGroupChildSel" :mealGroups="mealGroups" :meals="meals" :selMealGroup="selMealGroup" />
									<br><br><!--
									<div v-if="mealGroups.length<6" class="field has-addons">
										<p v-for="mg in mealGroups"
															:key="mg.id" 
															class="control">
											<button class="button"
															v-on:click.prevent="selMealGroup = mg.id"
															:class="selMealGroup == mg.id ? 'is-primary' : ''"
															>{{ mg.name }} - <small>{{ meals.reduce((pre, cur) => (cur.group === mg.id) ? ++pre : pre, 0) }} meals</small>
											</button>
										</p>
									</div> -->

									<!-- add meal -->
									<span v-if="selMealGroup != -1">
										<label>Add dish name</label>
										<div class="field has-addons is-fullWidth" style="clear:left">
											<p class="control has-icons-right wide">
											<!--
											<input class="input wide" type="text" 
													placeholder="Example: Margherita"
													v-model="newMeal"                            
													style="z-index:0"
													:class="lenExceeded[0] ? 'exceedTextLength' : ''"
													>-->
													<!--:class="charsLeft(50, newMeal)[0] ? 'exceedTextLength' : ''" -->													
													CHR:<Charsleft :data="newMeal" :max=5 @lenChanged="charsLeftGuard" />
									 <!-- <span class="is-right">												
												<span class="textLimiter is-pulled-right is-size-7" 
														:class="charsLeft(50, newMeal)[0] 
														? 'has-text-danger' 
														: ''">{{ charsLeft(50, newMeal)[1] }}</span> 
											</span>-->
											</p>
											<input v-model="newMealPrice" class="input mealPrice" placeholder="0.00" type="text" value="2">
											<span class="priceCurrency">€</span>
											<div class="control">
											<!-- addFoodType($event.target.value)" v-model="selFoodType"> -->
												<a @click.prevent="addMeal(newMeal, newMealPrice), newMeal = ''" class="button is-primary"
													:disabled="charsLeft(50, newMeal)[0]"
												>Add</a>
											</div>
										</div> 
										<!-- temp for testing -->										
										<button @click.prevent="addTestMeals" class="button is-primary is-rounded">
												<span>Add test meals</span>
										</button>
										<br> 

										<!-- import dish names  WORKING
										<label>Import dish names</label>
										<ImportMultiple @add="addMultipleMeals" /> -->

										<!-- import dish names with price for all -->
										<div class="field has-addons is-fullWidth" style="clear:left">
											<p class="control has-icons-right wide">
											<input v-model="newMealPrice" class="input mealPrice" placeholder="0.00" type="text" value="2">
											<span class="priceCurrency">€</span>
											</p>
											<div class="control">
												<ImportMultiple @add="addMultipleMeals" placeholderText="Dish name(s)" />
											</div>
										</div><br> 

										<!-- ORIGINAL MASS IMPORT CONTROL
										<div class="field has-addons is-fullWidth" style="clear:left">
											<p class="control has-icons-right wide">
												<textarea v-model="importMeals"
														style="z-index:0"
														:class="charsLeft(2000, importMeals)[0] ? 'exceedTextLength' : ''"											
														class="input wide" type="text"
												></textarea>
												<span class="is-right">												
													<span style="margin-top:1px" class="textLimiter is-pulled-right is-size-7" 
															:class="charsLeft(2000, importMeals)[0] 
															? 'has-text-danger' 
															: ''">{{ charsLeft(2000, importMeals)[1] }}</span> 
												</span>
											</p>
											<button @click.prevent="addMultipleMeals" class="button is-primary is-outlined">Import</button>
										</div>
										-->

										<!--
										<button @click.prevent="showChangeOrderButtons ? showChangeOrderButtons = false : showChangeOrderButtons = true" 											
											class="button is-primary is-small"
											style="float:right">
											<span class="icon changeOrder"></span>
											<span> Change order</span>
										</button>

										<div class="is-pulled-right">
											<button @click.prevent="showChangeOrderButtons ? showChangeOrderButtons = false : showChangeOrderButtons = true"
														class="button is-rounded is-small">												
												<span class="icon changeOrder"></span>
												<span>Change order</span>
											</button>
										</div>-->

										
									<div v-if="meals.length>1" class="is-pulled-right">										
										<button @click.prevent="selMeal.desc = clipboardDesc" class="button is-rounded is-small">Paste description</button>
										<button @click.prevent="clipboardDesc = selMeal.desc" class="button is-rounded is-small">Copy description</button>
										&nbsp;
										<button @click.prevent="selMeal.price = clipboardPrice" class="button is-rounded is-small">Paste price</button>
										<button @click.prevent="clipboardPrice = selMeal.price" class="button is-rounded is-small">Copy price</button>
									
										
										<button @click.prevent="showChangeOrderButtons ? showChangeOrderButtons = false : showChangeOrderButtons = true"
												class="button is-rounded is-small is-pulled-right">
											<span class="icon">
												<i class="fas fa-arrows-alt-v"></i>
											</span>
											<span>Change order</span>
										</button>
									</div>

								<!--
									<MenuEditableListing 
									  @newUpdateMealFromEditableListing="updateMealFromComponent"
										:mealGroups="mealGroups" 
										:meals="meals" 
										:selMeal="selMeal" 
										:selMealGroup="selMealGroup" 
										:variations="variations" 
										:editedMeal="editedMeal"
										:showChangeOrderButtons="showChangeOrderButtons"
										/>
										<br><br>
										-------------------------
										<br><br>-->

										<!-- ROWS -->
										<div class="field">
											<div class="is-fullwidth">
												<div class="menuRows">
													<span v-for="(sm, idx) in meals" :value="sm.id" :key="sm.id"
														@click.prevent="selMeal = sm"
														>
														<span v-if="sm.group == selMealGroup"
															class="menuRow" 
															:class="selMeal == sm ? 'selected' : ''">
															<!-- edit meal name form-->
															<span v-if="editedMeal == sm">
																{{ idx+1 }}. 
																<!-- edit name -->
																<input class="input" type="text" 
																		v-model="editedMeal.name"
																		:class="charsLeft(50, editedMeal)[0] ? 'exceedTextLength' : ''"
																		style="width:unset"
																		>
																<span class="is-right">												
																	<span class="textLimiter is-pulled-right is-size-7" 
																			:class="charsLeft(50, editedMeal)[0] 
																			? 'has-text-danger' 
																			: ''">{{ charsLeft(50, editedMeal)[1] }}</span> 
																</span>
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
																		:class="charsLeft(255, editedMeal.desc)[0] ? 'exceedTextLength' : ''">
																<span class="is-right">												
																	<span class="textLimiter is-pulled-right is-size-7" 
																			:class="charsLeft(255, editedMeal.desc)[0] 
																			? 'has-text-danger' 
																			: ''">{{ charsLeft(255, editedMeal.desc)[1] }}
																	</span> 
																</span>
															</span>

															<!-- show meal name as text -->
															<span v-else>
																{{ idx+1 }}. 
																{{ sm.name }}
																({{ sm.orderId}})
																<button @click.prevent="deleteItem(meals, sm.id)" class="delete deleteGroup"></button>														
																<span @click.prevent="editedMeal = sm, origMeal = sm" class="iconButton editMeal"></span>
																<!--<span @click.prevent="cloneMeal(sm, editedMeal), origMeal = sm" class="iconButton editMeal"></span> KESKEN-->
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
										<br><br>

									</span>
								</span>

								<!-- Select ingredients -->
								<span v-if="step==4">
									<p class="subtitle is-3">4. Select dish ingredients</p>
									<small>For example: Chicken, Goat cheese, Jalapeno, Ruccola</small>
									<br><br>
									<!-- mealGroups select -->
									<MealGroups @clicked="mealGroupChildSel" :mealGroups="mealGroups" :meals="meals" :selMealGroup="selMealGroup" />
									<br><br><!--
									<div class="is-pulled-right">
										<button @click.prevent="clipboard = selMeal.ingredients" class="button is-rounded is-small">Copy ingredients</button>
										<button @click.prevent="selMeal.ingredients = clipboard" class="button is-rounded is-small">Paste ingredients</button>
									</div>-->
									<div v-if="earlierUsedIngredients.length>0" class="is-pulled-right">										
										<button @click.prevent="selMeal.ingredients = clipboardIngredients" class="button is-rounded is-small">Paste ingredients</button>
										<button @click.prevent="clipboardIngredients = selMeal.ingredients" class="button is-rounded is-small">Copy ingredients</button>
									</div>

									<label>Meals in this group</label>
									<MenuListing :mealGroups="mealGroups" :meals="meals" :selMeal="selMeal" :selMealGroup="selMealGroup" :variations="variations" />
									<!-- <MealGroups @clicked="mealGroupChildSel" :mealGroups="mealGroups" :meals="meals" :selMealGroup="selMealGroup" />	-->

									<!-- ROWS 
									<div class="field">
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
														<span class="menuRowIngredients">
															<small v-for="i in sm.ingredients" :value="i.id" :key="i.id" class="tag is-primary is-medium">
																{{ i.name }}
																<button @click.prevent="ingredient('d', i, sm)" class="delete is-small"></button>
															</small>
														</span>
													</span>
												</span>
											</div><br>										
										</div> selMeal: {{ selMeal }}
									</div>
									-->
									<br><br>
									
									<!-- panel toggle button -->
									<button @click.prevent="ingredientPanelToggle ? ingredientPanelToggle = false : ingredientPanelToggle = true"
												class="panelToggleButton button is-pulled-right"
												:class="!ingredientPanelToggle ? 'isClosed' : ''">

											<span v-show="!ingredientPanelToggle" class="icon">
												<i class="fas fa-chevron-up"></i>
												<span>Show ingredient list</span>
											</span>

											<span v-show="ingredientPanelToggle" class="icon" style="display:contents">
												<i class="fas fa-chevron-down"></i>
												<span >Hide ingredient list</span>
											</span>
									</button>

									<!-- panel -->
									<div v-show="ingredientPanelToggle" class="panel">
										<label>Ingredient list</label>

										<div class="panelTools">
											<label class="is-checkbox is-primary is-rounded">
												<input 
												  checked="checked" type="checkbox"
													v-model="addToAllMeals"
  												true-value="1"
  												false-value="0">
												<span  class="icon checkmark">
													<i class="fa fa-check"></i>
												</span>
												<span>Add to all dishes</span>
											</label>
										</div>

										<!-- ingredient categories -->
										<label>Ingredient category</label>
										<div class="field has-addons is-center">
											<span v-for="ic in ingedientCats" :key="ic.id" :value="ic.id" class="control">
												<button class="button"
													:class="ingedientCat == ic.id ? 'is-primary' : ''"
													@click.prevent="ingedientCat = ic.id"
												>{{ ic.name }}</button>
											</span>
										</div>
										<!-- earlier selected ingredients-->
										<div v-show="ingedientCat == 0" class="tags possibleIngredients">
											<span v-for="i in earlierUsedIngredients" :key="i.id" :value="i.id"													
												class="tag is-primary is-medium"
												@click.prevent="ingredient('a', i)"
												>
												{{ i.name }}
												<i class="fas fa-plus-circle fa-inverse"></i>
											</span>
											<span v-if="earlierUsedIngredients.length == 0">You haven't selected any ingredients yet. Select another ingredient category.</span>
										</div>
										<!-- list of possible ingredients -->
										<div v-show="ingedientCat != 0" class="tags possibleIngredients">
											<span v-for="i in ingredients" :key="i.id" :value="i.id"
												v-show="ingedientCat == i.cat"
												class="tag is-primary is-medium"
												@click.prevent="ingredient('a', i)"
												>
												{{ i.name }}
												<i class="fas fa-plus-circle fa-inverse"></i>
											</span>
										</div>
									</div> <!-- ingredientPanel -->									
								</span>

								<!-- Meal options -->
								<span v-if="step==5">
									<p class="subtitle is-3">5. Options</p>
									<br><br>

									<!-- mealGroups select -->
									<MealGroups @clicked="mealGroupChildSel" :mealGroups="mealGroups" :meals="meals" :selMealGroup="selMealGroup" />
									<br><br>
<!-- xxxxxxxxxxx -->
									<!-- panel toggle button -->
									<button @click.prevent="variationPanelToggle ? variationPanelToggle = false : variationPanelToggle = true"
												class="panelToggleButton button is-pulled-right"
												:class="!variationPanelToggle ? 'isClosed' : ''">

											<span v-show="!variationPanelToggle" class="icon">
												<i class="fas fa-chevron-up"></i>
												<span>Show variation panel</span>
											</span>

											<span v-show="variationPanelToggle" class="icon" style="display:contents">
												<i class="fas fa-chevron-down"></i>
												<span >Hide variation panel</span>
											</span>
									</button>

									<!-- panel -->
									<div v-show="variationPanelToggle" class="panel">
										<label>Add variation</label>

										<div class="panelTools">											
											<button @click.prevent="clipboardVariations = selMeal.variations" class="button is-rounded is-small">Copy options</button>
											<button @click.prevent="selMeal.variations = clipboardVariations" class="button is-rounded is-small">Paste options</button>
										</div>

										<!-- add variation  -->
										<small>For example: Select size: Small, Medium +1.50€, Large +3.00€</small>
										<div class="field has-addons" style="clear:left;display:inline-flex">
											<p class="control has-icons-right wide">
											<input class="input wide" type="text" 
													placeholder="Example: Large"
													v-model="variation"                            
													style="z-index:0"
													:class="charsLeft(20, variation)[0] ? 'exceedTextLength' : ''
													">
											<span class="is-right">												
												<span class="textLimiter is-pulled-right is-size-7" 
														:class="charsLeft(20, variation)[0] 
														? 'has-text-danger' 
														: ''">{{ charsLeft(20, variation)[1] }}</span> 
											</span>
											</p>
											<!-- price add -->							
											<div class="select level-left">
												<select v-on:change="priceAddEuros = $event.target.value" 
													v-model="priceAddEuros"
													class="noBorderRadius">
													<option :value="0">Euros</option>
													<option v-for="moneyCounter1 in 11"
													:key="moneyCounter1"
													:value="moneyCounter1-1"
													>+{{ moneyCounter1-1 }}</option>
												</select>
											</div><span class="priceCurrency">€</span>&nbsp;
											<div class="select">
												<select v-on:change="priceAddCents = $event.target.value" 
													v-model="priceAddCents"
													class="noBorderRadius">
													<option :value="0">Cents</option>
													<option v-for="moneyCounter2 in 20" 
													:key="moneyCounter2*5-5"
													:value="moneyCounter2*5-5"
													>{{ moneyCounter2*5-5 }}
													</option>
												</select>
											</div>
											<span class="priceCurrency">C</span>
											<div class="select" style="margin-left:-3px">
												<select v-on:change="priceAddTarget = $event.target.value" 
													v-model="priceAddTarget"
													class="noBorderRadius">
													<option :value="0">Add to selected dish only</option>
													<option :value="1">Add to all dishes in this group</option>
												</select>
											</div>
											<div class="control">
												<a @click.prevent="addVariation" class="button is-primary"
													:disabled="charsLeft(20, variation)[0]"
												>Add</a>
											</div>
										</div><br>
										<!-- variation tags -->
										<div class="tags">
											<span v-for="v in variations" :key="v.id"
												class="tag is-primary is-medium">
												{{ v.name }} +{{ v.priceAdd }}€
												<button @click.prevent="deleteVariation(v.id)" class="delete is-small"></button>
											</span>
										</div> 										
									</div> <!-- panel -->

									 <MenuListing :mealGroups="mealGroups" :meals="meals" :selMeal="selMeal" :selMealGroup="selMealGroup" :variations="variations" />
									<!-- <MealGroups @clicked="mealGroupChildSel" :mealGroups="mealGroups" :meals="meals" :selMealGroup="selMealGroup" />	-->
									<!--
									<div class="field">
										<!-- ROWS 
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
														<span class="menuRowIngredients">
															<small v-for="i in sm.ingredients" :value="i.id" :key="i.id">
																{{ i.name }}
															</small>
														</span>
														<br>Variations: 
														<!-- meal variation tags 
														<div v-if="sm.variations" class="tags">
															<span v-for="vId in sm.variations.split(',')" :value="vId" :key="vId"
																class="tag is-primary is-medium">
																{{ variations.find(v => v.id == vId).name }}
																+{{ variations.find(v => v.id == vId).priceAdd }}€
																 delete:{{ vId }}
																<button @click.prevent="deleteMealVariation(vId, sm)" class="delete is-small"></button>
															</span>
														</div>
													</span>
													<!--
													<span class="menuRowIngredients">
														<small v-for="vId in sm.variations.split(',')" :key="vId">
															<span v-for="v in variations"> <!--  :item="variations.find(va => va.id == vId)"> -->
														<!--		{{ item.name }} +{{ item.priceAdd }}€
															</span>
														</small>-->
														<!--
															<span v-if="variations.find(v => v.id == sm.variations)">
																{{ v.name }} +{{ v.priceAdd }}€
															</span>
													</span>
													--
												</span>
											</div><br>
										</div>
									</div>
										-->
								</span>


								<!-- Preview -->
								<span v-if="step==6">
									<p class="subtitle is-3">6. Preview menu</p>
									<br><br>
									<div class="field">

										<!-- mealGroups select -->
										<MealGroups @clicked="mealGroupChildSel" :mealGroups="mealGroups" :meals="meals" :selMealGroup="selMealGroup" />
										<br><br>

										<MenuListing :mealGroups="mealGroups" :meals="meals" :selMeal="selMeal" :selMealGroup="selMealGroup" :variations="variations" />
										<!-- ROWS 
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
														<!-- ingredients 
														<span class="menuRowIngredients">
															<small v-for="i in sm.ingredients" :value="i.id" :key="i.id">
																{{ i.name }}
															</small>
														</span>
														<!-- variations 
														<div v-if="sm.variations">
															<span v-for="vId in sm.variations.split(',')" :value="vId" :key="vId"
																class="">
																{{ variations.find(v => v.id == vId).name }}
																+{{ variations.find(v => v.id == vId).priceAdd }} €, &nbsp;
															</span>
														</div>
													</span>
												</span>
											</div><br>
										</div>-->
									</div>
								</span>








								<!--		</span> -->  <!-- meals.length>0 -->
								<!--	</span> --> <!-- selMealGroup == -1 -->
								<!-- </span> -->  <!-- mealGroups.length>0 -->

								<!-- save btn -->  
								<br>
                <div class="field">
                  <div class="control">
										<!--
                    <button v-if="step<6" type="submit" @click.prevent="next"
                      class="button is-primary is-fullwidth">Next</button>

										<button v-if="step>5" type="submit" @click.prevent="save"
                      class="button is-primary is-fullwidth">Save menu</button>-->

										<div class="columns is-centered is-fullwidth">
											<div v-if="step>1" class="column is-4">
										    <button type="submit" @click.prevent="next('left')"
													class="button is-primary is-fullwidth is-outlined is-pulled-left">
										      <span class="icon"><i class="fas fa-arrow-circle-left"></i></span>
										      <span>Previous</span>
										    </button>
											</div>

										  <div v-if="step<6" class="column is-4">
										    <button type="submit" @click.prevent="next('right')"
													class="button is-primary is-fullwidth is-pulled-right">
										      <span>Next</span>
										      <span class="icon"><i class="fas fa-arrow-circle-right"></i></span>
										    </button>
											</div>

											<div v-if="step>5" class="column is-4">
										    <button type="submit" @click.prevent="next('right')"
													class="button is-primary is-fullwidth is-pulled-right">
										      <span>Finished</span>
										      <span class="icon"><i class="fas fa-check-circle"></i></span>
										    </button>
											</div>
										</div>
										<div v-if="step==4 || step==5" id="bottomFiller"></div>
  

                  </div>
                </div>

							
							</form>
						</div>
						<hr>
						<!-- preview of menu 
						<div class="column is-8">
							<div v-for="g in mealGroups" :value="g.id" :key="g.id">
								Group {{ g.name }}<br>
								<div v-for="m in meals" :key="m.id">
									<div v-if="m.group = g.id"> {{ m.name }}</div><br>
								</div>

							</div>

							<br><br>
											DEBUG<br>
											groups  {{ mealGroups }}<br>
											meals  {{ meals }}<br>
											earlierUsedIngredients  {{ earlierUsedIngredients }}<br>

						</div>
						-->
					</div>
				</div>
			</section>
		</div>
	</div>
</template>

<script>
import MealGroups from './MealGroups'
import Charsleft from './Charsleft'
import ImportMultiple from './ImportMultiple'
import MenuEditableListing from './MenuEditableListing'
import MenuListing from './MenuListing'
import { mapGetters, mapActions } from "vuex"
export default {
	name: 'Menu',
	components: {
		MealGroups,
		Charsleft,
		ImportMultiple,
		MenuEditableListing,
		MenuListing
  },
	data () {
		return {
			steps: [
				{ "id":  1, "isCompleted": 0, "title": "Food types" , "desc": "For example: Pizza, Texmex, Kebab, Vegetarian.<br><br>This list is visible in retaurant listing for customers to quickly know what types of foods do you offer. They are presented in the order you select them."},
				{ "id":  2, "isCompleted": 0, "title": "Groups" , "desc": "For example: Appetizers, Pizzas, Pastas, Sallads, Beverges.<br>These are groups under which you can add individual dishes. They can be same or different than Food groups."},
				{ "id":  3, "isCompleted": 0, "title": "Dishes & prices" , "desc": "For example: Margherita, Bolognese, Perfetto"},
				{ "id":  4, "isCompleted": 0, "title": "Ingredients" , "desc": "For example: Chicken, Goat cheese, Jalapeno, Ruccola"},
				{ "id":  5, "isCompleted": 0, "title": "Options" , "desc": ""},
				{ "id":  6, "isCompleted": 0, "title": "Preview" , "desc": ""},
			],
			step: 1,			
			XXXXFoodTypes: [
				{ "id":  1, "name": "Aasialainen" },
				{ "id":  2, "name": "Falafel" },
				{ "id":  3, "name": "Grillattua kanaa" },
				{ "id":  4, "name": "Grilliruokaa" },
				{ "id":  5, "name": "Hampurilaiset" },
				{ "id":  6, "name": "Intialainen" },
				{ "id":  7, "name": "Japanilainen" },
				{ "id":  8, "name": "Kalaruoat" },
				{ "id":  9, "name": "Kanafileet" },
				{ "id": 10, "name": "Kanakebabit" },
				{ "id": 11, "name": "Kansainvalinen" },
				{ "id": 12, "name": "Kasviruokaa" },
				{ "id": 13, "name": "Kasviskebabit" },
				{ "id": 14, "name": "Kebabit" },
				{ "id": 15, "name": "Kiinalainen" },
				{ "id": 16, "name": "Leikkeet" },
				{ "id": 17, "name": "Meksikolainen" },
				{ "id": 18, "name": "Nepalilainen" },
				{ "id": 19, "name": "Pastat" },
				{ "id": 20, "name": "Pihvit" },
				{ "id": 21, "name": "Pizzat" },
				{ "id": 22, "name": "Rullat" },
				{ "id": 23, "name": "Rullakebabit" },
				{ "id": 24, "name": "Salaatit" },
				{ "id": 25, "name": "Sushit" },
				{ "id": 26, "name": "Tex Mex" },
				{ "id": 27, "name": "Thaimaalainen" }
			],
			selFoodType: -1,
			selFoodTypes: [],
			mealGroups: [], 
			selMealGroup: -1,
			//newMealGroup: '',
			//importGroups: '',
			meals: [],
			selMeal: -1,
			clipboardPrice: null,
			clipboardDesc: null,
			clipboardIngredients: null,
			clipboardVariations: null,
			editedMeal: null,
			origMeal: null,
			newMeal: '',
			newMealPrice: '',
			addToAllMeals: '0',
			//importMeals: '',
			showChangeOrderButtons: false,
			ingredientPanelToggle: true,			
			XXXXingredientsStr: 'Ananasta,Ananasta,Anjovista,Artisokkaa,Aurajuustoa,Aurinkokuivattuja tomaatteja,Avocadoa,Balsamicoa,Balsamicosipuleita,Barbeque-kastiketta,Basilikaa,Bolognese-kastiketta,Béarnaise-kastiketta,Caesar-kastiketta,Chilihiutale,Chorizo-makkaraa,Etanoita,Fetajuustoa,Grillattua munakoisoa,Habaneromurskaa,Herkkusieniä,Herkkutatteja,Hirveä,Härkää,Jalapenoa,Juustoa,Jättikaprista,Jättikatkaravunpyrstöjä,Kaktussuikaleita,Kanaa,Kananmunaa,Katkarapuja,Kebablihaa,Kinkkua,Kirsikkatomaattia,Kylmäsavulohta,Lisäjuustoa,Luomuhunajaa,Marinoitua seitanlastua,Mascarpone-tuorejuustoa,Metsäsieniä,Mozzarellaraastetta,Mustekalaa,Napoli -salamin siivuja,Nyhtöpossua,Oliiveja,Paneroituja mustekalarenkaita,Paprikaa,Parmankinkkua,Parmesan lastuja,Parmesan-juustoa,Parsaa,Pekonia,Pepperonimakkaraa,Persikkaa,Pestokastiketta,Pinjansiemeniä,Provolonejuustoa,Punasipulia,Puolukkahilloa,Päärynää,Rucolaa,Saksanpähkinää,Salamia,Salsicciaa,Savuriistakäristystä,Simpukoita,Sipulia,Teriyaki kanaa,Teriyakikanaa,Tilliä,Tomaattia,Tomaattisiivuja,Tomaattisosetta,Tonnikalaa,Tulista chilihilloa,Tuoremozzarellaa,Tuoretta basilikaa,Valkosipulia,Vegaanijuusto,Villisikaa,Vuohenjuustoa',
			ingedientCats: [
				{ "id": 0 , "name": "Aiemmin valitut" },
				{ "id": 1 , "name": "Liha, kana kala, merelliset" },
				{ "id": 2 , "name": "Vihannekset" },
				{ "id": 3 , "name": "Hedelmät" },
				{ "id": 4 , "name": "Juustot" },
				{ "id": 5 , "name": "Mausteet" },
				{ "id": 6 , "name": "Muut" }
			],
			ingredientCat: 1,
			XXXXingredients: null,			
			ingedientCat: 1,
			earlierUsedIngredients: [],
			selIngredients: [],
			variationPanelToggle: true,
			toAll: false,
			variations: [],
			variation: '',
			priceAddEuros: 0,
			priceAddCents: 0,
			moneyCounter1: 0,
			moneyCounter2: 0,
			priceAddTarget: 0,
			isSaved: false
		}
	},
	methods: {		
      charsLeftGuard (val) {
				console.log('CharsLeftGuard:', val);
			//	this.newMeal = 'xxx' + val;
				//let id = val.split(',')[0];
				//let len = val.split(',')[1];
				// <MealGroups @clicked="mealGroupChildSel" :mealGroups="mealGroups" />
      },
      mealGroupChildSel (val) {
				this.selMealGroup = parseInt(val);
			},
			updateMealFromComponent (arr) {
				console.log('updateMealFromComponent: arr: ', arr);
			},
			addOrRemoveInArray(action, existingStr, item) {
			let arr = [];
			if(existingStr != '') { arr = existingStr.split(","); }
			if(action == 'add') { arr.push(item); }
			if(action == 'delete') { arr.splice(arr.indexOf(item), 1); }
			return arr.join();
		},
		deleteMealVariation(vId, selectedMeal=null) {
			if(selectedMeal) { this.selMeal = selectedMeal; }
			let mealIndex = this.meals.findIndex(el => el.id === this.selMeal.id);
			this.meals[mealIndex].variations = this.addOrRemoveInArray('delete',this.meals[mealIndex].variations, vId);
		},
		addVariation() {
			// adds variation to one or all meals in group
			const newVariation = clean(this.variation.trim());
			if(newVariation == '') { return; }
			// check if exists already			
			let index = this.variations.findIndex(el => el.name === newVariation);			
			let totVariations = this.variations.length;
			let priceAdd = parseFloat(0);
			if(this.priceAddEuros > 0) { priceAdd += parseFloat(this.priceAddEuros); }
			if(this.priceAddCents > 0) { priceAdd += parseFloat(this.priceAddCents)/100; }
			if(this.priceAddEuros > 0 || this.priceAddCents > 0) { priceAdd = parseFloat(priceAdd).toFixed(2); }
			if(index == -1) {				
				let selMealId = null;
				let selGroupId = null;
				if(this.priceAddTarget == 0) {
					// add to one meal
					selMealId = ''+this.selMeal.id;
					let mealIndex = this.meals.findIndex(el => el.id === this.selMeal.id);
					this.meals[mealIndex].variations = this.addOrRemoveInArray('add',this.meals[mealIndex].variations, totVariations);
				} else {
					// add to all meals in  group
					selGroupId = ''+this.selMealGroup;
					for( let i = 0; i < this.meals.length; i++){ 
						if (this.meals[i].group == selGroupId) {
							this.meals[i].variations = this.addOrRemoveInArray('add', this.meals[i].variations, totVariations);
						}
					}
				}				
				// add to variations
				this.variations.push({  "id": totVariations, 
										/*"groupId": ''+selGroupId, 
										"mealId": ''+selMealId, */
										"name": newVariation, 
										"priceAdd": priceAdd, 
										"orderId": totVariations });
				// reset
				this.variation = '';
				this.priceAddEuros = 0;
				this.priceAddCents = 0;
			}		
		},
		// deletes variation from all meals in group
		deleteVariation(id) {
			// delete from variation tags
			this.deleteItem(this.variations, id);
			// for( let i = 0; i < this.variations.length; i++){ 
			// 	if ( this.variations[i].id === id) {
			// 		this.variations.splice(i, 1); 
			// 		i--;
			// 	}
			// }

			// delete from meals
			let selGroupId = ''+this.selMealGroup;
			for( let i = 0; i < this.meals.length; i++){ 
				if (this.meals[i].group == selGroupId) {
					this.meals[i].variations = this.addOrRemoveInArray('delete', this.meals[i].variations, id);
				}
			}			
		},
		toAllMeals: function(val) {
			console.log('chack:', val);
			//@change="toAllMeals ? Meals = false : toAllMeals = true"

		}, /*
		// returns the meal obj taht has lovest orderId
		getMostTopMeal()	{
			let min = Math.min(...this.meals.map(item => item.orderId));
			return data.filter(item => item.rest === min);
		}, */
		next(direction) {
			if(direction=='right') {
				// check at least one item was added
				switch(this.step) {
					case 1: if(this.selFoodTypes.length>0) { this.steps[0].isCompleted = 1; this.step++; } break;
					case 2: if(this.mealGroups.length>0) 
						{ 
							this.steps[1].isCompleted = 1;
							// set 1st mealGroup selected - not working
							if(this.mealGroups.length<6) { // && this.selMealGroup == -1) { 
									//this.selMealGroup = this.mealGroups.find(obj => { return obj[0]});
									//this.selMealGroup = this.mealGroups[0]; // set first mealGroups selected
							}
							this.step++;
						}
						break;
					case 3: if(this.meals.length>0) { this.steps[2].isCompleted = 1; this.step++; } break;
					case 4: this.steps[3].isCompleted = 1; this.step++; break; // optional step
					case 5: this.steps[4].isCompleted = 1; this.step++; break;
				}			
			} else {
				// left
				if(this.step>1) { this.step--; }
			}
		},		
		save() {
			// validate

			// save meals
			// restaurantId,groupId,name,descriptionText,ingredientIds,price



			// after save:
			this.isSaved = true;

		},		
		ingredient(action, ingredient, selectedMeal=null) {
			ingredient.name = clean(ingredient.name.trim());

			if(selectedMeal) { this.selMeal = selectedMeal; }
			let mealIndex = this.meals.findIndex(el => el.id === this.selMeal.id);
			let ingrIndex = -1;

			if(typeof this.selMeal.ingredients !== 'undefined' && this.selMeal.ingredients.length > 0) {
				let currIngrArr = this.selMeal.ingredients;
				// check if exists
				ingrIndex = currIngrArr.findIndex(el => el.id === ingredient.id);
				// delete ingredient
				if(action == 'd') {			
					// this.meals[mealIndex].ingredients.push({ "id": ingredient.id, "name": ingredient.name });
					let tempIngr = this.meals[mealIndex].ingredients;
					tempIngr = tempIngr.filter(el => el.id !== ingredient.id);
					this.meals[mealIndex].ingredients = tempIngr;
					//this.meals[mealIndex].ingredients = this.meals[mealIndex].ingredients.filter(el => el.id !== newIngredient.id);
				}
			}

			// add ingredient to meal
			if(action == 'a') {
				if(this.addToAllMeals == '0') {
					// add to one meal
					if(ingrIndex == -1) {					
						this.meals[mealIndex].ingredients.push({ "id": ingredient.id, "name": ingredient.name });
					}
				} else {
					// add to all meals in selected group
					let selGroupId = ''+this.selMealGroup;
					let ingredients = '';
					for( let i = 0; i < this.meals.length; i++){ 
						if (this.meals[i].group == selGroupId) { 
							let exists = this.meals[i].ingredients.find(elem => elem.id == ingredient.id);
							if(!exists) {
								this.meals[i].ingredients.push({ "id": ingredient.id, "name": ingredient.name });
							}
						}
					}
				}
			}

			// add to earlier used ingredients list
			ingrIndex = -1;
			if(typeof this.earlierUsedIngredients !== 'undefined' && this.earlierUsedIngredients.length > 0) {					
				ingrIndex = this.earlierUsedIngredients.findIndex(el => el.id === ingredient.id); // check if exists
			}
			// add if not found 
			if(ingrIndex == -1) {
				this.earlierUsedIngredients.push({ "id": ingredient.id, "name": ingredient.name });
			}
		},
		 mealChanged(val) {
            console.log('mealChanged:', val.target.value)
			 this.selMeal = val.target.value;
		}, /* IS THIS IN USE? */
		 mealGroupChanged(val) {
            console.log('- - - mealGroupChanged:', val.target.value)
			 this.selMealGroup = val.target.value;
		}, 
		addMeal(item, action=null, origMeal=null) {			
			if(action == 'cancelEditMeal') { 
				console.log('action: item:', item);	
				console.log('action: origMeal:', origMeal);	
				item = origMeal; return; 
			}
			item = clean(item.trim());
			if(item == '') { return; }
			let price = cleanPrice(this.newMealPrice.trim());
			// check if exists already
			let index = this.meals.findIndex(el => el.name === item);
			if(index == -1) {
				this.meals.push({ "id": this.meals.length, 
													"group": ''+this.selMealGroup, 
													"name": item, 
													"desc": "",
													"price": price, 
													"variations": "",  
													"ingredients": [], 
													"orderId": this.meals.length });				
			} else {
				// update meal
				this.meals[index].name = item;
			console.log('this.editedMeal.price before:', this.editedMeal.price);	
			console.log('this.editedMeal.price after:', cleanPrice(this.editedMeal.price.trim()));			
				this.meals[index].price = cleanPrice(this.editedMeal.price.trim());
				this.editedMeal = null;
			}
			if(this.selMeal == -1) { this.selMeal = this.meals[0]; } // set first selected
		},
		newUpdateMealFromEditableListing(arr) {
				// new update meal                    @newUpdateMealFromEditableListing="updateMealFromComponent"   code: this.$emit('clicked', event)   this.$emit('newUpdateMealFromEditableListing', updateMealFromComponent)
				let id = arr['id'];
				let name = arr['name'];
				let price = arr['price'];

				let index = this.meals.findIndex(el => el.id === id);
				if(index == -1) {
					this.meals[index].name = name;
					this.meals[index].price = cleanPrice(price.trim());
					//this.editedMeal = null;
				}
		},/*
		addMultipleMeals(data) {
			//data = data.replace(/(?:\r\n|\r|\n)/g, '#').trim();
			data = data.trim().split("#");
			for( let i = 0; i < data.length; i++){
				data[i] = clean(data[i]);
				if(data[i] != '') { this.addMeal(data[i]); }				
			}
			//this.importMeals = '';
		},*/
		 /*
		addMultipleMeals(data) {
			data = data.replace(/(?:\r\n|\r|\n)/g, '#').trim();
			data = data.split("#");
			for( let i = 0; i < data.length; i++){
				data[i] = clean(data[i]);
				if(data[i] != '') { this.addMeal(data[i]); }				
			}
			//this.importMeals = '';
		}, */
		addMultipleMeals(data) {
			this.addMultiple(data, 'meals');
			this.newMealPrice = '';
		},
		addTestMeals() {
			let data = "Alaska#Avocado#Avocado California#Avocado Maki#Corn Mayo Gunkan#Ebi#Epi nigiri#Futo Maki#Ika#Inari#Kalifornia maki#kappa#Kappa Maki#Kappa Maki#Kurkkumaki#lohi#Lohinigiri#Lohiuramaki#Maguro#Misokeitto#Mushroom Mayo Gunkan#Nuudelikeitto#Pulled Oat Mayo Gunkan#Riisiä#Shake#Shake Maki#Shake Sashimi#Shake Yaki#Spicy Shrimp Gunkan#Surimi Mayo Gunkan#Tako#Tamago#Tilapia#uramaki#Wakamesalaatti";
			let dataArr = data.split('#');
			for( let i = 0; i < dataArr.length; i++){
				this.addMeal(dataArr[i]);
			}
		},
		addMultiple(data, target) {
			data = data.replace(/(?:\r\n|\r|\n)/g, '#').trim();
			data = data.split("#");
			for( let i = 0; i < data.length; i++){
				data[i] = clean(data[i]);
				if(data[i] != '') { 
					switch(target) {
						case 'meals': this.addMeal(data[i]); break;
						case 'mealGroups': this.addMealGroup(data[i]); break;
					}
				}				
			}
			//this.importMeals = '';
		}, 
		deleteItem(data, removeId) {			
			for( let i = 0; i < data.length; i++){ 
				if (data[i].id === removeId) {
					data.splice(i, 1); 
					i--;
				}
			}
			return data;
		},
		move(data, direction, item) {
			data = changeOrder(data, direction, item);
		},
		addMealGroup(item) {
			// add a single mealGroup
			item = clean(item.trim());
			if(item == '') { return; }
			// check if exists already
			let index = this.mealGroups.findIndex(el => el.name === item);			
			if(index == -1) {
				this.mealGroups.push({ "id": this.mealGroups.length, "name": item, "variations": "",  "orderId": this.mealGroups.length });				
			}
			//this.selMealGroup = 1; // set first mealGroup selected 
		},
		addMultipleMealGroups(data) {
			this.addMultiple(data, 'mealGroups');
			/*
			let data = this.importGroups.trim();
			data = (data.replace(/(?:\r\n|\r|\n)/g, '#')).split("#");
			for( let i = 0; i < data.length; i++){ 
				data[i] = clean(data[i].trim());
				if(data[i] != '') { this.addMealGroup(data[i]); }				
			}
			this.importGroups = '';	
			*/		
		},
		copyFoodGroupsIntoMenuGroups() {
			let i = 0;
			let item;
			for(i; i < this.selFoodTypes.length; i++){
				item = this.selFoodTypes[i];
				let index = this.mealGroups.findIndex(m => m.name === item.name); // check if exists already
				if(index == -1) {
					item.orderId = this.mealGroups.length;
					item.variations = null;
					this.mealGroups.push(item);
				}
			}
		},
		cloneMeal(from, to) {		
let group = null;
let id = null;
let ingredients = null;
let name = null;
let desc = null;
let orderId = null;
let price = null;
let variations = null;

to.group = null;
to.id = null;
to.ingredients = null;
to.name = null;
to.desc = null;
to.orderId = null;
to.price = null;
to.variations = null;

if(from.group) { group = from.group; }
if(from.id) { id = from.id; }
if(from.ingredients) { ingredients = from.ingredients; }
if(from.name) { name = from.name; }
if(from.desc) { name = from.desc; }
if(from.orderId) { orderId = from.orderId; }
if(from.price) { price = from.price; }
if(from.variations) { variations = from.variations; }

if(from.group) { to.group = group; }
if(from.id) { to.id = id; }
if(from.ingredients) { to.ingredients = ingredients; }
if(from.name) { to.name = name; }
if(from.desc) { to.name = desc; }
if(from.orderId) { to.orderId = orderId; }
if(from.price) { to.price = price; }
if(from.variations) { to.variations = variations; }

//group
//id
//ingredients
//name
//orderId
//price
//variations
			//this.selMealGroup = 1; // set first mealGroup selected 
		},
		addFoodType(id) {
			
			// if max number selected
			if(this.selFoodTypes.length >7) return;
			// if exists already
			if(this.selFoodTypes.length > 0) {
				let exists = this.selFoodTypes.findIndex(el => el.id === id);
				if(exists != -1) return;
			}
			this.selFoodTypes.push({ "id": id, "name": this.foodTypes.find(k => k.id == id).name });
			this.selFoodType = -1;		
		},
		// calculates number of characters left, returns array: [is limit exceeded, characters left / max]
		charsLeft(maxLen, str) {
			return [ str.length > maxLen ? true : false,
			str.length > maxLen/2 ? maxLen - str.length + "/" + maxLen : ''];
		},
		forwardToNextPage() {
			// this.$router.replace({name: 'xxxxxxx'});
		},
		...mapActions(["getFoodTypes", "getIngredients", "saveFoodTypeIds", "saveMealGroups", "saveMeals", "saveIngredientsToMeals"])
	},
	watch: {
		//meals() {
		//	if(this.meals.length == 1) { this.selMeal = this.meals[0]; } // set first meal active
		//},
		step() {
			if(this.step > 3) { this.steps[this.step-1].isCompleted = 1; } // set optional parts completed after visited first time			
		}
	},
//	created: function () {
	created(){
		console.log('getFoodtypes CALLED in Menu.vue');
		this.getFoodTypes('fi');
		this.getIngredients();		
	},
	computed: mapGetters(["foodTypes", "ingredients"])
}
</script>

<style scoped>
.unSaved { 
	color: tomato;
    font-size: .85rem;
    margin-left: 10px;
}
.saved { 
	color:yellowgreen;
    font-size: .85rem;
    margin-left: 10px;
}
/* ----------------- steps ----------------- */
.steps {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    font-size: 1rem;
    min-height: 2rem
}
.steps .step-item {
    margin-top: 0;
    position: relative;
    -webkit-box-flex: 1;
    -ms-flex-positive: 1;
    flex-grow: 1;
    -ms-flex-preferred-size: 0;
    flex-basis: 0
}
.steps .step-item:not(:first-child) {
    -ms-flex-preferred-size: 1em;
    flex-basis: 1em;
    -webkit-box-flex: 1;
    -ms-flex-positive: 1;
    flex-grow: 1;
    -ms-flex-negative: 1;
    flex-shrink: 1;
}
.steps .step-item {
	padding-top: 25px;
    margin-top: -25px;
}
.steps .step-item:not(:first-child)::before {
    content: " ";
    display: block;
    position: absolute
}
.steps .step-item::before {
    background: -webkit-gradient(linear, right top, left top, color-stop(50%, #dbdbdb), color-stop(50%, #00d1b2));
    background: linear-gradient(to left, #dbdbdb 50%, #00d1b2 50%);
    background-size: 200% 100%;
    background-position: right bottom
}
.steps .step-item::before .step-marker {
    color: #fff
}
.steps .step-item.is-active::before {
    background-position: left bottom
}
.steps .step-item.is-active .step-marker {
    background-color: #fff;
    border-color: #00d1b2;
    color: #00d1b2
}
.steps .step-item.is-completed::before {
    background-position: left bottom
}
.steps .step-item.is-completed .step-marker {
    color: #fff;
    background-color: #00d1b2
}
.steps .step-item .step-marker {
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    border-radius: 50%;
    font-weight: 700;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    background: #b5b5b5;
    color: #fff;
    border: .2em solid #fff;
    z-index: 1
}
.steps .step-item .step-details {
    text-align: center
}
.steps .step-item.is-primary.is-active::before {
    background-position: left bottom
}
.steps .step-item.is-primary.is-active .step-marker {
    background-color: #fff;
    border-color: #00d1b2;
    color: #00d1b2
}
.steps .step-item.is-active:not(.current-step-item):hover { /* not:current-step-item */
	background-color: #e8e8e8;
    border-color: #828282;
    color: #828282;
	border-radius: 6px;
	cursor: pointer;
}
.steps .step-item.is-primary.is-completed::before {
    background-position: left bottom
}

.steps .step-item.is-primary.is-completed .step-marker {
    color: #fff;
    background-color: #00d1b2
}
.steps .steps-content {
    -webkit-box-align: stretch;
    -ms-flex-align: stretch;
    align-items: stretch;
    -ms-flex-preferred-size: 100%;
    flex-basis: 100%;
    margin: 2rem 0
}
.steps .steps-content .step-content {
    display: none
}
.steps .steps-content .step-content.is-active {
    display: block
}
.steps .steps-actions {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: stretch;
    -ms-flex-align: stretch;
    align-items: stretch;
    -ms-flex-preferred-size: 100%;
    flex-basis: 100%
}
.steps .steps-actions .steps-action {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-preferred-size: 0;
    flex-basis: 0;
    -webkit-box-flex: 1;
    -ms-flex-positive: 1;
    flex-grow: 1;
    margin: .5rem;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center
}
.steps .step-item:not(:first-child)::before {
    height: .2em;
    width: 100%;
    bottom: 0;
    left: -50%;
    /* top: 1rem */
}
.steps .step-item::before {
	top: 2.4rem;
}
.steps .step-item .step-marker {
    height: 2rem;
    width: 2rem;
    position: absolute;
    left: calc(50% - 1rem)
}
.steps .step-item .step-marker .icon * {
    font-size: 1rem
}
.steps .step-item .step-details {
    margin-top: 2rem;
    margin-left: .5em;
    margin-right: .5em;
    padding-top: .2em
}
.steps .step-item .step-details .step-title {
    font-size: 1.2rem;
    font-weight: 600
}
.current-step-item {
	background-color: #ddf9f5;
    border-radius: 6px;
}
.current-step-item .stepTitle {
	color: #00ae94;
    font-weight: bold;
}
/* ------------------ end steps ---------------- */






.instruction {
	clear: left;
	float: left;
	color: #b5b5b5;
}
.mealPrice {	
	width: 64px;
  padding-left: -5px;
  padding-right: 0 !important;
  padding-left: 6px !important;
}
.priceCurrency {
    position: relative;
    float: right;    
    right: 16px;
    top: 10px;
    margin-right: -9px;
    color: #c3c3c3;
    height: 24px;
}







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






.panel {
	border-top: solid 3px #42ac9b;
  position: fixed;
  z-index: 1;
  background-color: #fff;
  bottom: 0;
  padding: 29px 60px 30px 60px;
  left: 0;
  min-height: 40%;
  width: 100%;
}
.panelToggleButton  {
		position: fixed;
    z-index: 2;
    bottom: 40%;
    right: 0;
		border: none;
}
.panelToggleButton.isClosed {
	  border-top: solid 3px #42ac9b;
    border-radius: 4px;
    width: 100%;
    bottom: 0;
		border-radius: 0;
}
.panelToggleButton span span {
	margin-left: 8px;
}
.panelTools {
	text-align: right;
  padding: 10px;
}
#bottomFiller {
	height: 500px;
}
.is-center {
	  display: flow-root;
}
.possibleIngredients .tag {
	border: solid 1px #fff;
}
.possibleIngredients .tag svg {
	margin: 0 -6px 0 7px;
}
.possibleIngredients .tag:hover {
	cursor: pointer;
    background-color: #009982;
}

.possibleIngredients .tag > .selected {
	color: #00d1b2;
	border: solid 1px #00d1b2;
    background-color: #fff;
}
.noBorderRadius {
	border-radius: 0;
}

button:disabled,
button[disabled]{
  border: 1px solid #999999;
  background-color: #cccccc;
  color: #666666;
}


/* special checkbox button */
label.is-checkbox {
    background: #3273dc;
    border: 1px solid transparent;
    color: white;
    text-align: center;
    white-space: nowrap;
    display: inline-flex;
    justify-content: center;
    padding: calc(0.375em - 1px) 0.75em;
    border-radius: 2px;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
label.is-checkbox.is-rounded {
    border-radius: 9999px;
}
label.is-checkbox.is-primary {
    background: #00d1b2;
}

label.is-checkbox input[type="checkbox"] {
    position: absolute;
    visibility: hidden;
    cursor: pointer;
}
label.is-checkbox .checkmark:before {
    content: '';
    position: absolute;
    right: 0;
    left: 0;
    top: 0;
    bottom: 0;
    z-index: 0;
    border-radius: 2px;
    background: rgba(54, 54, 54, 0.3);
    border: 1px solid rgba(54, 54, 54, 0.2);
}

label.is-checkbox .icon, label.is-checkbox .icon.is-small, label.is-checkbox .icon.is-medium, label.is-checkbox .icon.is-large {
    height: 1.5em;
    width: 1.5em;
    margin-left: -0.35em;
    margin-right: 0.35em;
}
label.is-checkbox input[type="checkbox"]:checked ~ .checkmark {
    color: inherit;
}
label.is-checkbox .checkmark i {
    z-index: 1;
}
label.is-checkbox .checkmark:before {
    content: '';
    position: absolute;
    right: 0;
    left: 0;
    top: 0;
    bottom: 0;
    z-index: 0;
    border-radius: 2px;
    background: rgba(54, 54, 54, 0.3);
    border: 1px solid rgba(54, 54, 54, 0.2);
}
label.is-checkbox .checkmark {
    color: transparent;
    position: relative;
    border-radius: 9999px;
}
label.is-checkbox.is-rounded .checkmark:before {
    border-radius: 9999px;
}
label.is-checkbox .checkmark i,
label.is-checkbox .checkmark svg {
    z-index: 1;
}

.is-checkbox .fa-check:before {
    content: "\f00c";
}
/* not checked 
label.is-checkbox .isSelected .checkmark i {
    z-index: -1;
} */
/* ----------------------- */
</style>
