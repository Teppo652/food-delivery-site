<template>
  <div>
    <!--
    <div v-if="!city">
      city: {{ city }}<br><br>
        <SelectCity lang="fi" />
    </div>-->



     *** locale: {{ locale }}<br><br>

    <div v-if="!locale" >      
      <SelectLocale />
    </div>


    <br>------------------------------------<br><br>
    <!--
      city: {{ city }}<br><br>

    <div id="XXXXoverlay">
      <div v-if="!city" class="XXXXpopup">
        LANG:{{ $route.params.lang }}<br>
        <SelectCity :lang=$route.params.lang />
      </div>
    </div>
-->
    
      

    <section v-if="locale" class="section">
    <div class="container">
      <h1>Listing</h1>
        <!--
          "id": "1", "listingImg": "listi1", "imgTagIds": "imgTagIds1", "deliveryTime": "10", "name": "Kotipizza", "avgStars": "5", "totVotes": "10", "priceLevel": "1", "foodTypeIds": "foodTypeIds1", "minPurchase": "10", "deliveryPrice": "3", "bonus": "1"
        
60 MIN
img
Armis Pizzeria  * 4.3/5 (587)
€€€ kebab, burgers, falafel, pizza
€12.00 minimum l  3.00 delivery fee
5% bonus
        
        -->
				restaurants: {{ restaurants }}
        <br><br>
        <div v-for="(r, index) in restaurants"  :key="index" >
        <a @click="showRestaurant(r.id)" href="#"> {{ r.name }}</a><br>
        </div>
        <!--
        <ul class="cards">
          
            <li v-for="(r, index) in restaurants"  :key="index" class="cards__item">
              <div class="card">                  
                    <div class="card-image">
                        <div class="image is-16by9">
                        <!--<span class="deliveryTime">{{ r.deliveryTime }}<span class="mins">MIN</span></span>--
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
                    <!--<img v-bind:src="images[index]" class="card__image" />    --
                    <div class="card__content">  
                      <!--
                        {{ r.foodTypeIds.getFoodTypes() }}
                        | formatId

                        {{ r.foodTypeIds | getFoodTypes(r.foodTypeIds) }}
                        --
                        <p class="card__row1"><span>{{ showPriceLevel(r.priceLevel) }}</span> {{ getFoodTypes(r.foodTypeIds) }}</p>
                        <p class="card__row2">  <span class="dark">€{{ r.minPurchase }}</span> minimum <span class="pipe">|</span>  
                          <span v-if="!r.deliveryPrice"><span class="dark">Free</span> delivery</span>
                          <span v-else><span class="dark">€{{ r.deliveryPrice }}</span> delivery fee</span>
                        </p>
                        <p v-if="r.bonus" class="card__row3">{{ r.bonus }}% bonus</p>                        
                    </div>
                    <a class="divLink" :href="index" @click.prevent="restaurantSelected(r.id)">Link</a>
              </div>
            </li>
        </ul>
        -->

    </div>
    </section>
  </div>
</template>

<script>
import SelectCity from './SelectCity'
import { mapGetters, mapActions } from "vuex"
export default {
  name: 'Listing',
	components: {
		SelectCity
  },
  data () {
    return {
      lang: null,
      tempFoodTypes: [ 
{ "id": 0, "name": "TEX MEX" },
{ "id": 1, "name": "GRILLIKANAT" },
{ "id": 2, "name": "KANAFILET" },
{ "id": 3, "name": "UUNIRULLAT" },
{ "id": 4, "name": "LEIKKEET" },
{ "id": 5, "name": "PIHVIT" },
{ "id": 6, "name": "KANAFILE" },
{ "id": 7, "name": "HAMPURILAISET" },
{ "id": 8, "name": "JUOMAT" },
{ "id": 9, "name": "KALARUOAT" }
      ]
    }  
  },
  methods: {
    showRestaurant(prodId) {
      let proId=prodId; // = restaurant id
      this.$router.push({name:'Restaurant',params:{Pid:proId}}); // = restaurant id
    },
    ...mapActions(["initLocale", "changeLocale", "getRestaurants", "saveRestaurantId", "initOrder"]),
    restaurantSelected: function(id) {
      // this.saveRestaurantId();
      console.log('restaurantSelected:', id); 
    },
    getFoodTypes: function(foodTypeIds) {
      if (!foodTypeIds) return '';
      let foodTypeNames = this.tempFoodTypes; 
      console.log('tempFoodTypes:', this.tempFoodTypes); 
      let foodTypeIdsArr = foodTypeIds.split(",");
      let i = 0;
      let lgh = foodTypeIdsArr.length;
      let res = '';
      for(i; i<lgh; i++) {
        //res+= foodTypeNames[i] + ' ';
        console.log(' / Getting name for:', foodTypeIdsArr[i]);
        res+= foodTypeNames.find(a => a.id == foodTypeIdsArr[i]).name + ' ';
      }
      return res;
    }, 
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
      if(this.locale != null) {         
        this.getRestaurants();
        this.initOrder();
      } else {
        alert('this.locale = null -  not fetching list');
      }
      
      //this.changeCountry();
     
  },
	watch: {		
		locale: function() {
      console.log('watch country: ', this.country);
      this.getRestaurants();
      this.initOrder();
    }
  },
	computed: mapGetters(["locale", "restaurants", "restaurant", "city", "selFoodTypes", "postalCode", "how"]) // selFoodTypes postalCode how
}
</script>

