<template>
	<div>
		
    <div class="container is-fluid">
			<section class="section">
			  <div class="container has-text-centered">

          <div class="columns is-centered">
            <div class="column is-6-desktop">
              <form>
<!--
   "order_title": "Delivery Details", "order_estimatedDeliveryTime": "Delivery time", "order_date": "", "order_time": "", "order_seliveryAddressSubTitle": "Delivery address", "order_address1 ": "Street", "order_houseNumber": "Nr.", "order_address2": "Entrance", "order_address3": "Unit number", "order_company": "Company", "order_postalCode": "Postal code", "order_city": "City", "order_extraDeliveryInfo": "Note to courier", "order_preOrderTitle": "PRE-ORDER FOR weekday here", "order_preOrderText": "You are placing a pre-order for date time here", "order_paymentSubTitle": "Payment", "order_paymentByCashWhenDelivered": "Cash when delivered", "order_paymentByCardWhenDelivered": "Card when delivered", "order_discountCodeSubTitle": "Do you have a voucher?", "order_byOrderingYouAgreeToTerms": "By making this purchase you agree to our Terms and conditions and Privacy.", "order_termsText": "I agree and I demand that you execute the ordered service before the end of the revocation period. I am aware that after complete fulfillment of the service I lose my right of recission.", "order_placeOrderBtn": "PLACE ORDER", "now": "Now", "save": "Save" }

  Toimitustiedot (otsikko)

Toimitusaika: Heti
Date drop(today+3 days)   time drop (12-13)

Toimitusosoite (title)

Katu (80%) Talo (20%)
Rappu (koko)
Asunto (koko)
Yrityksen nimi (koko)
Postinumero (puolet)
Kaupunki (puolet)
Lisätietoja lähetille, esim. ovikoodi (textarea)
-->
                <p class="subtitle is-3">{{ t.order_title }}</p>
                <p class="is-pulled-left">{{ t.order_estimatedDeliveryTime }}: {{ t.now }}</p>
               
                <!-- Date drop(today+3 days)   time drop (12-13) -->
                <!-- deliveryOrdersDeadline -->
                <div class="is-fullWidth">
                  <div class="field level is-fullWidth" style="clear:left">                   
                    <div class="select level-left">
                      <select v-on:change="deliveryDate = $event.target.value" 
                      v-model="deliveryDate">
                      <option :value="-1">Day</option>
                    </select>
                    </div>&nbsp;
                    <div class="select level-right">
                      <select v-on:change="deliveryTime = $event.target.value" 
                      v-model="deliveryTime">
                      <option :value="-1">Time</option>
                    </select>
                    </div>
                  </div>
                </div><br>


                <!-- Toimitusosoite (title) -->
                <div class="control">
                  <p>{{ t.order_seliveryAddressSubTitle }}</p>
                </div>

                <!-- Katu (80%) Talo (20%) -->
                <div class="field">
                  <div class="is-halfWidth level is-fullWidth" style="clear:left">                   
                    <div class="level-left" style="width:80%">
                      <input class="input" type="text" v-model="address1" :placeholder="t.order_address1">
                    </div>&nbsp;
                    <div class="level-right" style="width:19%">
                      <input class="input" type="text" v-model="houseNumber" :placeholder="t.order_houseNumber">
                    </div>
                  </div>
                </div>

                <!-- Rappu (koko) -->
                <div class="field">
                  <div class="control">
                    <input class="input" type="text" v-model="address2" :placeholder="t.order_address2">
                  </div>
                </div>

                <!-- Asunto (koko) -->
                <div class="field">
                  <div class="control">
                    <input class="input" type="text" v-model="address3" :placeholder="t.order_address3">
                  </div>
                </div>

                <!-- Yrityksen nimi (koko) -->
                <div class="field">
                  <div class="control">
                    <input class="input" type="text" v-model="company" :placeholder="t.order_company">
                  </div>
                </div>

                <!-- Postinumero (puolet) -->
                <!-- Kaupunki (puolet) -->               
                <div class="is-halfWidth">
                  <div class="field level is-fullWidth" style="clear:left">                   
                    <div class="level-left">
                      <input class="input" type="text" v-model="postalCode" :placeholder="t.order_postalCode">
                    </div>&nbsp;
                    <div class="level-right">
                      <input class="input" type="text" v-model="city" :placeholder="t.order_city">
                    </div>
                  </div>
                </div><br>

                <!-- Lisätietoja lähetille, esim. ovikoodi (textarea) -->
                <div class="field">
                  <div class="control">
                    <textarea class="input" style="min-height:80px" type="text" v-model="extraDeliveryInfo" :placeholder="t.order_extraDeliveryInfo"></textarea>
                  </div>
                </div>

                <!-- save -->
                <div class="field">
                  <div class="control">
                    <button @click.prevent="save()" class="button is-primary is-fullwidth" type="submit">{{ t.order_placeOrderBtn }}</button>
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
	name: 'DeliveryDetails',
	data () {
		return {

		}
	},
	methods: {
		save: function() {
		  console.log('save');
		},
    ...mapActions([ "getTranslations", "changeLang", "getOrder", "updateOrder", "decreaseOrderAmount", "increaseOrderAmount", "saveOrderDetails"]),     
	},
	created(){		
    //this.changeLang('en');	
    this.getTranslations('fi');
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
	computed: mapGetters(["t", "order", "orderDetails"])
}
</script>

<style scoped>
</style>
