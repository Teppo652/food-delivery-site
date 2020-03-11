<template>
	<div>
		<div class="container is-fluid">
			<section class="section">
			<div class="container has-text-centered">
<!--
restaurants:
country TINYINT
area 1 INT
area 2
area 3
area 4
area 5
coordsXY
address   VARCHAR(50)   Hollantilaisentie 32, 00330 Helsinki
phone VARCHAR(25) 
listingImg VARCHAR(8) 
outsideImg VARCHAR(8) 
imgTagIds VARCHAR(25)
deliveryTime
name VARCHAR(50) 
avgStarsTINYINT
totVotes INT
priceLevel TINYINT
foodTypeIds VARCHAR(50) 3,2,  Vegetarian, falafel, pizza, kebab
minPurchase INT
deliveryPrice INT

bonus TINYINT
openingHoursString  VARCHAR(255) 
  Esim: Mon - Thu 10:00 - 21:30, 10:00 - 22:00 Fri 10:00 - 22:30, 10:00 - 23:00 Sat 11:00 - 22:30, 11:00 - 23:00 Sun 11:00 - 21:30, 11:00 - 22:00 (construced when restaurant settings saved)
mapCoords  VARCHAR(50) 
paymentTime TINYINT   Etukäteen,Noutaessa
paymentTypeIds VARCHAR(255) Mobile pay,Swish,SMS

pizza_businessHours
resaurantId
weekdayIdOrDate
openHour
closeHour
--------------------


listingImg VARCHAR(8) 
outsideImg VARCHAR(8) 
imgTagIds VARCHAR(25)



