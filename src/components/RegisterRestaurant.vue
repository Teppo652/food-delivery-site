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
PostalCodes  VARCHAR(50) 
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


				<h1>{{ t.reg_pageTitle }}</h1>
				<div class="columns is-centered">
					<div class="column is-6-desktop">
						<form>
<!-- step -->
							<p class="subtitle is-3">1. {{ t.reg_stepTitle_contactInfo }}</p>							
							<!-- restaurant name -->
							<div class="field">
								<div class="control">
									<label>{{ t.reg_restaurantName }}</label>
									<input class="input" type="text"
									v-model="name"
									:class="charsLeft(50, name)[0] ? 'exceedTextLength' : ''"
									>
									<span class="textLimiter is-pulled-right is-size-7"  :class="charsLeft(50, name)[0] ? 'has-text-danger' : ''">{{ charsLeft(50, name)[1] }}</span>									
								</div>
							</div>
							<!-- address -->
							<div class="field">
								<div class="control">
									<label>{{ t.reg_streetAdress }} <small>{{ t.reg_forCustomers }}</small></label>
									<input class="input" type="text"									
									:placeholder=t.reg_streetAdressExample
									v-model="address"
									:class="charsLeft(50, address)[0] ? 'exceedTextLength' : ''"
									>
									<span class="textLimiter is-pulled-right is-size-7"  :class="charsLeft(50, address)[0] ? 'has-text-danger' : ''">{{ charsLeft(50, address)[1] }}</span>									
								</div>
							</div>

							<!-- phone -->
							<div class="field">
								<div class="control">
									<label>{{ t.reg_phone }} <small>{{ t.reg_emailDescription }}</small></label>
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
									<label>{{ t.reg_email }} <small>{{ t.reg_emailDescription }}</small></label>
									<input class="input" type="text"
									v-model="email">
								</div>
							</div><br>

							<!-- password -->
							<div class="field">
								<div class="control">
									<label>{{ t.reg_password }}</label>
									<input class="input" type="password"
									v-model="password">
								</div>
							</div><br>

							<!-- password again-->
							<div class="field">
								<div class="control">
									<label>{{ t.reg_passwordAgain }}</label>
									<input class="input" type="password"
									v-model="passwordAgain">
								</div>
							</div><br>

<!-- step offering: delivery pickup booking --> 
							<p class="subtitle is-3">2. {{ t.reg_step_offering_title }}</p><br>
							<label>{{ t.reg_step_offering_description }}</label>
							<div class="field offerChoises"> 
								<label>{{ t.reg_offerChoises }}</label>
								<!-- delivery -->
								<div class="control">
							  	<input id="offerDelivery" v-model="offerDelivery" type="checkbox">
									<label for="offerDelivery">{{ t.reg_offerDelivery }}</label><br>
									<p>{{ t.reg_offerDeliveryDesc }}</p>
								</div>
								<!-- pickup -->
								<div class="control">
							  	<input id="offerPickup" v-model="offerPickup" type="checkbox">
									<label for="offerPickup">{{ t.reg_offerPickup }}</label><br>
									<p>{{ t.reg_offerPickupDesc }}</p>
								</div>
								<!-- booking -->
								<div class="control">
							  	<input id="offerBooking" v-model="offerBooking" type="checkbox">
									<label for="offerBooking">{{ t.reg_offerBooking }}</label>
									<p>{{ t.reg_offerBookingDesc }}</p><br>
								</div>
							</div><br><br>


