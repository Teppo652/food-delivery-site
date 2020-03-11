<template>
  <div>

    <section class="section">
    <div class="container">
        <!--
          "id": "1", "listingImg": "listi1", "imgTagIds": "imgTagIds1", "deliveryTime": "10", "name": "Kotipizza", "avgStars": "5", "totVotes": "10", "priceLevel": "1", "foodTypeIds": "foodTypeIds1", "minPurchase": "10", "deliveryPrice": "3", "bonus": "1"
        
60 MIN
img
Armis Pizzeria  * 4.3/5 (587)
€€€ kebab, burgers, falafel, pizza
€12.00 minimum l  3.00 delivery fee
5% bonus
        
        -->
        <ul class="cards">
          
            <li v-for="(r, index) in restaurants"  :key="index" class="cards__item">
              <div class="card">                  
                    <div class="card-image">
                        <div class="image is-16by9">
                        <!--<span class="deliveryTime">{{ r.deliveryTime }}<span class="mins">MIN</span></span>-->
                        <span class="zoom">                        
                          <img src="https://prod-wolt-venue-images-cdn.wolt.com/s/jZ5N1obl19oBk3aEYOYsr1TdeP5jIY-gQ0WjacEa_34/5dd7d3f415fdc0911cae29f2/455b3380dd1cdedcd4adf69158f1c079" alt="Placeholder image">
                        </span>
                        <span class="deliveryTime">{{ r.deliveryTime }}<span class="mins">MIN</span></span>
                        </div>
                    </div>

                    <div class="columns listing">
                        <span class="column listingItem isLeft card__title">{{ r.name }}</span>
                        <span class="column listingItem isRight stars"><img src="../assets/star.svg" alt=""> <span class="avgStars">{{ r.avgStars }}</span>/5 ({{ r.totVotes }})</span> 
                    </div>
                    <!--<img v-bind:src="images[index]" class="card__image" />    -->
                    <div class="card__content">  
                      <!--
                        {{ r.foodTypeIds.getFoodTypes() }}
                        | formatId

                        {{ r.foodTypeIds | getFoodTypes(r.foodTypeIds) }}
                        -->                      
                        <p class="card__row1"><span>{{ showPriceLevel(r.priceLevel) }}</span> {{ getFoodTypes(r.foodTypeIds) }}</p>
                        <p class="card__row2">  <span class="dark">€{{ r.minPurchase }}</span> minimum <span class="pipe">|</span>  
                          <span v-if="!r.deliveryPrice"><span class="dark">Free</span> delivery</span>
                          <span v-else><span class="dark">€{{ r.deliveryPrice }}</span> delivery fee</span>
                        </p>
                        <p v-if="r.bonus" class="card__row3">{{ r.bonus }}% bonus</p>                        
                    </div>
                    <a class="divLink" :href="index">Link</a>
              </div>
            </li>
        </ul>

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
      restaurant: [],
    }  
  },
  methods: {
		...mapActions(["getRestaurant"]), 
    showPriceLevel: function(num) { 
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
     this.getRestaurant();
  },
	computed: mapGetters(["restaurant"])
}
</script>

<style lang="less" scoped>

</style>