foodTypeIds VARCHAR(50) 3,2,  Vegetarian, falafel, pizza, kebab
-->


				<h1>Register pizzeria</h1>
				<div class="columns is-centered">
					<div class="column is-5 is-4-desktop">
						<form>
							<p class="subtitle is-3">1. General info</p>  
							<!-- restaurant name -->
							<div class="field">
								<div class="control">
									<label>Pizzeria name</label>
									<input class="input" type="text"									
									placeholder="Example: Main street 22 laundry room"
									v-model="name"
									:class="charsLeft(50, name)[0] ? 'exceedTextLength' : ''"
									>
									<span class="textLimiter is-pulled-right is-size-7"  :class="charsLeft(50, name)[0] ? 'has-text-danger' : ''">{{ charsLeft(50, name)[1] }}</span>									
								</div>
							</div>
							<!-- address -->
							<div class="field">
								<div class="control">
									<label>Street adress <small>(for customers)</small></label>
									<input class="input" type="text"									
									placeholder="Example: Hollantilaisentie 12, 00330 Helsinki"
									v-model="address"
									:class="charsLeft(50, address)[0] ? 'exceedTextLength' : ''"
									>
									<span class="textLimiter is-pulled-right is-size-7"  :class="charsLeft(50, address)[0] ? 'has-text-danger' : ''">{{ charsLeft(50, address)[1] }}</span>									
								</div>
							</div>

							<!-- phone -->
							<div class="field">
								<div class="control">
									<label>Phone <small>(for customers)</small></label>
									<input class="input" type="text"
									v-model="phone"
									:class="charsLeft(50, phone)[0] ? 'exceedTextLength' : ''"
									>
									<span class="textLimiter is-pulled-right is-size-7"  :class="charsLeft(50, phone)[0] ? 'has-text-danger' : ''">{{ charsLeft(50, phone)[1] }}</span>									
								</div>
							</div>

							<!-- email -->
							<div class="field">
								<div class="control">
									<label>Email <small>(for contacting management, not shown to customers)</small></label>
									<input class="input" type="text"
									v-model="email"
									:class="charsLeft(50, email)[0] ? 'exceedTextLength' : ''"
									>
									<span class="textLimiter is-pulled-right is-size-7"  :class="charsLeft(50, email)[0] ? 'has-text-danger' : ''">{{ charsLeft(50, email)[1] }}</span>									
								</div>
							</div>

							
							<p class="subtitle is-3">2. Delivery & payment</p>

							<!-- minPurchase -->
							<label>Minimum purchase if delivered</label>
							<div class="is-halfWidth">
								<div class="field level is-fullWidth" style="clear:left">
									<div class="select level-left">
									<select v-on:change="minPurchaseEuros = $event.target.value" 
										v-model="minPurchaseEuros">
										<option :value="-1">Euros</option>
										<option v-for="moneyCounter1 in 51"
										:key="moneyCounter1"
										:value="moneyCounter1-1"
										>{{ moneyCounter1-1 }}</option>
									</select>
									</div>&nbsp;
									<div class="select level-right">
									<select v-on:change="minPurchaseCents = $event.target.value" 
										v-model="minPurchaseCents">
										<option :value="-1">Cents</option>
										<option v-for="moneyCounter2 in 20" 
										:key="moneyCounter2*5-5"
										:value="moneyCounter2*5-5"
										> {{ moneyCounter2*5-5 }}
										</option>
									</select>
									</div> <div class="currency">€</div>
								</div>
							</div>

							<!-- deliveryPrice -->
							<div class="is-halfWidth">
								<label>Delivery fee</label>
								<div class="field level is-fullWidth" style="clear:left">
									<div class="select level-left">
									<select v-on:change="deliveryPriceEuros = $event.target.value" 
										v-model="deliveryPriceEuros">
										<option :value="-1">Euros</option>
										<option v-for="moneyCounter1 in 51"
										:key="moneyCounter1"
										:value="moneyCounter1-1"
										>{{ moneyCounter1-1 }}</option>
									</select>
									</div>&nbsp;
									<div class="select level-right">
									<select v-on:change="deliveryPriceCents = $event.target.value" 
										v-model="deliveryPriceCents">
										<option :value="-1">Cents</option>
										<option v-for="moneyCounter2 in 20" 
										:key="moneyCounter2*5-5"
										:value="moneyCounter2*5-5"
										> {{ moneyCounter2*5-5 }}
										</option>
									</select>
									</div> <div class="currency">€</div>
								</div>
							</div>

							<!-- deliveryTime -->
							<div class="is-halfWidth">
								<label>Delivery time</label>
								<div class="field level is-fullWidth" style="clear:left">
									<div class="select level-left">
									<select v-on:change="deliveryTimeHour = $event.target.value" 
										v-model="deliveryTimeHour">
										<option :value="-1">Hours</option>
										<option v-for="hourCounter in 2" 
										:key="hourCounter"
										:value="hourCounter-1"
										>{{ hourCounter-1 }}</option>
									</select>
									</div>&nbsp;
									<div class="select level-right">
									<select v-on:change="deliveryTimeMins = $event.target.value" 
										v-model="deliveryTimeMins">
										<option :value="-1">Mins</option>
										<option v-for="minsCounter in 12" 
										:key="minsCounter*5-5"
										:value="minsCounter*5-5"
										> {{ minsCounter*5-5 }}
										</option>
									</select>
									</div>
								</div>
							</div><br>



							<!-- delivery -->
							<!--
payment_delivery_beforehand bool
payment_delivery_atdoor bool
paymentTypes_delivery []