<!-- step delivery % payment -->							
							<p class="subtitle is-3">3. {{ t.reg_step_deliveryAndPayment_title }}</p>
							<p>{{ t.reg_step_deliveryAndPayment_title1 }} 
							<span style="text-decoration: underline; font-weight:bold">{{ t.reg_step_deliveryAndPayment_title2 }}</span></p><br>
							* * *<br>
							<!-- postalCodes -->
							<label>{{ t.reg_postalCodes }}</label>
							 <div class="field">
                  <div class="control">
                    <textarea class="input" style="min-height:80px" type="text" v-model="postalCodes" :placeholder="t.reg_postalCodesPlaceholder"></textarea>
                  </div>
                </div>

							<!-- minPurchase -->
							<label>{{ t.reg_minPurchase }}</label>
							<div class="is-halfWidth">
								<div class="field level is-fullWidth" style="clear:left">
									<div class="select level-left">
									<select v-on:change="minPurchaseEuros = $event.target.value" 
										v-model="minPurchaseEuros">
										<option :value="-1">{{ t.currencyLong }}</option>
										<option v-for="moneyCounter1 in 51"
										:key="moneyCounter1"
										:value="moneyCounter1-1"
										>{{ moneyCounter1-1 }}</option>
									</select>
									</div>&nbsp;
									<div class="select level-right">
									<select v-on:change="minPurchaseCents = $event.target.value" 
										v-model="minPurchaseCents">
										<option :value="-1">{{ t.subCurrencyLong }}</option>
										<option v-for="moneyCounter2 in 20" 
										:key="moneyCounter2*5-5"
										:value="moneyCounter2*5-5"
										> {{ moneyCounter2*5-5 }}
										</option>
									</select>
									</div> <div class="currency">{{ t.currency }}</div>
								</div>
							</div>

							<!-- deliveryPrice -->
							<div class="is-halfWidth">
								<label>{{ t.reg_deliveryFee }}</label>
								<div class="field level is-fullWidth" style="clear:left">
									<div class="select level-left">
									<select v-on:change="deliveryPriceEuros = $event.target.value" 
										v-model="deliveryPriceEuros">
										<option :value="-1">{{ t.currencyLong }}</option>
										<option v-for="moneyCounter1 in 51"
										:key="moneyCounter1"
										:value="moneyCounter1-1"
										>{{ moneyCounter1-1 }}</option>
									</select>
									</div>&nbsp;
									<div class="select level-right">
									<select v-on:change="deliveryPriceCents = $event.target.value" 
										v-model="deliveryPriceCents">
										<option :value="-1">{{ t.subCurrencyLong }}</option>
										<option v-for="moneyCounter2 in 20" 
										:key="moneyCounter2*5-5"
										:value="moneyCounter2*5-5"
										> {{ moneyCounter2*5-5 }}
										</option>
									</select>
									</div> <div class="currency">{{ t.currency }}</div>
								</div>
							</div>

							<!-- deliveryTime -->
							<div class="is-halfWidth">
								<label>{{ t.reg_deliveryTime }}</label>
								<div class="field level is-fullWidth" style="clear:left">
									<div class="select level-left">
									<select v-on:change="deliveryTimeHour = $event.target.value" 
										v-model="deliveryTimeHour">
										<option :value="-1">{{ t.hours }}</option>
										<option v-for="hourCounter in 2" 
										:key="hourCounter"
										:value="hourCounter-1"
										>{{ hourCounter-1 }}</option>
									</select>
									</div>&nbsp;
									<div class="select level-right">
									<select v-on:change="deliveryTimeMins = $event.target.value" 
										v-model="deliveryTimeMins">
										<option :value="-1">{{ t.mins }}</option>
										<option v-for="minsCounter in 12" 
										:key="minsCounter*5-5"
										:value="minsCounter*5-5"
										> {{ minsCounter*5-5 }}
										</option>
									</select>
									</div>
								</div>
							</div><br>

