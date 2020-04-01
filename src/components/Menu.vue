<template>
	<div>
		<div class="container is-fluid">
			<section class="section">
				<div class="container has-text-centered">
					
					<div class="columns is-centered">
						<div class="column is-8">

							<p class="subtitle is-3">{{t.pageTitle}}
								<small v-if="!isSaved" class="unSaved">{{t.notSaved}}</small>
								<small v-else class="saved">{{t.saved}}</small>
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
									<p class="subtitle is-3">1. {{t.step1Title}}</p>
									<small v-html="t.step1Desc"></small>
									<!--<small class="instruction">This list is visible in retaurant listing for customers to quickly know what types of foods do you offer. They are presented in the order you select them.</small>-->
									<br><br>
									<!-- add FoodType -->
									<label>{{t.step1SubTitle}}</label>
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
									<p class="subtitle is-3">2. {{t.step2Title}}</p>
									<small v-html="t.step2Desc"></small>
									<br><br>
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
									<label>{{t.step2SubTitle}}</label>
									<div class="columns">
  									<div class="column is-6">
											<button @click.prevent="copyFoodGroupsIntoMenuGroups()" class="button is-primary">{{t.useFoodTypesAsMenuGroups}}</button>
										</div>
										<div class="column is-6">
												<ImportMultiple @add="addMultipleMealGroups" :placeholderText=t.step2Placeholder :btnText="t.addBtn" :toolTip=t.separateMultipleText />
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
											<span class="icon"><i class="fas fa-arrows-alt-v"></i></span><span>{{t.changeOrderBtn}}</span>
										</button>

										<button @click.prevent="showEditMealGroupButtons ? showEditMealGroupButtons = false : showEditMealGroupButtons = true"
												class="button is-rounded is-small">
											<span class="icon"><i class="fas fa-edit"></i></span>
											<span>{{t.editTextsBtn}}</span>
										</button>
									</div>
									

									<!-- ROWS -->
									<div class="field">
										<div class="is-fullwidth">
											<div class="menuRows">
												<span v-for="(m, index) in mealGroups" :key="index"
													class="menuRow"
													@click.prevent="selMealGroup = m.id"
													>
													{{ m.name }}
			<!-- edit group name form -->
													<span v-if="editedMealGroup == m"> <!-- addMultipleMealGroups -->
														<input class="input" type="text" 
																		v-model="editedMealGroup.name"
																		style="width:unset"
																		>
														<span @click.prevent="addMealGroup(editedMealGroup.name)" class="iconButton saveEditMeal"></span>
													</span>
			<!-- show group name as text -->
													<span v-else>
														{{ m.name }}														
														<button @click.prevent="deleteItem(mealGroups, m.id)" class="delete deleteGroup"></button>
														<small class="is-pulled-right">{{ meals.reduce((pre, cur) => (cur.groupId === m.id) ? ++pre : pre, 0) }} {{t.numberOfMealsText}}</small>
														<span v-show="showEditMealGroupButtons" @click.prevent="editedMealGroup = m" class="iconButton editMeal"></span>
														<span v-if="showChangeOrderButtons && mealGroups.length>1">
															<button class="iconButton" @click.prevent="move(mealGroups, 'bottom', m)"><span class="move moveBottom"></span><span class="arrowLineBottom"></span></button> 
															<button class="iconButton" @click.prevent="move(mealGroups, 'down', m)"><span class="move moveDown"></span></button> 
															<button class="iconButton" @click.prevent="move(mealGroups, 'up', m)"><span class="move moveUp"></span></button> 
															<button class="iconButton" @click.prevent="move(mealGroups, 'top', m)"><span class="move moveTop"></span><span class="arrowLineTop"></span></button>
														</span>
													</span>
												</span>
											</div>										
										</div> 
									</div>

									<br><br>
								</span>

								<!-- Create meals/dishes -->
								<span v-if="step==3">
									<p class="subtitle is-3">3. {{t.step3Title}}</p>
									 <small v-html="t.step3Desc"></small>
									<br><br>									
									<!-- mealGroups select     v-if="mealGroups.length>1"
									set only mealGroup selected -->
									<MealGroups @clicked="mealGroupChildSel" @displayTypeChanged="mealGroupDisplayTypeChildSel" :mealGroups="mealGroups" :meals="meals" :selMealGroup="parseInt(selMealGroup)" :numberOfMealsText="t.numberOfMealsText" :displayAs="displayMealGroupsAs" />
									<br><br>
									<!-- add meal -->
									<span v-if="selMealGroup != -1">
										<label>{{t.step3SubTitle}}</label>									

										<!-- temp for testing 	-->							
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
												<span class="priceCurrency">{{t.currency}}</span>
											</p><!--
											<p class="control has-icons-right wide">
												<span class="pickupPriceText">{{t.pickupPriceText}}</span>
												<input v-model="newMealPrice" class="input mealPrice" placeholder="0.00" type="text" value="2">
												<span class="priceCurrency">{{t.currency}}</span>
											</p>-->
											<div class="control">
												<ImportMultiple @add="addMultipleMeals" :placeholderText="t.step3Placeholder" :btnText="t.addBtn" :toolTip=t.separateMultipleTextWithPrice />
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
										<button @click.prevent="clipboardName = selMeal.name" class="button is-rounded is-small">{{t.step3CopyNameBtn}}</button>&nbsp;
										<button @click.prevent="selMeal.name = JSON.parse(JSON.stringify(clipboardName))" class="button is-rounded is-small">{{t.step3PasteNameBtn}}</button>										&nbsp;
										<button @click.prevent="clipboardDesc = selMeal.descText" class="button is-rounded is-small">{{t.step3CopyDescBtn}}</button>&nbsp;
										<button @click.prevent="selMeal.descText = JSON.parse(JSON.stringify(clipboardDesc))" class="button is-rounded is-small">{{t.step3PasteDescBtn}}</button>&nbsp;
										<button @click.prevent="clipboardPrice = selMeal.price" class="button is-rounded is-small">{{t.step3CopyPriceBtn}}</button>&nbsp;
										<button @click.prevent="selMeal.price =  JSON.parse(JSON.stringify(clipboardPrice))" class="button is-rounded is-small">{{t.step3PastePriceBtn}}</button>&nbsp;
										
										<button @click.prevent="showChangeOrderButtons ? showChangeOrderButtons = false : showChangeOrderButtons = true"
												class="button is-rounded is-small">
											<span class="icon"><i class="fas fa-arrows-alt-v"></i></span><span>{{t.changeOrderBtn}}</span>
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
													<span v-for="sm in meals" :value="sm.id" :key="sm.id"
														@click.prevent="selMeal = sm"
														>
														<span v-if="parseInt(sm.groupId) == selMealGroup"
															class="menuRow" 
															:class="selMeal == sm ? 'selected' : ''">
												<!-- edit meal form-->
															<span v-if="editedMeal == sm">
																<!-- edit name -->
																<input class="input" type="text" 
																		v-model="editedMeal.name"	
																		style="width:unset"
																		>																
																<span class="control has-icons-right wide">
																	<!-- edit price -->
																	<input class="input" type="text" v-model="editedMeal.price" style="width:70px;margin-left:6px">
																	<!--<input v-model="newMealPrice" class="input mealPrice" placeholder="0.00" type="text" value="2">-->
																	<span class="priceCurrency priceInputInline">{{t.currency}}</span>
																</span> 
																<!--<span @click.prevent="editedMeal = null, sm = origMeal" class="iconButton cancelEditMeal"></span>&nbsp;-->
																<!-- NEWER <span @click.prevent="addMeal(origMeal, 'cancelEditMeal', sm)" class="iconButton cancelEditMeal"></span>&nbsp; -->

																<!--<span @click.prevent="sm.name = editedMeal.name, editedMeal = null" class="iconButton saveEditMeal"></span>-->
																<!--<span @click.prevent="sm.name = clean(editedMeal.name), sm.price = cleanPrice(editedMeal.price), editedMeal = null" class="iconButton saveEditMeal"></span>-->
																<span @click.prevent="addMeal(editedMeal.name)" class="iconButton saveEditMeal"></span>
																<!-- edit desc -->
																<input class="input" type="text" v-model="editedMeal.descText" placeholder="Meal description" style="width:100%;margin-top:6px">																		
															</span>

										<!-- show meal name as text -->
															<span v-else>
																{{ sm.name }}
																({{ sm.orderId}})
																<button @click.prevent="deleteItem(meals, sm.id)" class="delete deleteGroup"></button>														
																<span  v-show="showEditMealButtons" @click.prevent="editedMeal = sm, origMeal = sm" class="iconButton editMeal"></span>
																<!--<span @click.prevent="cloneMeal(sm, editedMeal), origMeal = sm" class="iconButton editMeal"></span> KESKEN-->
																<span class="price">{{ sm.price }} {{t.currency}}</span>																
																<p class="mealDesc">{{ sm.descText }}</p>
																<span class="menuRowIngredients">
																	<small v-for="i in sm.ingredients" :value="i.id" :key="i.id" class="tag is-primary is-medium">
																		{{ i.name }}
																		<button @click.prevent="ingredient('d', i, sm)" class="delete is-small"></button>
																	</small>
																</span>
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
									<p class="subtitle is-3">4. {{t.step4Title}}</p>
									<small v-html="t.step4Desc"></small>
									<br><br>
									<!-- mealGroups select -->
									<MealGroups @clicked="mealGroupChildSel" @displayTypeChanged="mealGroupDisplayTypeChildSel" :mealGroups="mealGroups" :meals="meals" :selMealGroup="parseInt(selMealGroup)" :numberOfMealsText="t.numberOfMealsText" :displayAs="displayMealGroupsAs" />	
									<br><br><!--
									<div class="is-pulled-right">
										<button @click.prevent="clipboard = selMeal.ingredients" class="button is-rounded is-small">Copy ingredients</button>
										<button @click.prevent="selMeal.ingredients = clipboard" class="button is-rounded is-small">Paste ingredients</button>
									</div>-->
									<div v-if="earlierUsedIngredients.length>0" class="is-pulled-right">										
										<button @click.prevent="clipboardIngredients = selMeal.ingredients" class="button is-rounded is-small">{{t.step4CopyIngredientsBtn}}</button>
										<!-- <button @click.prevent="selMeal.ingredients = clipboardIngredients" class="button is-rounded is-small">{{t.step4PasteIngredientsBtn}}</button> -->										
										<button @click.prevent="selMeal.ingredients = JSON.parse(JSON.stringify(clipboardIngredients))" class="button is-rounded is-small">{{t.step4PasteIngredientsBtn}}</button>
									</div>

									<!--<label>Meals in this group*</label>-->
									<!--<MenuListing :mealGroups="mealGroups" :meals="meals" :selMeal="selMeal" :selMealGroup="parseInt(selMealGroup)" :variations="variations" />-->						
									<!-- <MealGroups @clicked="mealGroupChildSel" :mealGroups="mealGroups" :meals="meals" :selMealGroup="selMealGroup" />	-->

									<!-- ROWS -->
									<div class="field">
										<div class="is-fullwidth">
											<div class="menuRows">
												<span v-for="sm in meals" :value="sm.id" :key="sm.id"
													@click.prevent="selMeal = sm"
													>
													<span v-if="sm.groupId == selMealGroup"
														class="menuRow" 
														:class="selMeal == sm ? 'selected' : ''">
														{{ sm.name }} 
														({{ sm.orderId}}) 
														<span class="price">{{ sm.price }} {{t.currency}}</span>																
														<p class="mealDesc">{{ sm.descText }}</p>
														<span class="menuRowIngredients">
															<small v-for="i in sm.ingredients" :value="i.id" :key="i.id" class="tag is-primary is-medium">
																{{ i.name }}
																<button @click.prevent="ingredient('d', i, sm)" class="delete is-small"></button>
															</small>
														</span>
													</span>
												</span>
											</div><br>										
										</div> <!-- selMealGroup: {{ selMealGroup }} -->
									</div>
									-->
									<br><br>
									
									<!-- panel toggle button -->
									<button @click.prevent="ingredientPanelToggle ? ingredientPanelToggle = false : ingredientPanelToggle = true"
												class="panelToggleButton button is-pulled-right"
												:class="!ingredientPanelToggle ? 'isClosed' : ''">

											<span v-show="!ingredientPanelToggle" class="icon">
												<i class="fas fa-chevron-up"></i>
												<span>{{t.showBtn}} {{t.step4PanelTitle}}</span> <!-- Show ingredient list -->
											</span>

											<span v-show="ingredientPanelToggle" class="icon" style="display:contents">
												<i class="fas fa-chevron-down"></i>
												<span >Hide ingredient list</span>
											</span>
									</button>

									<!-- panel -->
									<div v-show="ingredientPanelToggle" class="panel">
										<label>{{t.step4PanelSubTitle}}</label>

										<div class="panelTools">
											<label class="is-checkbox is-primary is-rounded">
												<input 
												  checked="checked" type="checkbox"
													v-model="addToAllMeals"
  												true-value=true
  												false-value=false>
												<span  class="icon checkmark">
													<i class="fa fa-check"></i>
												</span>
												<span>{{t.step4AddToAllDishes}}</span>
											</label>
										</div>

										<!-- enter new ingredient 
										<label>{{t.step4EnterNewIngredient}}</label>-->
										<label>Enter new ingredient</label>
										<div class="columns" style="border: solid 2px red">
											<div class="column is-6">
												<ImportMultiple @add="enterNewIngredient" :placeholderText="t.enterIngredient" :btnText="t.addBtn" />
											</div>
										</div>

										<!-- ingredient search dropdown 
										<Autocomplete :suggestions="ingredients" @click.prevent="console.Log('Selected')">2</Autocomplete>
										-->
										*-*-*-*-*-*-*-* 
										<!-- [{ id: 1, name: 'Option 1'}, { id: 2, name: 'Option 2'}]" -->
										<!--
										<SearchDropdown
											:options="ingredients"											
											v-on:selected="validateSelection"
											v-on:filter="getDropdownValues"
											:disabled="false"
											name="zipcode"
											:maxItem="10"
											placeholder="Please select an option">
									</SearchDropdown> -->

										<!-- ingredient categories -->
										<label>Ingredient category:</label>
										<div class="field has-addons is-center">
											<span v-for="i in ingredientGroups" :key="i.id" :value="i.id" class="control">
												<button class="button"
													:class="ingredientGroup == i.id ? 'is-primary' : ''"
													@click.prevent="ingredientGroup = i.id"
												>{{ i.name }}</button>
											</span>
										</div>
										<!-- earlier selected ingredients-->
										<div v-show="ingredientGroup == 0" class="tags possibleIngredients">
											<span v-for="i in earlierUsedIngredients" :key="i.id" :value="i.id"													
												class="tag is-primary is-medium"
												@click.prevent="ingredient('a', i)"
												>
												{{ i.name }}
												<i class="fas fa-plus-circle fa-inverse"></i>
											</span>
											<span v-if="earlierUsedIngredients.length == 0">{{t.noIngredientsSelected}}</span>
										</div>
									<!-- list of all ingredients by group -->
										<div v-show="ingredientGroup != 0" class="tags possibleIngredients">
											<span v-for="i in ingredients" :key="i.id" :value="i.id"
												v-show="ingredientGroup == i.groupId"
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
									<p class="subtitle is-3">5. {{t.step5Title}}</p>
									<br><br>

									<!-- mealGroups select -->
									<!--<MealGroups @clicked="mealGroupChildSel" :mealGroups="mealGroups" :meals="meals" :selMealGroup="parseInt(selMealGroup)" :numberOfMealsText="t.numberOfMealsText" />-->
									<MealGroups @clicked="mealGroupChildSel" @displayTypeChanged="mealGroupDisplayTypeChildSel" :mealGroups="mealGroups" :meals="meals" :selMealGroup="parseInt(selMealGroup)" :numberOfMealsText="t.numberOfMealsText" :displayAs="displayMealGroupsAs" />