payment_pickup_beforehand
payment_pickup_atrestaurant
paymentTypes_atrestaurant []

							-->
							<!-- paymentTimeForDelivery -->
							<div class="field">
								<!-- paymentBeforehand -->
								<label>Payment time if delivered</label>
								<div class="control">
							  		<input id="a" v-model="paymenttime_delivery_beforehand" type="checkbox">
									<label for="a">Beforehand</label>
								</div>
								<!-- paymentOnpickup -->
								<div class="control">
									<input id="b" v-model="paymenttime_delivery_atdoor" type="checkbox">
									<label for="b">When delivered</label>
								</div>
							</div><br>

							<!-- paymentTypeIdsForDelivery -->
							<div class="field">
								<label>Payment types if delivered</label> {{ selectedPaymentTypes_delivery }}
								<div v-for="(p, idx) in paymentTypes_delivery" :key="p.id" class="control">
							  		<input :id="p.id+idx" type="checkbox"  
									  @click="paymentTypeClicked('delivery', p.id)">
									<label :for="p.id+idx">{{ p.name }}  {{ p.id+idx }}</label>
								</div>								
							</div><br><span style="clear:left;float:left;"></span>
							
							<!-- mobilepay payment info --> 
							<span v-if="selectedPaymentTypes_delivery.find(j => j == 1)">
								<label style="float:left">MobilePay payment info</label>
								<div class="field level is-fullWidth" style="clear:left">
									<div class="level-left">
										<input class="input" type="text" 						
										placeholder="MobilePay ID"
										v-model="mobilepayId"
										:class="charsLeft(50, mobilepayId)[0] ? 'exceedTextLength' : ''"
										>
										<span class="textLimiter is-pulled-right is-size-7"  :class="charsLeft(50, mobilepayId)[0] ? 'has-text-danger' : ''">{{ charsLeft(50, mobilepayId)[1] }}</span>									
									</div>
									<div class="level-right">
										<input class="input" type="text"	
										placeholder="Receiver name"
										v-model="mobilepayName"
										:class="charsLeft(50, mobilepayName)[0] ? 'exceedTextLength' : ''"
										>
										<span class="textLimiter is-pulled-right is-size-7"  :class="charsLeft(50, mobilepayName)[0] ? 'has-text-danger' : ''">{{ charsLeft(50, mobilepayName)[1] }}</span>									
									</div>
								</div>
							</span>

							<!-- swish payment info -->
							<span v-if="selectedPaymentTypes_delivery.find(j => j == 2)">
								<label style="float:left">Swish payment info</label>
								<div class="field level is-fullWidth" style="clear:left">
									<div class="level-left">
										<input class="input" type="text" 						
										placeholder="Swish ID"
										v-model="swishId"
										:class="charsLeft(50, swishId)[0] ? 'exceedTextLength' : ''"
										>
										<span class="textLimiter is-pulled-right is-size-7"  :class="charsLeft(50, swishId)[0] ? 'has-text-danger' : ''">{{ charsLeft(50, swishId)[1] }}</span>									
									</div>
									<div class="level-right">
										<input class="input" type="text"	
										placeholder="Receiver name"
										v-model="swishName"
										:class="charsLeft(50, swishName)[0] ? 'exceedTextLength' : ''"
										>
										<span class="textLimiter is-pulled-right is-size-7"  :class="charsLeft(50, swishName)[0] ? 'has-text-danger' : ''">{{ charsLeft(50, swishName)[1] }}</span>									
									</div>
								</div>
							</span>



							<!-- at restaurant -->
							<!-- at restaurant payment time --> 
							<div class="field">
								<label>Payment if picked up</label>
								<div class="control">
							  		<input id="c" v-model="payment_pickup_beforehand" type="checkbox">
									<label for="c">Beforehand</label>
								</div>
								<div class="control">
									<input id="d" v-model="payment_pickup_atrestaurant" type="checkbox">
									<label for="d">When picked up</label>
								</div>
							</div><br>
							
							<!-- paymentTypeIdsForPickup -->
							<div class="field">
								<label>Payment types at restaurant (and pickup)</label> {{ selectedPaymentTypes_atrestaurant }}
								<div v-for="(r, idx) in paymentTypes_atrestaurant" :key="r.id" class="control">
							  		<input :id="'r'+r.id+idx" type="checkbox"  
									  @click="paymentTypeClicked('restaurant', r.id)">
									<label :for="'r'+r.id+idx">{{ r.name }} {{ r.id+idx }}</label>
								</div>
							</div><br>


							<p class="subtitle is-3">3. Business hours</p>
							<!-- business hours -->
							<div class="is-halfWidth">
								<label>Business hours</label>
								<div v-for="(d, index) in openingHours" 
										:key="index"
									class="field level is-fullWidth" style="clear:left">
									<div class="select level-left">
									<div class="weekday">{{ weekdayNames[index] }}</div>
										<select v-on:change="d.open = $event.target.value" 
											v-model="d.open">
											<option :value="-1">Open</option>
											<option v-for="hourCounter in 24" 
											:key="hourCounter"
											:value="hourCounter"
											>{{ hourCounter }}:00</option>
										</select>
									</div>&nbsp;
									<div class="select level-right">
										<select v-on:change="d.close = $event.target.value" 
											v-model="d.close">
											<option :value="-1">Close</option>
											<option v-for="hourCounter in 24" 
											:key="hourCounter"
											:value="hourCounter"
											>{{ hourCounter }}:00</option>
										</select>
									</div>									
									<div v-if="index==0"  class="is-halfWidth field">
										<button @click.prevent="copyTimes()" class="button">Copy</button>
									</div>
								</div>
							</div><br>

														<!-- deliveryOrdersDeadline -->
							<div class="is-halfWidth">
								<label>Delivery orders close </label>
								<div class="field level is-fullWidth" style="clear:left">
									<div class="select level-left">
									<select v-on:change="deliveryOrdersDeadlineHour = $event.target.value" 
										v-model="deliveryOrdersDeadlineHour">
										<option :value="-1">Hours</option>
										<option v-for="hourCounter in 2" 
										:key="hourCounter"
										:value="hourCounter-1"
										>{{ hourCounter-1 }} hours</option>
									</select>
									</div>&nbsp;
									<div class="select level-right">
									<select v-on:change="deliveryOrdersDeadlineMins = $event.target.value" 
										v-model="deliveryOrdersDeadlineMins">
										<option :value="-1">Mins</option>
										<option v-for="minsCounter in 12" 
										:key="minsCounter*5-5"
										:value="minsCounter*5-5"
										> {{ minsCounter*5-5 }} min</option>
									</select>
									</div>
								</div> <label style="margin: -12px 0 20px 0;"> before closing time</label>
							</div><br><span style="clear:left;float:left;"></span>

							<!-- go to booking page btn -->
                  <div class="field">
                    <div class="control">
                      <button @click.prevent="saveRestaurant()" class="button is-primary is-fullwidth" type="submit">Save</button>
                    </div>
                  </div>



						</form>
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
	name: 'RegisterRestaurant',
	data () {
		return {
			name: '',
			address: '',
			phone: '',
			email: '',
			minPurchase: null,
			minPurchaseEuros: -1,
			minPurchaseCents: -1,
			deliveryPriceEuros: -1,
			deliveryPriceCents: -1,
			deliveryOrdersDeadline: null,
			deliveryOrdersDeadlineHour: -1,
			deliveryOrdersDeadlineMins: -1,
			paymenttime_delivery_beforehand: false,
			paymenttime_delivery_atdoor: false,
			payment_delivery_beforehand: false,
			payment_delivery_atdoor: false,
			paymentTypes_delivery: [
				{ "id": 0, "name": "Cash" },
				{ "id": 1, "name": "MobilePay" },
				{ "id": 2, "name": "Swish" },
				{ "id": 3, "name": "Bank card" },
				{ "id": 4, "name": "Credit card" }
			],
			swishId: '',
			swishName: '',
			mobilepayId: '',
			mobilepayName: '',
			selectedPaymentTypes_delivery: [],
			payment_pickup_beforehand: false,
			payment_pickup_atrestaurant: false,
			paymentTypes_atrestaurant: [
				{ "id": 0, "name": "Cash" },
				{ "id": 1, "name": "Mobile pay" },
				{ "id": 2, "name": "Swish" },
				{ "id": 3, "name": "Bank card" },
				{ "id": 4, "name": "Credit card" }
			],
      		weekdayNames: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
			selectedPaymentTypes_atrestaurant: [],
			moneyCounter1: 0,
			moneyCounter2: 0,
			deliveryTimeHour: -1,
			deliveryTimeMins: -1,
			hourCounter: 0,
			minsCounter: 0,
			openingHours: [
				{ "day": 0, "open": -1, "close": -1 },
				{ "day": 1, "open": -1, "close": -1 },
				{ "day": 2, "open": -1, "close": -1 },
				{ "day": 3, "open": -1, "close": -1 },
				{ "day": 4, "open": -1, "close": -1 },
				{ "day": 5, "open": -1, "close": -1 },
				{ "day": 6, "open": -1, "close": -1 }
			]
		}
	},
	methods: {
		saveRestaurant: function() {
		// console.log('xxxxxx');
		},
		...mapActions(["saveXxxxxx"]),
		// calculates number of characters left, returns array: [is limit exceeded, characters left / max]
		charsLeft(maxLen, str) {
			//return 1; //temp
			return [ str.length > maxLen ? true : false,
			str.length > maxLen/2 ? maxLen - str.length + "/" + maxLen : ''];
		},
		forwardToNextPage() {
			// this.$router.replace({name: 'xxxxxxx'});
		},
		addOpeninghour() {
			/*
			 if(this.newMachines.map(function(x) {return x.name; }).indexOf(machinesArr[i]) != -1) {
                        this.errorMsg.push('Machine name \"' + machinesArr[i] + '\" exists already, name must be unique.');
                      } else {
                        this.newMachines.push({ 'name': machinesArr[i], 'orderId': counter });
                        counter++;
					  }
			*/
		},
		paymentTypeClicked(orderType, id) {
			if(orderType=='delivery') {
				// delivery
				// check if exists already
				let index = this.selectedPaymentTypes_delivery.findIndex(el => el === id);
				if(index != -1) {
					this.selectedPaymentTypes_delivery.splice(index, 1); // remove
				} else {
					this.selectedPaymentTypes_delivery.push(id); // add
				}
			} else {
				// at restaurant
				// check if exists already
				let index = this.selectedPaymentTypes_atrestaurant.findIndex(el => el === id);
				if(index != -1) {
					this.selectedPaymentTypes_atrestaurant.splice(index, 1); // remove
				} else {
					this.selectedPaymentTypes_atrestaurant.push(id); // add
				}
			}
		},
		// copy monday's business hours to whole week
		copyTimes() {
			let i;
			for(i=1; i < 7; i++) { 
				this.openingHours[i].open = this.openingHours[0].open;
				this.openingHours[i].close = this.openingHours[0].close;
			}
		}
	},
	watch: {
		xxxxx: function() {

		}
	},
	computed: mapGetters(["xxxx"])
}
</script>