<!-- step payment -->
							<!-- delivery -->
							<!-- paymentTimeForDelivery -->
							<div class="field">
								<!-- paymentBeforehand -->
								<label>{{ t.reg_paymentTime_ifDelivered }}</label>
								<div class="control">
							  		<input id="a" v-model="paymenttime_delivery_beforehand" type="checkbox">
									<label for="a">{{ t.reg_paymentTime_beforehand }}</label>
								</div>
								<!-- paymentOnpickup -->
								<div class="control">
									<input id="b" v-model="paymenttime_delivery_atdoor" type="checkbox">
									<label for="b">{{ t.reg_paymentTime_whenDelivered }}</label>
								</div>
							</div><br>

							<!-- paymentTypeIdsForDelivery -->
							<div class="field">
								<label>{{ t.reg_deliveryPaymentTypesTitle }}</label> {{ selectedPaymentTypes_delivery }}
								<div v-for="(p, idx) in paymentTypes_delivery" :key="p.id" class="control">
							  		<input :id="p.id+idx" type="checkbox"  
									  @click="paymentTypeClicked('delivery', p.id)">
									<label :for="p.id+idx">{{ p.name }}  {{ p.id+idx }}</label>
								</div>								
							</div><br><span style="clear:left;float:left;"></span>
							
							<!-- mobilepay payment info --> 
							<span v-if="selectedPaymentTypes_delivery.find(j => j == 1)">
								<label style="float:left">{{ t.reg_paymentType_mobilePay }} {{ t.reg_paymentType_info }}</label>
								<div class="field level is-fullWidth" style="clear:left">
									<div class="level-left">
										<input class="input" type="text" 						
										:placeholder=t.reg_paymentType_mobilePayId
										v-model="mobilepayId"
										:class="charsLeft(50, mobilepayId)[0] ? 'exceedTextLength' : ''"
										>
										<span class="textLimiter is-pulled-right is-size-7"  :class="charsLeft(50, mobilepayId)[0] ? 'has-text-danger' : ''">{{ charsLeft(50, mobilepayId)[1] }}</span>									
									</div>
									<div class="level-right">
										<input class="input" type="text"	
										:placeholder=t.reg_paymentType_mobilePayReceiverName
										v-model="mobilepayName"
										:class="charsLeft(50, mobilepayName)[0] ? 'exceedTextLength' : ''"
										>
										<span class="textLimiter is-pulled-right is-size-7"  :class="charsLeft(50, mobilepayName)[0] ? 'has-text-danger' : ''">{{ charsLeft(50, mobilepayName)[1] }}</span>									
									</div>
								</div>
							</span>

							<!-- swish payment info -->
							<span v-if="selectedPaymentTypes_delivery.find(j => j == 2)">
								<label style="float:left">{{ t.reg_paymentType_swish }} {{ t.reg_paymentType_info }}</label>
								<div class="field level is-fullWidth" style="clear:left">
									<div class="level-left">
										<input class="input" type="text" 						
										:placeholder=t.reg_paymentType_swishId
										v-model="swishId"
										:class="charsLeft(50, swishId)[0] ? 'exceedTextLength' : ''"
										>
										<span class="textLimiter is-pulled-right is-size-7"  :class="charsLeft(50, swishId)[0] ? 'has-text-danger' : ''">{{ charsLeft(50, swishId)[1] }}</span>									
									</div>
									<div class="level-right">
										<input class="input" type="text"	
										:placeholder=t.reg_paymentType_swishReceiverName
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
								<label>{{ t.reg_pickupPaymentTypesTitle }}</label>
								<div class="control">
							  		<input id="c" v-model="payment_pickup_beforehand" type="checkbox">
									<label for="c">{{ t.reg_paymentTime_beforehand }}</label>
								</div>
								<div class="control">
									<input id="d" v-model="payment_pickup_atrestaurant" type="checkbox">
									<label for="d">{{ t.reg_paymentTime_atPickup }}</label>
								</div>
							</div><br>
							
							<!-- paymentTypeIdsForPickup -->
							<div class="field">
								<label>{{t.reg_pickupPaymentTypesTitle }}</label> {{ selectedPaymentTypes_atrestaurant }}
								<div v-for="(r, idx) in paymentTypes_atrestaurant" :key="r.id" class="control">
							  		<input :id="'r'+r.id+idx" type="checkbox"  
									  @click="paymentTypeClicked('restaurant', r.id)">
									<label :for="'r'+r.id+idx">{{ r.name }} {{ r.id+idx }}</label>
								</div>
							</div><br>