<!-- xxxxxxxxxxx -->
									<!-- panel toggle button -->
									<button @click.prevent="variationPanelToggle ? variationPanelToggle = false : variationPanelToggle = true"
												class="panelToggleButton button is-pulled-right"
												:class="!variationPanelToggle ? 'isClosed' : ''">

											<span v-show="!variationPanelToggle" class="icon">
												<i class="fas fa-chevron-up"></i>
												<span>{{t.showBtn}} {{t.step5Title}}</span>
											</span>

											<span v-show="variationPanelToggle" class="icon" style="display:contents">
												<i class="fas fa-chevron-down"></i>
												<span >{{t.hideBtn}} {{t.step5Title}}</span>
											</span>
									</button>

									<!-- panel -->
									<div v-show="variationPanelToggle" class="panel">
										<label>{{t.addBtn}}</label>

										<div class="panelTools">											
											<button @click.prevent="clipboardVariations = selMeal.variations" class="button is-rounded is-small">{{t.step5CopyOptionsBtn}}</button>
											<button @click.prevent="selMeal.variations =  JSON.parse(JSON.stringify(clipboardVariations))" class="button is-rounded is-small">{{t.step5PasteOptionsBtn}}</button>
										</div>

										<!-- add variation  -->
										<small>{{t.step5PanelTitle}}</small>
										<div class="field has-addons" style="clear:left;display:inline-flex">
											<p class="control has-icons-right wide">
											<input class="input wide" type="text" 
													:placeholder="t.step5PanelPlaceholder"
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
													<option :value="0">{{t.currencyLong}}</option>
													<option v-for="moneyCounter1 in 11"
													:key="moneyCounter1"
													:value="moneyCounter1-1"
													>+{{ moneyCounter1-1 }}</option>
												</select>
											</div><span class="priceCurrency">{{t.currencyLong}}</span>&nbsp;
											<div class="select">
												<select v-on:change="priceAddCents = $event.target.value" 
													v-model="priceAddCents"
													class="noBorderRadius">
													<option :value="0">{{t.step5PanelCurrencySub}}</option>
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
													<option :value="0">{{t.step5PanelSelect1}}</option>
													<option :value="1">{{t.step5PanelSelect2}}</option>
												</select>
											</div>
											<div class="control">
												<a @click.prevent="addVariation" class="button is-primary"
													:disabled="charsLeft(20, variation)[0]"
												>{{t.addBtn}}</a>
											</div>
										</div><br>
										<!-- variation tags -->
										<div class="tags">
											<span v-for="v in variations" :key="v.id"
												class="tag is-primary is-medium">
												{{ v.name }} +{{ v.priceAdd }}{{t.currency}}
												<button @click.prevent="deleteVariation(v.id)" class="delete is-small"></button>
											</span>
										</div> 										
									</div> <!-- panel -->
									<!--<MenuListing :mealGroups="mealGroups" :meals="meals" :selMeal="selMeal" :selMealGroup="parseInt(selMealGroup)" :variations="variations" />-->
									   <!--<MenuListing :mealGroups="mealGroups" :meals="meals" :selMeal="selMeal" :selMealGroup="selMealGroup" :variations="variations" />-->
									<!-- <MealGroups @clicked="mealGroupChildSel" :mealGroups="mealGroups" :meals="meals" :selMealGroup="selMealGroup" />	-->
									
									<div class="field">
										<!-- ROWS -->
										<div class="is-fullwidth">
											<div class="menuRows">
												<span v-for="sm in meals" :value="sm.id" :key="sm.id"
													@click.prevent="selMeal = sm"
													>
													<span v-if="sm.groupId == selMealGroup"
														class="menuRow" 
														:class="selMeal == sm ? 'selected' : ''">
														{{ sm.name }} 
														({{ sm.orderId}}) 
														<span class="price">{{ sm.price }} {{t.currency}}</span>
														<span class="menuRowIngredients">
															<small v-for="i in sm.ingredients" :value="i.id" :key="i.id">
																{{ i.name }}
															</small>
														</span>
														<br>Variations: 
														<!-- meal variation tags -->
														<div v-if="sm.variations" class="tags">
															<span v-for="vId in sm.variations.split(',')" :value="vId" :key="vId"
																class="tag is-primary is-medium">
																{{ variations.find(v => v.id == vId).name }}
															+{{ variations.find(v => v.id == vId).priceAdd }}{{t.currency}}
																<button @click.prevent="deleteMealVariation(vId, sm)" class="delete is-small"></button>
															</span>
														</div>
													</span>

												</span>
											</div><br>
										</div>
									</div>
								</span>


								<!-- Preview -->
								<span v-if="step==6">
									<p class="subtitle is-3">6. {{t.step6Title}}</p>
									<br><br>
									<div class="field">

										<!-- mealGroups select -->
										<!--<MealGroups @clicked="mealGroupChildSel" :mealGroups="mealGroups" :meals="meals" :selMealGroup="parseInt(selMealGroup)" :menuGroupSelect="t.menuGroupSelect" :numberOfMealsText="t.numberOfMealsText" />-->
										<MealGroups @clicked="mealGroupChildSel" @displayTypeChanged="mealGroupDisplayTypeChildSel" :mealGroups="mealGroups" :meals="meals" :selMealGroup="parseInt(selMealGroup)" :numberOfMealsText="t.numberOfMealsText" :displayAs="displayMealGroupsAs" />
										<br><br>

										<MenuListing :mealGroups="mealGroups" :meals="meals" :selMeal="selMeal" :selMealGroup="parseInt(selMealGroup)" :variations="variations" />
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
										<!-- validation errors -->
										<div v-if="valErrArr.length>0" class="columns is-centered is-fullwidth">
											<div class="column is-8 notification is-danger">
													Errors
													<ul class="">
														<li v-for="(e, index) in valErrArr" :key="index">{{ e }}</li>
													</ul>
											</div>
										</div>
										
										<!--
                    <div v-if="passwordHelper" class="notification is-link">
												<button class="delete" @click.prevent="passwordHelper = false"></button> 
												<ul>Password includes at least:
													<li>One number</li>
													<li>One lowercase letter</li>
													<li>One uppercase letter</li>
													<li>Is at least six characters long</li>
												</ul>
											</div>
											-->

										<!-- previous next save buttons -->
										<div class="columns is-centered is-fullwidth">
											<div v-if="step>1" class="column is-4">
										    <button type="submit" @click.prevent="next('left')"
													class="button is-primary is-fullwidth is-outlined is-pulled-left">
										     <span class="icon is-fullwidth"><i class="fas fa-arrow-circle-left"></i></span>
										      <span>{{t.prevBtn}}</span>
										    </button>
											</div>

										  <div v-if="step<6" class="column is-4">
										    <button type="submit" @click.prevent="next('right')"
													class="button is-primary is-fullwidth is-pulled-right">
										      <span>{{t.nextBtn}}</span>
										      <span class="icon"><i class="fas fa-arrow-circle-right"></i></span>
										    </button>
											</div>

											<div v-if="step>5" class="column is-4">
										    <button type="submit" @click.prevent="saveMenu"
													class="button is-primary is-fullwidth is-pulled-right">
										      <span>{{t.saveBtn}}</span>
										      <span class="icon"><i class="fas fa-check-circle"></i></span>
										    </button>
											</div>
										</div>

										<span style="font-size:13px">
										selFoodTypes: {{ selFoodTypes }}<br><br>
										mealGroups: {{ mealGroups }}<br><br>
										meals: {{ meals }}<br><br>
										variations: {{ variations }}<br><br>
										</span>

										<!-- bottom filler -->
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
import ToolTip from './ToolTip'
import ImportMultiple from './ImportMultiple'
//import MenuEditableListing from './MenuEditableListing'
import MenuListing from './MenuListing'
//import Autocomplete from './Autocomplete'
import { mapGetters, mapActions } from "vuex"
export default {
	name: 'Menu',
	components: {
		MealGroups,
		Charsleft,
		ToolTip,
		ImportMultiple,
		//MenuEditableListing,
		MenuListing
  },
	data () {
		return {
			steps: [],
			step: 1,	
			selFoodType: [], // -1
			selFoodTypes: [], // LOCAL VAR
			mealGroups: [], // LOCAL VAR
			displayMealGroupsAs: 'boxes',
			selMealGroup: -1,
			//newMealGroup: '',
			//importGroups: '',
			meals: [], // LOCAL VAR
			selMeal: -1,
			clipboardName: null,
			clipboardPrice: null,
			clipboardDesc: null,
			clipboardIngredients: null,
			clipboardVariations: null,
			editedMeal: null,
			editedMealGroup: null,
			origMeal: null,
			newMeal: '',
			newMealPrice: '',			
			addToAllMeals: false,
			ingredientIdsPopulatedWithObjects: false,
			//importMeals: '',
			showChangeOrderButtons: false,
			showEditMealGroupButtons: false,
			showEditMealButtons: true,
			ingredientPanelToggle: true,			
			ingredientGroups: [
				{ "id": 0 , "name": "Aiemmin valitut" },
				{ "id": 1 , "name": "Liha, kana, kala, äyriäiset" },
				{ "id": 2 , "name": "Vihannekset" },
				{ "id": 3 , "name": "Hedelmät" },
				{ "id": 4 , "name": "Juustot" },
				{ "id": 5 , "name": "Mausteet" },
				{ "id": 6 , "name": "Muut" }
			], 
			ingredientGroup: 1,
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
			valErrArr: [],
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
			mealGroupDisplayTypeChildSel (val) {
				this.displayMealGroupsAs = val;
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
				this.showChangeOrderButtons = false;
				// check at least one item was added
				switch(this.step) {
					case 1: if(this.selFoodTypes.length>0) { this.steps[0].isCompleted = 1; this.step++; } else { alert('Please add cuisine(s) first'); } break;
					case 2: if(this.mealGroups.length>0) { 
							this.steps[1].isCompleted = 1;
							// set 1st mealGroup selected - not working
							if(this.selMealGroup === -1) { this.selMealGroup = this.mealGroups[0].id; } // set first mealGroup selected if user has not selected
							this.step++;
						}
						break;
					case 3: if(this.meals.length>0) { this.steps[2].isCompleted = 1; this.step++; } else { alert('Please add dishes first'); } break;
					case 4: this.steps[3].isCompleted = 1; this.step++; break; // optional step
					case 5: this.steps[4].isCompleted = 1; this.step++; break;
				}			
			} else {
				// left
				if(this.step>1) { this.step--; }
			}
		},		
		saveMenu() {
			// ----------- validate -----------
			console.log('validating meals:', this.meals);
			// check all menuGroups have meals
			// check all meals have prices
			let groupHasMeals;
			this.valErrArr = [];
			for( let g = 0; g < this.mealGroups.length; g++){ 
					groupHasMeals = false;
					for( let m = 0; m < this.meals.length; m++){
						if (this.meals[m].groupId == this.mealGroups[g].id) { 
							groupHasMeals = true; 
							if (this.meals[m].price == null) { 
								console.log('Meal ' + this.meals[m].name + ' has no price'); 
								this.valErrArr.push('Meal ' + this.meals[m].name + ' has no price'); 
							}
						}
					}
					if(groupHasMeals == false) { console.log('Meal group ' + this.mealGroups[g].name + ' has 0 meals'); this.valErrArr.push('Meal group ' + this.mealGroups[g].name + ' has 0 meals'); }
			}
			
			// notify user if no ingredients are put
			// notify user if no options are put

			// save meals
			// restaurantId,groupId,name,descriptionText,ingredientIds,price

			// add restaurant id to meal groups
			for( let m = 0; m < this.mealGroups.length; m++) {
					//if(this.meals[m].restaurantId != null) {
						console.log('adding res Id');						
						this.mealGroups[m].restaurantId = parseInt(this.restaurant.id);
					//}
			}
			
			// add restaurant id to meals
			for( let m = 0; m < this.meals.length; m++) {
					//if(this.meals[m].restaurantId != null) {
						console.log('adding res Id');						
						this.meals[m].restaurantId = parseInt(this.restaurant.id);
					//}
			}
			console.log('mealGroups:', this.mealGroups);
			this.saveMealGroups(this.mealGroups);
			
			console.log('saveMeals:', this.meals);
			this.saveMeals(this.meals); 
			// this.saveIngredientsToMeals(
			// after save:
			this.isSaved = true;
		},
		addIngredientToAllMealsInGroup(item) {
			
		},
		ingredient(action, ingredient, selectedMeal=null) {
			//if(addToAllMeals == true && action == 'a') { this.addIngredientToAllMealsInGroup(i); }
			console.log('ingredient action:', action);
			console.log('ingredient ingredient:', ingredient.name);
			console.log('ingredient this.selMeal:', this.selMeal);
			console.log('ingredient selectedMeal:', selectedMeal);
			ingredient.name = clean(ingredient.name.trim());		

			//this.selMeal = selectedMeal; // new
			let mealIndex = this.meals.findIndex(el => el.id === this.selMeal.id);
			let ingrIndex = -1;
			let currIngrArr = this.selMeal.ingredients;
			if(typeof this.selMeal.ingredients !== 'undefined' && this.selMeal.ingredients.length > 0) {
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
			} else {
				console.log('No earlier selected ingredients');
			}

			// add ingredient to meal
			if(action == 'a') {
				console.log('Adding ingredient to meal');
					console.log('addToAllMeals value:', this.addToAllMeals);
				if(this.addToAllMeals == false) {
					console.log('To only one meal');
					// add to one meal
					if(ingrIndex == -1) {
						console.log('ingredient does not exist from before');
						console.log('ingredient PUSH ingredient.id:', ingredient.id);
						console.log('ingredient PUSH mealIndex:', mealIndex);		
						this.meals[mealIndex].ingredients.push({ "id": ingredient.id, "name": ingredient.name });
					} else {
						console.log('ingredient exists already');
					}
				} else {
					// add to all meals in selected group
					console.log('Adding to all meals in selected group');
					let selGroupId = ''+this.selMealGroup;
					console.log('selGroupId:', this.selMealGroup);
					let ingredients = '';
					for( let i = 0; i < this.meals.length; i++) { 
							console.log('VERRATAAN:'+this.meals[i].groupId+' - '+selGroupId);
						if (this.meals[i].groupId == selGroupId) { 	
							/*
							let exists = this.meals[i].ingredients.find(elem => elem.id == ingredient.id);
							if(!exists) {
								this.meals[i].ingredients.push({ "id": ingredient.id, "name": '*'+ingredient.name });
							}*/
							// check if exists
							ingrIndex = this.meals[i].ingredients.findIndex(el => el.id === ingredient.id);
							if(ingrIndex == -1) {
								console.log('2 ingredient does not exist from before');
								this.meals[i].ingredients.push({ "id": ingredient.id, "name": '**'+ingredient.name });
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
		addMeal(item, action=null, origMeal=null, largestOrderId=null) {
			if(action == 'cancelEditMeal') { 
				console.log('action: item:', item);	
				console.log('action: origMeal:', origMeal);	
				item = origMeal; return; 
			}
			// item = clean(item.trim()); // done earlier already
			//if(item == '') { return; }
			let price = cleanPrice(this.newMealPrice.trim());
			if(price.length > 6) { price = 0; }

			let largestId = 0; //, largestOrderId;
			// check if exists already
			const index = this.meals.findIndex(el => el.name === item);			
			if(index == -1) {
				if(this.meals.length > 0) {
					// get largest id
					let temp = this.meals;
					largestId = temp.sort((a, b) => b.id - a.id)[0];
					//console.log('1152 largestId a:', largestId.id);	
					largestId = parseInt(largestId.id)+1;
					//console.log('1152 largestId b:', largestId);
					console.log('1152 this.meals:', this.meals);
					// get largest orderId	
				//	largestOrderId = this.meals.reduce(function(prev, current) { return (prev.orderId > current.orderId) ? prev.orderId : current.orderId }) //returns object										
				//	if(typeof largestOrderId === 'object' && largestOrderId !== null) { console.log('is object!'); largestOrderId = largestOrderId.orderId; }
					console.log('1156 largestOrderId a:', largestOrderId);
					largestOrderId = parseInt(largestOrderId)+1; // .orderId
					console.log('1156 largestOrderId b:', largestOrderId);
				} else {
					alert('No earlier meals');
					largestId = 0;
					largestOrderId = 0;
				}
				this.meals.push({ "id": largestId.toString(), 
													"groupId": ''+this.selMealGroup, 
													"name": item, 
													"price": price, 
													"variations": "",  
													"ingredients": [], 
													"orderId": largestOrderId.toString() });
				// sort meals by orderId
				this.meals.sort((a,b) => (a.orderId > b.orderId) ? 1 : ((b.orderId > a.orderId) ? -1 : 0));			
			} else {
				// update meal
				this.meals[index].name = item;
			console.log('this.editedMeal.price before:', this.editedMeal.price);	
			console.log('this.editedMeal.price after:', cleanPrice(this.editedMeal.price.trim()));			
				this.meals[index].price = cleanPrice(this.editedMeal.price.trim());
				this.editedMeal = null;
			}
			// if(this.selMeal == -1) { this.selMeal = this.meals[0]; } // set first selected
		},
		newUpdateMealFromEditableListing(arr) {
				// new update meal                    @newUpdateMealFromEditableListing="updateMealFromComponent"   code: this.$emit('clicked', event)   this.$emit('newUpdateMealFromEditableListing', updateMealFromComponent)
				let id = arr['id'];
				let name = arr['name'];
				let price = arr['price'];

				let index = this.meals.findIndex(el => el.id === id);
				if(index == -1) {
					this.meals[index].name = name;
					//if(price != null) { this.meals[index].price = cleanPrice(price.trim()); }
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
			alert(' z z z  1241 addMultiple:'+ data +'  target:' +target);
			let largestOrderId = -1;
			data = data.replace(/(?:\r\n|\r|\n)/g, '#').trim();
			data = data.split("#");
			if(target == 'meals' && this.meals.length > 0) { 
				let mealsInSelMealGroup = this.meals;   // tempIngr.filter(el => el.groupId == this.selMealGroup);
				mealsInSelMealGroup = mealsInSelMealGroup.filter(el => el.groupId == this.selMealGroup);
				console.log('mealsInSelMealGroup: ', mealsInSelMealGroup);
				if(mealsInSelMealGroup.length > 0) {
					largestOrderId = mealsInSelMealGroup.reduce(function(prev, current) { return (prev.orderId > current.orderId) ? prev.orderId : current.orderId }); //returns object
				}	
			}
			for( let i = 0; i < data.length; i++){
				data[i] = clean(data[i]);
				if(data[i] != '') { 
					switch(target) {
						case 'meals': this.addMeal(data[i], null, null, parseInt(largestOrderId)+i); break;
						case 'mealGroups': this.addMealGroup(data[i]); break;
						case 'enterIngredient': 
							// check ingredient does not exist
							// save in DB
							alert('Saing new ingredient: ', data[i]);
							break;
					}
				}				
			}
			//this.importMeals = '';
		}, 
		deleteItem(data, removeId) {		
			var r = confirm("Are you sure?\nThis action can not be reversed.");
			if (r !== true) { Return; }
	
			for( let i = 0; i < data.length; i++){ 
				if (data[i].id === removeId) {
					data.splice(i, 1); 
					i--;
				}
			}
			return data;
		},
		move(data, direction, item) {
			data = changeOrder(data, direction, item); // IT THIS DONE TWICE????
			// sort data by orderId
				data.sort((a,b) => (a.orderId > b.orderId) ? 1 : ((b.orderId > a.orderId) ? -1 : 0));
		},
		/*
		XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
		XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
		XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
		XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX is addMealGroup old code and can be deleted?  XX
		XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
		XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX		
		*/
		addMealGroup(item) {
			// add a single mealGroup
			console.log('addMealGroup - item:', item);
			item = clean(item.trim());
			if(item == '') { return; }
			let largestId = 0;
			let largestOrderId = 0;
			console.log('ABC this.mealGroups.length:', this.mealGroups.length);
			
			// check if exists already
			let index = this.mealGroups.findIndex(el => el.name === item);
			console.log('addMealGroup - index:', index);

			if(this.mealGroups.length>0 && index == -1) {
				// OLD
				//largestId = this.mealGroups.reduce(function(prev, current) { return (prev.id > current.id) ? prev.id : current.id }); //returns object								
				//largestId = parseInt(largestId)+1;
				// NEW
				// get largest id
					let temp = this.mealGroups;
					largestId = temp.sort((a, b) => b.id - a.id)[0];
					largestId = parseInt(largestId.id)+1;
				// OLD
				//largestOrderId = this.mealGroups.reduce(function(prev, current) { return (prev.orderId > current.orderId) ? prev.orderId : current.orderId }) //returns object
				// NEW
				largestOrderId = temp.sort((a, b) => b.orderId - a.orderId)[0].orderId;

				console.log('addMealGroup - largestOrderId B:', largestOrderId); // ok
				largestOrderId = parseInt(largestOrderId)+1;	
				this.mealGroups.push({ "id": largestId.toString(), "name": item, "restaurantId": this.restaurant.id, "langId": 567, "variations": "",  "orderId": largestOrderId.toString() });				
				console.log('addMealGroup - mealGroups.push:', { "id": largestId.toString(), "name": item, "restaurantId": this.restaurant.id, "langId": 567, "variations": "",  "orderId": largestOrderId.toString() });
			
				// sort mealGroups by orderId
				this.mealGroups.sort((a,b) => (a.orderId > b.orderId) ? 1 : ((b.orderId > a.orderId) ? -1 : 0));
				//this.selMealGroup = 1; // set first mealGroup selected 
			} else {
				//console.log('ABC mealGroups has 0 items');
				//-------------------------			
				// update mealGroup
				this.mealGroups[index].name = item;
			//console.log('this.editedMeal.price before:', this.editedMeal.price);	
			//console.log('this.editedMeal.price after:', cleanPrice(this.editedMeal.price.trim()));							
				this.editedMealGroup = null;
				// ------------------------
			}
			this.mealGroups.sort((a,b) => (a.orderId > b.orderId) ? 1 : ((b.orderId > a.orderId) ? -1 : 0));
		},
		enterNewIngredient(data) {
			this.addMultiple(data, 'enterIngredient');
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
		/*
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
		}, */
		addFoodType(id) {
			if(id == '') return;
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
		//getRestaurantSelFoodTypeNames() { 
		getObjectsById(ids, objArr) {
			let i, idsArr = ids.split(',');
			let index, resArr = [];
			for(i = 0; i < idsArr.length; i++) {
				let obj = objArr.find(obj => obj.id == idsArr[i]);
				if(obj) { resArr.push({ "id": obj.id, "name": obj.name }); }
			}
			return resArr;
		}, 
		populateStepNames() {
			let i, title;
			this.steps = [];
			for(i = 1; i < 7; i++) {
				switch(i) {
					case 1: title = this.t.step1Title; break;
					case 2: title = this.t.step2Title; break;
					case 3: title = this.t.step3Title; break;
					case 4: title = this.t.step4Title; break;
					case 5: title = this.t.step5Title; break;
					case 6: title = this.t.step6Title; break;
				}
				this.steps.push({ "id":  i, "isCompleted": 0, "title": title });
			}
			console.log('steps: ', this.steps);
		},
		...mapActions(["getCities", "changeLang", "getRestaurant", "getFoodTypes", "doSetSelFoodTypes", "getMealGroups", "getMeals", "setMeals", "getIngredients", "saveMealGroups", "saveMeals", "saveIngredientsToMeals"])
	},
	created(){		
		this.changeLang('en');
		this.getCities('fi');		
	},
	watch: {		
		lang: function() {
			console.log('watch lang');
			this.getFoodTypes('fi');
			this.getIngredients('fi');
		},
		t: function() {
			console.log('watch t');
			this.populateStepNames();
		},
		//meals() {
		//	if(this.meals.length == 1) { this.selMeal = this.meals[0]; } // set first meal active
		//},
		step() {
			if(this.step > 3) { this.steps[this.step-1].isCompleted = 1; } // set optional parts completed after visited first time			
			},
		foodTypes: function() {
			console.log('watch foodtypes called');
			this.getRestaurant(10);
		},
		restaurant: function() {
			//this.doSetSelFoodTypes(this.getObjectsById(this.restaurant.foodTypeIds, this.foodTypes)); // store
			
			//let temp = this.getObjectsById(this.restaurant.foodTypeIds, this.foodTypes);
//----
			console.log('1388 this.restaurant:', this.restaurant.id); // foodTypeIds: "71,68,73"
			//console.log('1360 this.foodTypes:', this.foodTypes);
			// get
			this.selFoodTypes = this.getObjectsById(this.restaurant.foodTypeIds, this.foodTypes); // local this.selFoodTypes - NEW2
			this.getMealGroups(this.restaurant.id);
			this.getMeals(parseInt(this.restaurant.id));
		},
		_mealGroups: function() {
			if(this.mealGroups.length == 0) {
			////this.mealGroups = this._mealGroups; // WITH BINDING
			////this.mealGroups = Object.assign({}, this._mealGroups); // NO BINDING
			//const returnedTarget = Object.assign(this.mealGroups, this._mealGroups); // NO BINDING
		
			//Object.assign(this.mealGroups, this._mealGroups); // NO BINDING
			this.mealGroups = JSON.parse(JSON.stringify(this._mealGroups));
			this._mealGroups = [];
			}
		},
		_meals: function() {
			console.log('===== meals loaded:', this._meals);
			//this.meals = this._meals;// WITH BINDING
			//const returnedTarget = Object.assign(this.meals, this._meals); // NO BINDING
			this.meals = JSON.parse(JSON.stringify(this._meals));
			this._meals = [];
			this.getIngredients('fi');
			//console.log('1402 this.meals.length: ', this.meals.length);
			if(this.meals.length>0) {
				// set all steps accessible
					let i=0
					for(i; i<6; i++) { this.steps[i].isCompleted = 1; }
					if(this.selMealGroup === -1) { this.selMealGroup = this.mealGroups[0].id; } // set first mealGroup selected
			}
		},
		ingredients: function() {
				console.log('1400', this.ingredientIdsPopulatedWithObjects);
			if(!this.ingredientIdsPopulatedWithObjects) {
				this.ingredientIdsPopulatedWithObjects = true;		
				// populate meal ingredients with ingredient objects			
				let m = 0;
				for(m; m<this.meals.length; m++) {
					let i = 0;
					let ingrName = null;
					let ingrObjects = [];
				/*
					let ingrIdsArr = this.meals[m].ingredients.split(",");
					console.log('1414 ingrIdsArr BEFORE:', ingrIdsArr);
					for(i; i<ingrIdsArr.length; i++) {
						console.log('1414 COMPARING:' + ingrIdsArr[i] + ' with elem id');
						ingrName = this.ingredients.find(elem => elem.id == ingrIdsArr[i]).name;
						//ingrName = this.ingredients.find(elem => elem.id == 89).name;
						console.log('1414 adding ingrName:', ingrName);
						// this.meals[mealIndex].ingredients.push({ "id": ingredient.id, "name": ingredient.name });
						ingrObjects.push({ "id": ingrIdsArr[i], "name": ingrName }); //ingredient('a', ingredientObj)
						//console.log('1414 ingrObjects:', ingrObjects);											
					}
				*/
					ingrObjects.push({ "id": '999', "name": 'XXXXXXXXXXX' });
					this.meals[m].ingredients = 'ZZZZZZZZZZZZZZZZZZZZZ'; //ingrObjects;

					console.log('1414 ingrIdsArr AFTER:', ingrObjects);
				}
			}
		}
		}, // "selFoodTypes", 
	/* keybord ctrl+v */
	mounted() {		
    this._keyListener = function(e) {
        if (e.key === "v" && (e.ctrlKey || e.metaKey)) {
					console.log('v pressed');
            e.preventDefault(); // present "Save Page" from getting trigger
        }
		};
		document.addEventListener('keydown', this._keyListener.bind(this));
  },
  beforeDestroy() {
      document.removeEventListener('keydown', this._keyListener);
	},
	computed: mapGetters(["cities", "lang", "t", "restaurant", "foodTypes", "_mealGroups", "_meals", "ingredients"])
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
.deliveryPriceText, .pickupPriceText {
	text-transform: uppercase;
  font-size: 10px;
  color: #9b9b9b;
  position: absolute;
  top: -12px;
  margin-left: 4px;
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
button {
	overflow: hidden;
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