<style scoped>
/* XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX */
/* 444 */
*,
*::before,
*::after {
  box-sizing: border-box;
}
html {
  background-color: #f0f0f0;
}
body {
  color: #999999;
  font-family: 'Roboto', 'Helvetica Neue', Helvetica, Arial, sans-serif;
  font-style: normal;
  font-weight: 400;
  letter-spacing: 0;
  padding: 1rem;
  text-rendering: optimizeLegibility;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  -moz-font-feature-settings: "liga" on;
}
.card-image img {
  /*
  height: auto;
  max-width: 100%;
  vertical-align: middle;
  */

  display: block;
  /* max-width:385px; 
  max-height:230px; */

  width: auto;
  height: 230px;
  /*height: auto; */

}
.btn {
  background-color: white;
  border: 1px solid #cccccc;
  color: #696969;
  padding: 0.5rem;
  text-transform: lowercase;
}
.btn--block {
  display: block;
  width: 100%;
}
.cards {
  display: flex;
  flex-wrap: wrap;
  list-style: none;
  margin: 0;
  padding: 0;
}
.cards__item {
  display: flex;
  padding: .85%;
  /*1.5%;*/

}
@media (min-width: 500px) {
  .cards__item {
    /* 40 rem */
  
    width: 50%;
  }
}
@media (min-width: 700px) {
  .cards__item {
    /* 60 rem */
  
    width: 33.3%;
  }
}
@media (min-width: 1366px) {
  .cards__item {
    width: 24.3%;
  }
}
.card {
  background-color: white;
  display: flex;
  flex-direction: column;
  overflow: hidden;
}
.card:hover .card__image {
  filter: contrast(100%);
}
.card__content {
  display: flex;
  flex: 1 1 auto;
  flex-direction: column;
  padding: 0 .15rem;
}
.card__image {
  background-position: center center;
  background-repeat: no-repeat;
  background-size: cover;
  filter: contrast(70%);
  overflow: hidden;
  position: relative;
  transition: filter 0.5s cubic-bezier(0.43, 0.41, 0.22, 0.91);
}
.card__image::before {
  content: "";
  display: block;
  padding-top: 56.25%;
}
@media (min-width: 40rem) {
  .card__image::before {
    padding-top: 66.6%;
  }
}
.card-image img {
  height: 140px;
}
.card {
  color: #acacac;
  /* test */

  -webkit-box-shadow: 0 2px 3px rgba(10, 10, 10, 0.1), 0 0 0 1px rgba(10, 10, 10, 0.1);
  box-shadow: 0 2px 3px rgba(10, 10, 10, 0.1), 0 0 0 1px rgba(10, 10, 10, 0.1);
}
.card__image1 {
  background-image: url(C:/vue/eat/src/assets/1.jpg);
}
.card .image {
  display: flex;
}
.deliveryTime {
  padding: 5px 4px;
  background-color: #fff;
  position: absolute;
  color: #000;
  width: 50px;
  right: 8px;
  top: 8px;
  /* opacity: .94; */

}
.deliveryTime .mins {
  font-size: 0.65rem;
  float: left;
  width: 40px;
}
.card__title,
.avgStars {
  color: #000;
}
.card__title {
  font-size: 1.05rem;
  font-weight: 700;
  letter-spacing: 1px;
  text-align: left;
}
.stars {
  font-size: smaller;
}
b {
  color: #545454;
}
.card__row1,
.card__row2,
.card__row3 {
  flex: 1 1 auto;
  font-size: 0.875rem;
  /*line-height: 1.5;*/

  margin: .25rem 0;
  text-align: left;
}
.card__row1 span,
.card__row3 {
  color: #2ba4d5;
}
/*
.card__row2 span {
  font-weight: bold; 
} */
.pipe {
  color: #f0f0f0;
  margin: 3px;
}
.listing {
  margin: 6px 1px -2px 1px;
}
.listingItem {
  float: left;
  text-align: left;
}
.listingItem img {
  width: 13px;
  margin-top: 2px;
}
.isLeft {
  width: 75%;
}
.isRight {
  text-align: right;
  float: right;
  width: 25%;
  /*
  float: right;
    position: absolute;
    right: 0px;
    margin-right: 16px;
    z-index: 999;
    background-color: white;
    padding: 0 5px; */

}
.dark {
  color: #000;
}
li {
  position: relative;
}
li:hover {
  cursor: hand;
  cursor: pointer;
  opacity: 1;
  /* .9; */

}
/* img hover zoom */
.zoom {
  transition: transform .2s;
  margin: 0 auto;
}
.zoom:hover {
  transition: 0.5s;
  transform: scale(1.03);
}
a.divLink {
  position: absolute;
  top: 0;
  left: 0;
  text-decoration: none;
  z-index: 10;
  background-color: white;
  /*workaround to make clickable in IE */

  opacity: 0;
  /*workaround to make clickable in IE */

  filter: alpha(opacity=0);
  /*workaround to make clickable in IE */

}
@media only screen and (max-width: 500px) {
  body {
    margin: 2px;
  }
  li {
    margin-bottom: 30px;
  }
  .card-image img {
    width: 100%;
    height: auto;
  }
  .isRight {
    text-align: left;
    float: left;
    width: 100%;
    clear: left;
  }
}
@media only screen and (min-width: 1366px) {
  section {
    margin: 0 15%;
  }
}

/* select city overlay */
#overlay {
	position: fixed;
	background: url("OverlayBgr.png");
	background-repeat: repeat;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	z-index: 10000;
}

#overlay .popup {
	position: absolute;
	top: 0;
	bottom: 0;
	left: 0;
	right: 0;
	margin: auto;
	width: 50%;
	height: 50%;
	background-color: white;
}
</style>