<!-- step booking a table -->
							<p class="subtitle is-3">4. {{ t.reg_step_booking_title }}</p>
							<label>{{ t.reg_step_booking_description }}</label><br><br>

							<!-- booking timeslot length -->
							<div class="is-halfWidth">
								<label>{{ t.reg_booking_timeslotLength }} </label>
								<div class="field level is-fullWidth" style="clear:left">
									<div class="select level-left">
									<select v-on:change="timeslotLengthHour = $event.target.value" 
										v-model="timeslotLengthHour">
										<option :value="-1">{{ t.hours }}</option>
										<option v-for="hourCounter in 6" 
										:key="hourCounter"
										:value="hourCounter-1"
										>{{ hourCounter-1 }} {{ t.hour }}</option>
									</select>
									</div>&nbsp;
									<div class="select level-right">
									<select v-on:change="timeslotLengthMins = $event.target.value" 
										v-model="timeslotLengthMins">
										<option :value="-1">{{ t.mins }}</option>
										<option v-for="minsCounter in 4" 
										:key="minsCounter*15-15"
										:value="minsCounter*15-15"
										> {{ minsCounter*15-15 }} {{ t.min }}</option>
									</select>
									</div>
								</div> <!--<label style="margin: -12px 0 20px 0;"> {{ t.reg_deliveryOrdersClose2 }}</label> -->
							</div><br><span style="clear:left;float:left;"></span>

							<div class="is-fullWidth">
								<!-- max tables during timeslot -->
								<label>{{ t.reg_booking_maxTablesInTimeslot }}</label>								
								<div class="field level is-one-quarter" style="clear:left"> 
									<div class="select is-one-quarter">
									<select v-on:change="maxTablesInTimeslot = $event.target.value" 
										v-model="maxTablesInTimeslot">
										<option :value="-1">--</option>
										<option v-for="tableCounter in 101" 
										:key="tableCounter"
										:value="tableCounter-1"
										>{{ tableCounter-1 }}</option>
									</select>
									</div>
								</div>
								<br>					
							
								<!-- max persons during timeslot -->
								<label>{{ t.reg_booking_maxPersonsInTimeslot }}</label>								
								<div class="field level is-one-quarter" style="clear:left"> 
									<div class="select is-one-quarter">
									<select v-on:change="maxPersonsInTimeslot = $event.target.value" 
										v-model="maxPersonsInTimeslot">
										<option :value="-1">--</option>
										<option v-for="personCounter in 501"
										:key="personCounter"
										:value="personCounter-1"
										>{{ personCounter-1 }}</option>
									</select>
									</div>
								</div>
							</div><br>