<style scoped>
.level-left, .level-left select, .level-right, .level-right select {
    flex-grow: 1;
}
.is-halfWidth {
	width: 50%;
}
.currency {
	margin-left: 6px;
    font-size: 1.4rem;
    color: #d8d8d8;
}


/*Checkboxes styles*/
input[type="checkbox"] { display: none; }

input[type="checkbox"] + label {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 20px;
  /*font: 14px/20px 'Open Sans', Arial, sans-serif; 
  color: #ddd; */
  cursor: pointer;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
}

input[type="checkbox"] + label:last-child { margin-bottom: 0; }

input[type="checkbox"] + label:before {
  content: '';
  display: block;
  width: 20px;
  height: 20px;
  border: 1px solid #3273dc;
  position: absolute;
  left: 0;
  top: 0;
  opacity: .6;
  -webkit-transition: all .12s, border-color .08s;
  transition: all .12s, border-color .08s;
}

input[type="checkbox"]:checked + label:before {
  width: 10px;
  top: -5px;
  left: 5px;
  border-radius: 0;
  opacity: 1;
  border-top-color: transparent;
  border-left-color: transparent;
  -webkit-transform: rotate(45deg);
  transform: rotate(45deg);
}
.weekday {
	width: 40px;
    text-align: left;
}



label {
	float: left;
}
</style>
