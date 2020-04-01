<template>
  <div>

    <section class="section">
    <div class="container">
        <!--           "id": "1", "listingImg": "listi1", "imgTagIds": "imgTagIds1", "deliveryTime": "10", "name": "Kotipizza", "avgStars": "5", "totVotes": "10", "priceLevel": "1", "foodTypeIds": "foodTypeIds1", "minPurchase": "10", "deliveryPrice": "3", "bonus": "1"
60 MIN
img
Armis Pizzeria  * 4.3/5 (587)
€€€ kebab, burgers, falafel, pizza
€12.00 minimum l  3.00 delivery fee
5% bonus -->
        restaurant: {{ restaurant }}<br>
        menu: {{ menu }}<br><br>
        order: {{ order }}<br><br>        
        order.items: {{ order.items }}<br><br><br><br>
 
restaurant:<br><!--
{{ restaurant.name }}<br> 
{{ restaurant.address }}, 4530 London<br>
Map: {{ restaurant.coordsXY }}<br>
<br><br>
reviews: {{ restaurant.totVotes }}<br>
average: {{ restaurant.avgStars }}<br>


<br>
priceLevel: {{ restaurant.priceLevel }}<br>
foodTypeIds: {{ restaurant.foodTypeIds }}<br>
minPurchase: {{ restaurant.minPurchase }}<br>
-->
<br><br><br><br>
        resId: {{ resId }}<br>
        Router test: <br>*
        



        <br><br><br><br>
        Meals:<br>
        <div v-for="(m, index) in menu" :key="index" >
          <div @click.prevent="addMeal(m)">{{ m.name }} (ID:{{m.id}}) ${{ m.price }} <span>Add</span></div>
        </div>
        <br><br><br>
        <span v-if="order.items">
        Your order:<br>
        Order Summary:
        {{ order.items.length }} items<br>
        <div v-for="i in  order.items" :key="i.id" >
          <br>
          <span @click.prevent="decreaseOrderAmount(i)">-</span>&nbsp;
          {{i.amount}}&nbsp;
          <span @click.prevent="increaseOrderAmount(i)">+</span>&nbsp;&nbsp;
          {{i.name}} (ID:{{i.mealId}}) ${{i.price}}
        </div>
        <br>Subtotal ${{order.subTotalPrice}}
        <br>Delivery fee ${{order.deliveryPrice}}
        <br>TOTAL ${{order.totalPrice}}
        </span>
        
        <!-- continue -->
        <div class="column is-4">
					  <button type="submit" @click.prevent="placeOrder"
              :disabled="order.totalPrice==0"
						  class="button is-primary is-fullwidth">
					    <span>Order</span>
					    <span class="icon"><i class="fas fa-check-circle"></i></span>
					  </button>
				</div>

        <!--
          10<br>
          SELECT id,restaurantId,groupId,name,descText,ingredients,price,variationIds,orderId FROM meals WHERE restaurantId = 10
          [{"id":"129","restaurantId":"10","groupId":"52","name":"C","descText":"","ingredients":"","price":"12","variationIds":null,"orderId":"0"},{"id":"127","restaurantId":"10","groupId":"52","name":"A","descText":"","ingredients":"","price":"12","variationIds":null,"orderId":"0"},{"id":"128","restaurantId":"10","groupId":"52","name":"B","descText":"","ingredients":"","price":"12","variationIds":null,"orderId":"0"}]
          -->

    </div>
    </section>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex"
export default {
  name: 'Restaurant',
  data () {
    return {
			resId:this.$route.params.Pid,   
      //restaurant: [],
    }  
  },
  methods: {
    ...mapActions(["getRestaurant", "getMenu", "initOrder", "getOrder", "updateOrder", "decreaseOrderAmount", "increaseOrderAmount", "syncUser"]), 
    placeOrder() {
      alert('ordering');
      //console.log('Restaurant.vue R96 user:', this.user.email);
       this.$router.replace({name: 'Login'});
      
    },
    addMeal(selMeal) {
     /* let newItem = {
        "mealId": selMeal.id,
        "amount": 1, 
        "name": selMeal.name,
        "price": selMeal.price,
        "variationId": null
      }; */
      this.updateOrder({
        /*"orderItemId": null, */
        "mealId": selMeal.id,
        "amount": 1, 
        "name": selMeal.name,
        "price": selMeal.price,
        "variationId": null
      });
    },
    XXXXXXXXXXXXchangeAmount(obj, change) {
      if(change === 'd') {
        this.increaseOrderAmount(obj);
      } else {
        this.decreaseOrderAmount(obj);
      }
    },
    XXXXXXXXXshowPriceLevel: function(num) { 
      let i = 0;
      let res = '';
      for(i; i<num; i++) {
        res+= '€';
      }
      return res;
    return " test test";
    }     
  }, // methods
  filters: {      
    
  },
  created() {
     this.getRestaurant(10);
     this.initOrder();
     //this.getOrder();
  },
	watch: {		
		restaurant: function() {
			console.log('watch restaurant id:', this.restaurant.id);
			this.getMenu(this.restaurant.id);
    }
  },
	computed: mapGetters(["restaurant", "menu", "order", "user"])
}
</script>

<style scoped>

</style>