<!-- step business hours -->
							<p class="subtitle is-3">5. {{ t.reg_step_openingHours_title }}</p>
							<!-- business hours -->
							
							<div class="is-halfWidth">
								<label>{{ t.reg_step_openingHours_title }}</label>
								<div v-for="(d, index) in openingHours" 
										:key="index"
									class="field level is-fullWidth" style="clear:left">
									<div class="select level-left">
									<div class="weekday">{{ weekdayNames[index] }}</div>
										<select v-on:change="d.open = $event.target.value" 
											v-model="d.open">
											<option :value="-1">{{ t.reg_open }}</option>
											<option v-for="hourCounter in 24" 
											:key="hourCounter"
											:value="hourCounter"
											>{{ hourCounter }}:00</option>
										</select>
									</div>&nbsp;
									<div class="select level-right">
										<select v-on:change="d.close = $event.target.value" 
											v-model="d.close">
											<option :value="-1">{{ t.reg_close }}</option>
											<option v-for="hourCounter in 24" 
											:key="hourCounter"
											:value="hourCounter"
											>{{ hourCounter }}:00</option>
										</select>
									</div>									
									<div v-if="index==0"  class="is-halfWidth field">
										<button @click.prevent="copyTimes()" class="button">{{ t.reg_copy }}</button>
									</div>
								</div>
							</div><br>

							<!-- deliveryOrdersDeadline -->
							<div class="is-halfWidth">
								<label>{{ t.reg_deliveryOrdersClose1 }} </label>
								<div class="field level is-fullWidth" style="clear:left">
									<div class="select level-left">
									<select v-on:change="deliveryOrdersDeadlineHour = $event.target.value" 
										v-model="deliveryOrdersDeadlineHour">
										<option :value="-1">{{ t.hours }}</option>
										<option v-for="hourCounter in 2" 
										:key="hourCounter"
										:value="hourCounter-1"
										>{{ hourCounter-1 }} {{ t.hour }}</option>
									</select>
									</div>&nbsp;
									<div class="select level-right">
									<select v-on:change="deliveryOrdersDeadlineMins = $event.target.value" 
										v-model="deliveryOrdersDeadlineMins">
										<option :value="-1">{{ t.mins }}</option>
										<option v-for="minsCounter in 12" 
										:key="minsCounter*5-5"
										:value="minsCounter*5-5"
										> {{ minsCounter*5-5 }} {{ t.min }}</option>
									</select>
									</div>
								</div> <label style="margin: -12px 0 20px 0;"> {{ t.reg_deliveryOrdersClose2 }}</label>
							</div><br><span style="clear:left;float:left;"></span>

							<!-- image -->
							<div class="field">
								<div class="control">
									<label>{{ t.reg_listingImage }} <small>{{ t.reg_listingImageDescription }}</small></label>
									<input class="input" type="text" placeholder="https://pixabay.com/fi/photos/pizza-kiviuuni-pizza-stone-uuni-1344720/"
									v-model="listingImg">
								</div>
							</div>

							<!-- save -->
                  <div class="field">
                    <div class="control">
                      <button @click.prevent="save()" class="button is-primary is-fullwidth" type="submit">{{ t.reg_save }}</button>
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
import SelectCity from './SelectCity'
export default {
	name: 'RegisterRestaurant',
	components: {
		SelectCity
  },
	data () {
		return {			
			adminUserId: null,
			country: null,
			area1: null,
			area2: null,
			area3: null,
			area4: null,
			area5: null,
			coordsXY: null,
			address: null,
			phone: null,
			email: null,
			password: null,
			passwordAgain: null,
			listingImg: null,
			outsideImg: null,
			imgTagIds: null,
			deliveryTime: null,
			name: null,
			avgStars: null,
			totVotes: null,
			priceLevel: null,
			foodTypeIds: null,
			minPurchase: null,
			deliveryPrice: null,
			bonus: null,
			openingHoursString: null,
			mapCoords: null,
			paymentTime: null,
			paymentTypeIds: null,
			image: null,
			xxxxxxxxxxxxxxxxxxxxxxxxxxx: null,
			selCity: -1,
			name: 'Ibolina',//'',
			address: 'Essinge Brogata 2',//'',
			phone: '1234567890',//'',
			email: 'ibolina@test.se',//'',
			password: '123qweQWE',//'',
			passwordAgain: '123qweQWE',//'',
			offerDelivery: true,//false, 
			offerPickup: true,//false,
			offerBooking: false,
			minPurchase: 10,//null,
			minPurchaseEuros: 12,//-1,
			minPurchaseCents: 50,//-1,
			deliveryPriceEuros: 3,//-1,
			deliveryPriceCents: 25,//-1,
			deliveryOrdersDeadline: null,
			deliveryOrdersDeadlineHour: 1,//-1,
			deliveryOrdersDeadlineMins: 15,//-1,
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
			postalCodes: '',
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
			],
			timeslotLengthHour: -1,
			timeslotLengthMins: -1,
			maxTablesInTimeslot: null,
			tableCounter: 1,
			maxPersonsInTimeslot: null,
			personCounter: 1,
		 	newRestaurant: []
		}
	},
	methods: {
		save: function() {
		// validate
		// console.log('xxxxxx');

		// save
/*
selCity: -1,
			name: 'Ibolina',//'',
			address: 'Essinge Brogata 2',//'',
			phone: '1234567890',//'',
			email: 'ibolina@test.se',//'',
			offerDelivery: true,//false, 
			offerPickup: true,//false,
			offerBooking: false,
			minPurchase: 10,//null,
			minPurchaseEuros: 12,//-1,
			minPurchaseCents: 50,//-1,
			deliveryPriceEuros: 3,//-1,
			deliveryPriceCents: 25,//-1,
			deliveryOrdersDeadline: null,
			deliveryOrdersDeadlineHour: 1,//-1,
			deliveryOrdersDeadlineMins: 15,//-1,
			paymenttime_delivery_beforehand: false,
			paymenttime_delivery_atdoor: false,
			payment_delivery_beforehand: false,
			payment_delivery_atdoor: false,
			paymentTypes_delivery: [				{ "id": 0, "name": "Cash" },			],
			swishId: '',
			swishName: '',
			mobilepayId: '',
			mobilepayName: '',
			selectedPaymentTypes_delivery: [],
			payment_pickup_beforehand: false,
			payment_pickup_atrestaurant: false,
			paymentTypes_atrestaurant: [				{ "id": 0, "name": "Cash" },			],
      weekdayNames: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
			selectedPaymentTypes_atrestaurant: [],
			moneyCounter1: 0,
			moneyCounter2: 0,
			deliveryTimeHour: -1,
			deliveryTimeMins: -1,
			hourCounter: 0,
			minsCounter: 0,
			openingHours: [				{ "day": 0, "open": -1, "close": -1 },			],
			timeslotLengthHour: -1,
			timeslotLengthMins: -1,
			maxTablesInTimeslot: null,
			tableCounter: 1,
			maxPersonsInTimeslot: null,
			personCounter: 1,
			*/		
			console.log('populating resturant obj');	

	
	this.adminUserId = 1111111;
	this.country = 'fi';
	this.area1 = 11;
	this.area2 = 22;
	this.area3 = 33;
	this.area4 = 44;
	this.area5 = 55;
	this.coordsXY = 987654321;
	this.address = this.address; // clean
	this.phone = this.phone; // clean
	this.email = this.email; // clean
	this.listingImg = 'testImg1.jpg';
	this.outsideImg = 'testOutsideImg1.jpg';
	this.imgTagIds = '1,2,3,4,5';
	this.deliveryTime = 155; // 1h 55min
	this.name = this.name; // clean
	this.avgStars = 50; // 5.0
	this.totVotes = 125; // TEMP
	this.priceLevel = 2; // 1=€,2=€€,3=€€€
	this.foodTypeIds = '5,6,7';
	this.minPurchase = 1300; // 13€
	this.deliveryPrice = 7; //this.deliveryPrice;
	this.bonus = 999; //0=no bonus from this restaurant
	this.openingHoursString = 'openingHoursString here';
	this.postalCodes = 987654321;
	this.paymentTime = this.paymentTime;
	this.paymentTypeIds = '24,65,99,111111';

// INSERT INTO restaurants (adminUserId,country,area1,area2,area3,area4,area5,coordsXY,address,phone,email,listingImg,outsideImg,imgTagIds,deliveryTime,name,avgStars,totVotes,priceLevel,foodTypeIds,minPurchase,deliveryPrice,bonus,openingHoursString,mapCoords,paymentTime,paymentTypeIds) VALUES (1111111,fi,11,22,33,44,55,'987654321','Essinge Brogata 2','1234567890','ibolina@test.se','testImg1.jpg','testOutsideImg1.jpg','1,2,3,4,5',155,'Ibolina',25,0,2,'5,6,7',1300,,0,'openingHoursString here','987654321',,'24,65,99,111111')


this.newRestaurant = {
	"adminUserId": this.adminUserId,
	"country": this.country,
	"area1": this.area1,
	"area2": this.area2,
	"area3": this.area3,
	"area4": this.area4,
	"area5": this.area5,
	"coordsXY" : this.coordsXY,
	"address": this.address,
	"phone": this.phone,
	"email": this.email,
	"listingImg": this.listingImg,
	"outsideImg": this.outsideImg,
	"imgTagIds": this.imgTagIds,
	"deliveryTime": this.deliveryTime,
	"name": this.name,
	"avgStars": 25,
	"totVotes": 0,
	"priceLevel": this.priceLevel,
	"foodTypeIds": this.foodTypeIds,
	"minPurchase": this.minPurchase,
	"deliveryPrice": this.deliveryPrice,
	"bonus": 999999, /*this.bonus, */
	"openingHoursString": this.openingHoursString,
	"postalCodes": '00100,00200',
	"paymentTime": 999999, /*this.paymentTime, */
	"paymentTypeIds": this.paymentTypeIds
}
console.log('BEFORE SAVE:', this.newRestaurant);

this.saveRestaurant(this.newRestaurant);

		},
		...mapActions(["getCities", "changeLang", "getRestaurant", "initRestaurant", "saveRestaurant"]),
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
	created(){		
		this.changeLang('en');
		this.getCities('fi');
		this.initRestaurant();		
	},
	watch: {		
		lang: function() {
			console.log('watch lang');
		},
		t: function() {
			console.log('watch t.weekdays:', this.t.weekdays);
			//this.weekdayNames = this.t.weekdays.split(',');
		}
	},
	computed: mapGetters(["cities", "lang", "t", "restaurant"])
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



label, p {
	clear: left;
	float: left;
	text-align: left;
}
.offerChoises .control label {
	font-weight: bold !important;
	text-transform:uppercase
}
.offerChoises .control p {
	clear: left;
	float: left;
	margin: -22px 0 12px 35px;
}
</style>
