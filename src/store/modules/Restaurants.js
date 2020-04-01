const state = { 
  user: null,
  locales: [],
  locale: null, 
  areas1: [],
  areas2: [],
  areas3: [],
  areas4: [],
  cities: [],
  city: null,
  lang: [],
  t: [],
  menu: [],
  orderDetails: [],
  postalCode: null,
  foodTypes: [],
  selFoodTypes: [],
  how: null,
    restaurants: [],
    restaurant: null,
    _mealGroups: [],
    _meals: [],
    mealVariations: [],
    _ingredients: [],
    orders: [],
    order: null,
    review: null,
    reviews: [],
    report: null,
    unknownUser: null,
    user: null
};
    
const getters = {    
  user: state => state.user,
  locales: state => state.locales,
  locale: state => state.locale,
  areas1: state => state.areas1,
  areas2: state => state.areas2,
  areas3: state => state.areas3,
  areas4: state => state.areas4,
  cities: state => state.cities,
  city: state => state.city,
  lang: state => state.lang,
  t: state => state.t,
  menu: state => state.menu,
  orderDetails: state => state.orderDetails,
  foodTypes: state => state.foodTypes,
  selFoodTypes: state => state.selFoodTypes,
  postalCode: state => state.postalCode, 
  how: state => state.how,

    ingredients: state => state.ingredients,
    restaurants: state => state.restaurants,
    restaurant: state => state.restaurant,
    restaurantId: (state, getters) => { return getters.restaurant.id }, // store.getters.restaurantId
    _mealGroups: state => state._mealGroups,
    _meals: state => state._meals,
    mealVariations: state => state.mealVariations,
    ingredients: state => state._ingredients,
    orders: state => state.orders,
    order: state => state.order,
    review: state => state.review,
    reviews: state => state.reviews,
    report: state => state.report,
    unknownUser: state => state.unknownUser,
    user: state => state.user
};

const actions = {
  async syncUser({ commit }) {
    commit('setUser', state.user); // hack
  },  
  async saveUser({ commit }, data) {    
    getData('saveUser', commit, data);
  },
  async getUser({ commit }, data) {    
    getData('getUser', commit, data);
  },
  async getLocales({ commit }) {
    console.log('getLocales');
     let data = [
      {
      "code": "fi-fi",
      "name": "Finland"
      },
      {
        "code": "sv-se",
        "name": "Sweden"
      },
      {
      "code": "en-uk",
      "name": "United Kingdom"
      },
     ];
   commit('setLocales', data);
    //getData('getCountries', commit, null, 'GET'); // { "countryId": id }
  },
  async initLocale({ commit }) {     
    commit('setLocale', null);
 },
  async changeLocale({ commit }, id ) {     
    commit('setLocale', id);
 },
  // getAreas1-4
  async getAreas({ commit }, id ) { 
    getData('getAreas', commit, id); 
  }, 
  async getCities({ commit }, id ) {
    console.log('get cities, countryId:', id);
     getData('cities', commit, id, 'GET'); // { "countryId": id }
  },
  async changeCity({ commit }, id ) {     
     commit('setCity', id);
  },
  async getTranslations({ commit }, lang ) {
    getData('translations', commit, lang, 'GET');
    commit('setLang', lang);
 }, 
  // OLD
 async changeLang({ commit }, lang ) {
    getData('translations_menuCreator', commit, lang, 'GET');
    commit('setLang', lang);
 }, 
 async getRestaurantTranslations({ commit }, lang ) {
  getData('translations', commit, lang, 'GET');
  commit('setLang', lang);
}, 
 async getTranslations({ commit }, lang ) {
  getData('translations', commit, lang, 'GET');
  commit('setLang', lang);
}, 
async searchMade({ commit }, val ) {
  console.log('Main searchMade kitchen:', val[0]);
	console.log('Main searchMade postalCode:', val[1]);
  console.log('Main searchMade how:', val[2]);        
  commit('setSelFoodTypes', val[0]);
  commit('setPostalCode', val[1]);
  commit('setHow', val[2]); 
}, 
// -------------------------------------------------------------------------- GET 
async getMenu({ commit }, id ) {  
  getData('getMenu', commit, { "restaurantId": id });
},
 async getFoodTypes({ commit }, id ) { 
   console.log('STORE getFoodTypes called, lang:', id);
  getData('getFoodTypes', commit, { "langId": id }); 
}, 
async doSetSelFoodTypes({ commit }, data ) {    
 commit('setSelFoodTypes', data);
},
async initFoodTypes({ commit }) { 
  commit('setSelFoodTypes', []);
},
async getMealGroups({ commit }, id ) {
 getData('getMealGroups', commit, { "restaurantId": id });
},
async getMeals({ commit }, id ) {
getData('getMeals', commit, { "restaurantId": id }); // ------------ addMeal({ commit }, data) {
},
// SAVE
async saveMealGroups({ commit }, data ) {  
 getData('saveMealGroups', commit, data, 'POST');
}, 
async saveMeals({ commit }, data ) { 
 getData('saveMeals', commit, data, 'POST');
}, 
async saveRestaurant({ commit }, data ) { 
  alert('store saveRestaurant:', data);
 getData('saveRestaurant', commit, data, 'POST');
}, 
async saveOrderDetails({ commit }, data ) { 
  getData('saveOrderDetails', commit, data, 'POST');
 }, // create PHP file next

async getIngredients({ commit }, id ) {
   getData('getIngredients', commit, { "langId": id });
 },
async initRestaurant({ commit }) { // 'GET'
  commit('setRestaurant', []);
 }, 
 async initOrder({ commit }) { 
   // "deliveryFee": state.restaurant.deliveryPrice,
  let order = {
    "userId": null,
    "items": [],
    "deliveryFee": 0,
    "subTotalPrice": 0,
    "totalPrice": 0
   }; /*
   let order = {
    "userId": 1,
    "items": [{
      "orderItemId": 1, 
      "mealId": 129,
      "amount": 10, 
      "name": "C",
      "variationId": null,
      "unitPrice": 12
    },
    {
      "orderItemId": 2, 
      "mealId": 500,
      "amount": 10, 
      "name": "T",
      "variationId": null,
      "unitPrice": 8
    }],
    "deliveryFee": 3,
    "subTotalPrice": 20,
    "totalPrice": 23
   }; */
   console.log('initOrder called'); 
 commit('setOrder', order);
},
async decreaseOrderAmount({ commit }, obj) {
  commit('decreaseAmount', obj);
},
async increaseOrderAmount({ commit }, obj) {
    commit('increaseAmount', obj);
},
async updateOrder({ commit }, mealObj) {  
  commit('addToOrder', mealObj);
 },
 async getOrder({ commit }) { 
   console.log('getOrder called');
  commit('setOrder', state.order);
 },

 async getRestaurants({ commit }) { // 'GET'
 console.log('getRestaurants');
 getData('getRestaurants', commit); 
  },
  async getRestaurant({ commit }, id ) {
    getData('getRestaurant', commit, { "restaurantId": id });
  },
  async addMeal({ commit }, data) {
    // getData('addMeal', commit, data);
    commit('addMeal', data); // adds only into state, not DB!
  },   
};



const mutations = {   
  setUser: (state, data) => (state.user = data),
  setLocales: (state, data) => (state.locales = data),
  setLocale: (state, data) => (state.locale = data),
  setSelFoodTypes: (state, data) => (state.selFoodTypes = data),
  setPostalCode: (state, data) => (state.postalCode = data),
  setHow: (state, data) => (state.how = data),

  increaseAmount: (state, editedObj) => {
    state.order.items = changeAmount(JSON.parse(JSON.stringify(state.order.items)), editedObj.mealId, 'increase');
    calculateSums();
      // TODO: change subtotal and total here!
  },
  decreaseAmount: (state, editedObj) => {
    state.order.items = changeAmount(JSON.parse(JSON.stringify(state.order.items)), editedObj.mealId, 'decrease');
    calculateSums();
    // BELOW working!!
    /*
    let arr = JSON.parse(JSON.stringify(state.order.items));   
  //let index = arr.findIndex(item => item.orderItemId === obj.orderItemId);
    let index = state.order.items.findIndex(item => item.orderItemId === obj.orderItemId);    
    let currAmount = parseInt(arr[index].amount);
    if(currAmount == 1) {
      state.order.items = state.order.items.filter(el => el.orderItemId !== obj.orderItemId); return; // delete item
    } else {      
      state.order.items[index].amount = parseInt(arr[index].amount) - 1; // decrease by 1
    }
    */
  },
  /*
  // get largest id
					let temp = this.mealGroups;
					largestId = temp.sort((a, b) => b.id - a.id)[0];
					largestId = parseInt(largestId.id)+1;
  */
  addToOrder: (state, newItem) => {
    console.log('state.restaurant.id', state.restaurant.id);
    if(state.restaurant.id != state.menu[0].restaurantId) { 
      alert('You can only place items from one restaurant into the order. Now your order has dishes from other restaurant, please remove them first.'); // TEST!!
      return; 
    }
    let index = state.order.items.findIndex(item => item.mealId === newItem.mealId);
    if(index != -1) {      
      state.order.items[index].amount = parseInt(state.order.items[index].amount)+1; // increase amount only
    } else {
      state.order.items.push(newItem); // add item
    }
    calculateSums();
    //state.order.subTotalPrice = parseInt(state.order.subTotalPrice) + parseInt(newItem.price);
    //state.order.totalPrice = parseInt(state.order.subTotalPrice) + parseInt(state.order.deliveryFee);
    

    ////commit('addToOrder', state.order);
    ////state.order = data, 
  },
  setAreas1: (state, data) => (state.areas1 = {"totalResultsCount":18,"geonames":[{"adminCode1":"09","lng":"28.16667","geonameId":830699,"toponymName":"Etelä-Karjala","countryId":"660013","fcl":"A","population":132252,"countryCode":"FI","name":"Etelä-Karjala","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"02"},"countryName":"Suomi","fcodeName":"first-order administrative division","adminName1":"Etelä-Karjala","lat":"60.96667","fcode":"ADM1"},{"adminCode1":"14","lng":"23","geonameId":830682,"toponymName":"Etelä-Pohjanmaa","countryId":"660013","fcl":"A","population":192675,"countryCode":"FI","name":"Etelä-Pohjanmaa","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"03"},"countryName":"Suomi","fcodeName":"first-order administrative division","adminName1":"Etelä-Pohjanmaa","lat":"62.75","fcode":"ADM1"},{"adminCode1":"10","lng":"27.83333","geonameId":830695,"toponymName":"Southern Savonia","countryId":"660013","fcl":"A","population":152518,"countryCode":"FI","name":"Etelä-Savo","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"04"},"countryName":"Suomi","fcodeName":"first-order administrative division","adminName1":"Etelä-Savo","lat":"61.75","fcode":"ADM1"},{"adminCode1":"18","lng":"28.5","geonameId":830664,"toponymName":"Kainuu","countryId":"660013","fcl":"A","population":84498,"countryCode":"FI","name":"Kainuu","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"05"},"countryName":"Suomi","fcodeName":"first-order administrative division","adminName1":"Kainuu","lat":"64.5","fcode":"ADM1"},{"adminCode1":"05","lng":"24.33333","geonameId":830705,"toponymName":"Kanta-Häme","countryId":"660013","fcl":"A","population":167442,"countryCode":"FI","name":"Kanta-Häme","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"06"},"countryName":"Suomi","fcodeName":"first-order administrative division","adminName1":"Kanta-Häme","lat":"60.91667","fcode":"ADM1"},{"adminCode1":"16","lng":"24.08333","geonameId":830675,"toponymName":"Keski-Pohjanmaa","countryId":"660013","fcl":"A","population":70106,"countryCode":"FI","name":"Keski-Pohjanmaa","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"07"},"countryName":"Suomi","fcodeName":"first-order administrative division","adminName1":"Keski-Pohjanmaa","lat":"63.58333","fcode":"ADM1"},{"adminCode1":"13","lng":"25.5","geonameId":830685,"toponymName":"Mellersta Finland","countryId":"660013","fcl":"A","population":275320,"countryCode":"FI","name":"Keski-Suomi","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"08"},"countryName":"Suomi","fcodeName":"first-order administrative division","adminName1":"Keski-Suomi","lat":"62.5","fcode":"ADM1"},{"adminCode1":"08","lng":"26.91667","geonameId":830703,"toponymName":"Kymenlaakso","countryId":"660013","fcl":"A","population":184317,"countryCode":"FI","name":"Kymenlaakso","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"09"},"countryName":"Suomi","fcodeName":"first-order administrative division","adminName1":"Kymenlaakso","lat":"60.83333","fcode":"ADM1"},{"adminCode1":"19","lng":"26.5","geonameId":830603,"toponymName":"Lapland","countryId":"660013","fcl":"A","population":182885,"countryCode":"FI","name":"Lappi","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"10"},"countryName":"Suomi","fcodeName":"first-order administrative division","adminName1":"Lappi","lat":"67.75","fcode":"ADM1"},{"adminCode1":"06","lng":"23.71667","geonameId":830704,"toponymName":"Pirkanmaa","countryId":"660013","fcl":"A","population":462627,"countryCode":"FI","name":"Pirkanmaa","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"first-order administrative division","adminName1":"Pirkanmaa","lat":"61.7","fcode":"ADM1"},{"adminCode1":"15","lng":"22.16667","geonameId":830676,"toponymName":"Pohjanmaa","countryId":"660013","fcl":"A","population":180384,"countryCode":"FI","name":"Pohjanmaa","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"12"},"countryName":"Suomi","fcodeName":"first-order administrative division","adminName1":"Pohjanmaa","lat":"63.08333","fcode":"ADM1"},{"adminCode1":"12","lng":"29.91667","geonameId":830686,"toponymName":"Pohjois-Karjala","countryId":"660013","fcl":"A","population":166500,"countryCode":"FI","name":"Pohjois-Karjala","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"13"},"countryName":"Suomi","fcodeName":"first-order administrative division","adminName1":"Pohjois-Karjala","lat":"62.83333","fcode":"ADM1"},{"adminCode1":"17","lng":"26.41667","geonameId":830667,"toponymName":"Pohjois-Pohjanmaa","countryId":"660013","fcl":"A","population":384900,"countryCode":"FI","name":"Pohjois-Pohjanmaa","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"14"},"countryName":"Suomi","fcodeName":"first-order administrative division","adminName1":"Pohjois-Pohjanmaa","lat":"65","fcode":"ADM1"},{"adminCode1":"11","lng":"27.5","geonameId":830690,"toponymName":"Pohjois-Savo","countryId":"660013","fcl":"A","population":250294,"countryCode":"FI","name":"Pohjois-Savo","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"15"},"countryName":"Suomi","fcodeName":"first-order administrative division","adminName1":"Pohjois-Savo","lat":"63.16667","fcode":"ADM1"},{"adminCode1":"07","lng":"25.83333","geonameId":831040,"toponymName":"Päijänne-Tavastland","countryId":"660013","fcl":"A","population":199059,"countryCode":"FI","name":"Päijät-Häme","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"16"},"countryName":"Suomi","fcodeName":"first-order administrative division","adminName1":"Päijät-Häme","lat":"61.25","fcode":"ADM1"},{"adminCode1":"04","lng":"22.16667","geonameId":831041,"toponymName":"Satakunta","countryId":"660013","fcl":"A","population":232687,"countryCode":"FI","name":"Satakunta","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"17"},"countryName":"Suomi","fcodeName":"first-order administrative division","adminName1":"Satakunta","lat":"61.5","fcode":"ADM1"},{"adminCode1":"01","lng":"24.75","geonameId":830709,"toponymName":"Uusimaa","countryId":"660013","fcl":"A","population":1585473,"countryCode":"FI","name":"Uusimaa","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"18"},"countryName":"Suomi","fcodeName":"first-order administrative division","adminName1":"Uusimaa","lat":"60.41667","fcode":"ADM1"},{"adminCode1":"02","lng":"22.25","geonameId":830708,"toponymName":"Varsinais-Suomi","countryId":"660013","fcl":"A","population":470880,"countryCode":"FI","name":"Varsinais-Suomi","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"19"},"countryName":"Suomi","fcodeName":"first-order administrative division","adminName1":"Varsinais-Suomi","lat":"60.5","fcode":"ADM1"}]}),
    // data),
  setAreas2: (state, data) => (state.areas2 = {"totalResultsCount":5,"geonames":[{"adminCode1":"06","lng":"23.71874","geonameId":9610685,"toponymName":"Etelä-Pirkanmaa","countryId":"660013","fcl":"A","population":0,"countryCode":"FI","name":"Etelä-Pirkamaan seutukunta","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"second-order administrative division","adminName1":"Pirkanmaa","lat":"61.14637","fcode":"ADM2"},{"adminCode1":"06","lng":"22.92897","geonameId":9610687,"toponymName":"Lounais-Pirkanmaa","countryId":"660013","fcl":"A","population":0,"countryCode":"FI","name":"Lounais-Pirkanmaan seutukunta","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"second-order administrative division","adminName1":"Pirkanmaa","lat":"61.36155","fcode":"ADM2"},{"adminCode1":"06","lng":"23.06801","geonameId":9610684,"toponymName":"Luoteis-Pirkanmaa","countryId":"660013","fcl":"A","population":0,"countryCode":"FI","name":"Luoteis-Pirkanmaan seutukunta","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"second-order administrative division","adminName1":"Pirkanmaa","lat":"61.97729","fcode":"ADM2"},{"adminCode1":"06","lng":"23.92509","geonameId":9610686,"toponymName":"Tampere","countryId":"660013","fcl":"A","population":0,"countryCode":"FI","name":"Tampere","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"second-order administrative division","adminName1":"Pirkanmaa","lat":"61.57018","fcode":"ADM2"},{"adminCode1":"06","lng":"24.04921","geonameId":9610688,"toponymName":"Ylä-Pirkanmaa","countryId":"660013","fcl":"A","population":0,"countryCode":"FI","name":"Ylä-Pirkanmaa","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"second-order administrative division","adminName1":"Pirkanmaa","lat":"62.09625","fcode":"ADM2"}]}),
    //data),
  setAreas3: (state, data) => (state.areas3 = {"totalResultsCount":10,"geonames":[{"adminCode1":"06","lng":"23.17228","geonameId":659185,"toponymName":"Hämeenkyrö","countryId":"660013","fcl":"A","population":10489,"countryCode":"FI","name":"Hämeenkyrön Kunta","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"third-order administrative division","adminName1":"Pirkanmaa","lat":"61.61596","fcode":"ADM3"},{"adminCode1":"06","lng":"24.417","geonameId":654441,"toponymName":"Kangasala","countryId":"660013","fcl":"A","population":29675,"countryCode":"FI","name":"Kangasala","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"third-order administrative division","adminName1":"Pirkanmaa","lat":"61.48598","fcode":"ADM3"},{"adminCode1":"06","lng":"23.77011","geonameId":648369,"toponymName":"Lempäälä","countryId":"660013","fcl":"A","population":20588,"countryCode":"FI","name":"Lempäälä","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"third-order administrative division","adminName1":"Pirkanmaa","lat":"61.33885","fcode":"ADM3"},{"adminCode1":"06","lng":"23.37717","geonameId":644451,"toponymName":"Nokia","countryId":"660013","fcl":"A","population":31647,"countryCode":"FI","name":"Nokian Kaupunki","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"third-order administrative division","adminName1":"Pirkanmaa","lat":"61.44712","fcode":"ADM3"},{"adminCode1":"06","lng":"24.35892","geonameId":643631,"toponymName":"Orivesi","countryId":"660013","fcl":"A","population":9617,"countryCode":"FI","name":"Orivesi","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"third-order administrative division","adminName1":"Pirkanmaa","lat":"61.67994","fcode":"ADM3"},{"adminCode1":"06","lng":"23.61414","geonameId":641491,"toponymName":"Pirkkala","countryId":"660013","fcl":"A","population":17237,"countryCode":"FI","name":"Pirkkala","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"third-order administrative division","adminName1":"Pirkanmaa","lat":"61.44106","fcode":"ADM3"},{"adminCode1":"06","lng":"24.51912","geonameId":642977,"toponymName":"Pälkäne","countryId":"660013","fcl":"A","population":6950,"countryCode":"FI","name":"Pälkäne","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"third-order administrative division","adminName1":"Pirkanmaa","lat":"61.35403","fcode":"ADM3"},{"adminCode1":"06","lng":"23.87021","geonameId":634964,"toponymName":"Tampere","countryId":"660013","fcl":"A","population":213217,"countryCode":"FI","name":"Tampere","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"third-order administrative division","adminName1":"Pirkanmaa","lat":"61.60736","fcode":"ADM3"},{"adminCode1":"06","lng":"23.48543","geonameId":631857,"toponymName":"Vesilahti","countryId":"660013","fcl":"A","population":4345,"countryCode":"FI","name":"Vesilahden Kunta","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"third-order administrative division","adminName1":"Pirkanmaa","lat":"61.28509","fcode":"ADM3"},{"adminCode1":"06","lng":"23.61233","geonameId":630753,"toponymName":"Ylöjärvi","countryId":"660013","fcl":"A","population":30500,"countryCode":"FI","name":"Ylöjärvi","fclName":"country, state, region,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"third-order administrative division","adminName1":"Pirkanmaa","lat":"61.84827","fcode":"ADM3"}]}),      
    //data),
  setAreas4: (state, data) => (state.areas4 = {"totalResultsCount":107,"geonames":[{"adminCode1":"06","lng":"23.78712","geonameId":634963,"toponymName":"Tampere","countryId":"660013","fcl":"P","population":202687,"countryCode":"FI","name":"Tampere","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"seat of a first-order administrative division","adminName1":"Pirkanmaa","lat":"61.49911","fcode":"PPLA"},{"adminCode1":"06","lng":"23.89183","geonameId":661731,"toponymName":"Aitolahti","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Aitolahti","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.54577","fcode":"PPL"},{"adminCode1":"06","lng":"23.82447","geonameId":661728,"toponymName":"Aitoniemi","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Aitoniemi","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.56796","fcode":"PPL"},{"adminCode1":"06","lng":"23.92445","geonameId":660899,"toponymName":"Asuntila","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Asuntila","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.68173","fcode":"PPL"},{"adminCode1":"06","lng":"23.6679","geonameId":660216,"toponymName":"Epilä","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Epilä","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.50808","fcode":"PPL"},{"adminCode1":"06","lng":"23.86308","geonameId":6940574,"toponymName":"Etelä-Hervanta","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Etelä-Hervanta","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.43926","fcode":"PPL"},{"adminCode1":"06","lng":"23.68549","geonameId":7732558,"toponymName":"Haapalinna","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Haapalinna","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.50825","fcode":"PPL"},{"adminCode1":"06","lng":"23.82939","geonameId":6930896,"toponymName":"Hallila","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Hallila","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.4631","fcode":"PPL"},{"adminCode1":"06","lng":"23.88377","geonameId":7838786,"toponymName":"Hankkio","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Hankkio","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.4812","fcode":"PPL"},{"adminCode1":"06","lng":"23.87999","geonameId":7838785,"toponymName":"Hautala","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Hautala","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.48666","fcode":"PPL"},{"adminCode1":"06","lng":"23.97629","geonameId":7871210,"toponymName":"Heinänen","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Heinänen","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.64433","fcode":"PPL"},{"adminCode1":"06","lng":"23.85166","geonameId":658120,"toponymName":"Hervanta","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Hervanta","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.45108","fcode":"PPL"},{"adminCode1":"06","lng":"23.83835","geonameId":7732160,"toponymName":"Huikas","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Huikas","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.4979","fcode":"PPL"},{"adminCode1":"06","lng":"23.59417","geonameId":656766,"toponymName":"Ikuri","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Ikuri","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.51132","fcode":"PPL"},{"adminCode1":"06","lng":"23.86479","geonameId":7871197,"toponymName":"Iso-Kovero","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Iso-Kovero","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.67611","fcode":"PPL"},{"adminCode1":"06","lng":"23.98436","geonameId":7871211,"toponymName":"Jaakkola","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Jaakkola","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.61843","fcode":"PPL"},{"adminCode1":"06","lng":"23.85638","geonameId":7732163,"toponymName":"Janka","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Janka","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.48846","fcode":"PPL"},{"adminCode1":"06","lng":"23.76935","geonameId":6931107,"toponymName":"Juhannuskylä","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Juhannuskylä","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.50239","fcode":"PPL"},{"adminCode1":"06","lng":"23.87741","geonameId":7838815,"toponymName":"Junkkari","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Junkkari","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.53554","fcode":"PPL"},{"adminCode1":"06","lng":"23.83333","geonameId":655325,"toponymName":"Jutila","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Jutila","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.75","fcode":"PPL"},{"adminCode1":"06","lng":"24.06311","geonameId":7838829,"toponymName":"Jylhänperä","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Jylhänperä","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.76669","fcode":"PPL"},{"adminCode1":"06","lng":"23.96667","geonameId":655938,"toponymName":"Järvensivu","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Järvensivu","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.78333","fcode":"PPL"},{"adminCode1":"06","lng":"23.80205","geonameId":6930932,"toponymName":"Järvensivu","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Järvensivu","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.48912","fcode":"PPL"},{"adminCode1":"06","lng":"23.98839","geonameId":655163,"toponymName":"Kaanaa","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Kaanaa","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.77385","fcode":"PPL"},{"adminCode1":"06","lng":"23.80047","geonameId":6930893,"toponymName":"Kaleva","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Kaleva","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.49897","fcode":"PPL"},{"adminCode1":"06","lng":"23.8372","geonameId":654237,"toponymName":"Kapee","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Kapee","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.81144","fcode":"PPL"},{"adminCode1":"06","lng":"23.95414","geonameId":7871195,"toponymName":"Katajamäki","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Katajamäki","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.7077","fcode":"PPL"},{"adminCode1":"06","lng":"23.86745","geonameId":7838814,"toponymName":"Keso","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Keso","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.54209","fcode":"PPL"},{"adminCode1":"06","lng":"23.86402","geonameId":7838816,"toponymName":"Kiikkinen","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Kiikkinen","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.53354","fcode":"PPL"},{"adminCode1":"06","lng":"23.86059","geonameId":651774,"toponymName":"Kolunkylä","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Kolunkylä","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.60558","fcode":"PPL"},{"adminCode1":"06","lng":"24","geonameId":651267,"toponymName":"Kortejärvi","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Kortejärvi","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.6","fcode":"PPL"},{"adminCode1":"06","lng":"24.04976","geonameId":7871212,"toponymName":"Kotimäki","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Kotimäki","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.6126","fcode":"PPL"},{"adminCode1":"06","lng":"23.81169","geonameId":7871204,"toponymName":"Kotkanniemi","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Kotkanniemi","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.61122","fcode":"PPL"},{"adminCode1":"06","lng":"23.94367","geonameId":650483,"toponymName":"Kulkkila","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Kulkkila","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.65664","fcode":"PPL"},{"adminCode1":"06","lng":"23.93389","geonameId":7838806,"toponymName":"Kumpula","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Kumpula","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.5134","fcode":"PPL"},{"adminCode1":"06","lng":"23.88883","geonameId":7871209,"toponymName":"Kuusniemi","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Kuusniemi","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.63976","fcode":"PPL"},{"adminCode1":"06","lng":"23.83724","geonameId":654509,"toponymName":"Kämmenniemi","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Kämmenniemi","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.62982","fcode":"PPL"},{"adminCode1":"06","lng":"23.90144","geonameId":7838813,"toponymName":"Laalahti","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Laalahti","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.54789","fcode":"PPL"},{"adminCode1":"06","lng":"23.76575","geonameId":7732142,"toponymName":"Lahdenperä","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Lahdenperä","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.43708","fcode":"PPL"},{"adminCode1":"06","lng":"23.76245","geonameId":7838784,"toponymName":"Lakalaiva","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Lakalaiva","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.46015","fcode":"PPL"},{"adminCode1":"06","lng":"23.62618","geonameId":649197,"toponymName":"Lamminpää","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Lamminpää","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.51963","fcode":"PPL"},{"adminCode1":"06","lng":"23.77853","geonameId":648884,"toponymName":"Lappi","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Lappi","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.5091","fcode":"PPL"},{"adminCode1":"06","lng":"23.90093","geonameId":7732150,"toponymName":"Leinola","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Leinola","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.48617","fcode":"PPL"},{"adminCode1":"06","lng":"23.77371","geonameId":7732140,"toponymName":"Leppänen","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Leppänen","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.44638","fcode":"PPL"},{"adminCode1":"06","lng":"23.66584","geonameId":648087,"toponymName":"Lielahti","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Lielahti","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.51754","fcode":"PPL"},{"adminCode1":"06","lng":"23.61262","geonameId":7732325,"toponymName":"Likolammi","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Likolammi","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.49657","fcode":"PPL"},{"adminCode1":"06","lng":"23.6706","geonameId":7644875,"toponymName":"Lintulampi","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Lintulampi","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.52696","fcode":"PPL"},{"adminCode1":"06","lng":"23.82591","geonameId":7838834,"toponymName":"Maisansalo","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Maisansalo","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.69248","fcode":"PPL"},{"adminCode1":"06","lng":"23.84222","geonameId":646157,"toponymName":"Messukylä","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Messukylä","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.48547","fcode":"PPL"},{"adminCode1":"06","lng":"23.79827","geonameId":7838835,"toponymName":"Murikka","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Murikka","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.70237","fcode":"PPL"},{"adminCode1":"06","lng":"23.94315","geonameId":7871199,"toponymName":"Myllykylä","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Myllykylä","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.68421","fcode":"PPL"},{"adminCode1":"06","lng":"24.0592","geonameId":7871201,"toponymName":"Myllymaa","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Myllymaa","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.67114","fcode":"PPL"},{"adminCode1":"06","lng":"23.9114","geonameId":7871205,"toponymName":"Mäntylä","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Mäntylä","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.61391","fcode":"PPL"},{"adminCode1":"06","lng":"23.98745","geonameId":7871193,"toponymName":"Naappila","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Naappila","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.72929","fcode":"PPL"},{"adminCode1":"06","lng":"23.9325","geonameId":7871198,"toponymName":"Niemenkylä","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Niemenkylä","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.69965","fcode":"PPL"},{"adminCode1":"06","lng":"23.94178","geonameId":644178,"toponymName":"Nurmi","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Nurmi","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.53779","fcode":"PPL"},{"adminCode1":"06","lng":"23.94325","geonameId":6931110,"toponymName":"Olkahinen","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Olkahinen","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.52526","fcode":"PPL"},{"adminCode1":"06","lng":"23.72961","geonameId":7732323,"toponymName":"Onkiniemi","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Onkiniemi","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.50362","fcode":"PPL"},{"adminCode1":"06","lng":"23.96865","geonameId":7838830,"toponymName":"Oravaniemi","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Oravaniemi","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.77061","fcode":"PPL"},{"adminCode1":"06","lng":"23.93818","geonameId":641165,"toponymName":"Paarlahti","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Paarlahti","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.64099","fcode":"PPL"},{"adminCode1":"06","lng":"23.80136","geonameId":643275,"toponymName":"Paavola","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Paavola","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.61317","fcode":"PPL"},{"adminCode1":"06","lng":"23.78333","geonameId":643251,"toponymName":"Padustaipale","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Padustaipale","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.65","fcode":"PPL"},{"adminCode1":"06","lng":"23.98154","geonameId":7838812,"toponymName":"Palo","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Palo","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.55657","fcode":"PPL"},{"adminCode1":"06","lng":"23.88256","geonameId":7732157,"toponymName":"Peltola","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Peltola","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.50132","fcode":"PPL"},{"adminCode1":"06","lng":"23.79656","geonameId":641945,"toponymName":"Petsamo","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Petsamo","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.50722","fcode":"PPL"},{"adminCode1":"06","lng":"23.70558","geonameId":641382,"toponymName":"Pispala","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Pispala","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.50554","fcode":"PPL"},{"adminCode1":"06","lng":"23.84711","geonameId":6940573,"toponymName":"Pohjois-Hervanta","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Pohjois-Hervanta","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.45772","fcode":"PPL"},{"adminCode1":"06","lng":"23.67579","geonameId":650542,"toponymName":"Pohtola","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Pohtola","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.5373","fcode":"PPL"},{"adminCode1":"06","lng":"23.63863","geonameId":640159,"toponymName":"Rahola","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Rahola","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.49805","fcode":"PPL"},{"adminCode1":"06","lng":"23.7651","geonameId":6931108,"toponymName":"Ratina","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Ratina","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.49319","fcode":"PPL"},{"adminCode1":"06","lng":"23.64187","geonameId":7732324,"toponymName":"Ristimäki","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Ristimäki","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.50377","fcode":"PPL"},{"adminCode1":"06","lng":"23.83698","geonameId":633212,"toponymName":"Ruotula","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Ruotula","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.50239","fcode":"PPL"},{"adminCode1":"06","lng":"24.03946","geonameId":637307,"toponymName":"Savo","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Savo","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.68206","fcode":"PPL"},{"adminCode1":"06","lng":"23.91852","geonameId":7838833,"toponymName":"Siltala","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Siltala","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.71006","fcode":"PPL"},{"adminCode1":"06","lng":"23.93372","geonameId":636259,"toponymName":"Sorila","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Sorila","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.55754","fcode":"PPL"},{"adminCode1":"06","lng":"24","geonameId":636236,"toponymName":"Sorri","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Sorri","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.71667","fcode":"PPL"},{"adminCode1":"06","lng":"23.89196","geonameId":7871208,"toponymName":"Sääksniemi","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Sääksniemi","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.63208","fcode":"PPL"},{"adminCode1":"06","lng":"23.77974","geonameId":7732162,"toponymName":"Taatala","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Taatala","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.46994","fcode":"PPL"},{"adminCode1":"06","lng":"23.71119","geonameId":6930908,"toponymName":"Tahmela","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Tahmela","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.49752","fcode":"PPL"},{"adminCode1":"06","lng":"23.92676","geonameId":6931109,"toponymName":"Tasanne","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Tasanne","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.51845","fcode":"PPL"},{"adminCode1":"06","lng":"23.78881","geonameId":7838838,"toponymName":"Taulakylä","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Taulakylä","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.65726","fcode":"PPL"},{"adminCode1":"06","lng":"23.77584","geonameId":8714317,"toponymName":"Taulaniemi","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Taulaniemi","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.65566","fcode":"PPL"},{"adminCode1":"06","lng":"23.8484","geonameId":634760,"toponymName":"Teisko","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Teisko","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.67399","fcode":"PPL"},{"adminCode1":"06","lng":"23.82849","geonameId":7838836,"toponymName":"Teiskola","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Teiskola","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.67497","fcode":"PPL"},{"adminCode1":"06","lng":"23.90059","geonameId":634709,"toponymName":"Terälahti","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Terälahti","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.70851","fcode":"PPL"},{"adminCode1":"06","lng":"23.82223","geonameId":7838837,"toponymName":"Toijakylä","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Toijakylä","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.66283","fcode":"PPL"},{"adminCode1":"06","lng":"23.83947","geonameId":7871203,"toponymName":"Toni","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Toni","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.62052","fcode":"PPL"},{"adminCode1":"06","lng":"23.88453","geonameId":7732159,"toponymName":"Toritunjärvi","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Toritunjärvi","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.50634","fcode":"PPL"},{"adminCode1":"06","lng":"24","geonameId":633878,"toponymName":"Tuhria","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Tuhria","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.71667","fcode":"PPL"},{"adminCode1":"06","lng":"24.00271","geonameId":7871194,"toponymName":"Ukaa","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Ukaa","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.72218","fcode":"PPL"},{"adminCode1":"06","lng":"23.90239","geonameId":7871196,"toponymName":"Uusi-Kovero","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Uusi-Kovero","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.6939","fcode":"PPL"},{"adminCode1":"06","lng":"23.94608","geonameId":7871206,"toponymName":"Uusitalo","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Uusitalo","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.61929","fcode":"PPL"},{"adminCode1":"06","lng":"23.76703","geonameId":7732141,"toponymName":"Valkama","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Valkama","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.4434","fcode":"PPL"},{"adminCode1":"06","lng":"24.03809","geonameId":7871200,"toponymName":"Valkeejärvi","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Valkeejärvi","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.69817","fcode":"PPL"},{"adminCode1":"06","lng":"23.91155","geonameId":7871207,"toponymName":"Vattula","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Vattula","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.63309","fcode":"PPL"},{"adminCode1":"06","lng":"23.91827","geonameId":632056,"toponymName":"Vehmainen","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Vehmainen","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.47674","fcode":"PPL"},{"adminCode1":"06","lng":"24.02396","geonameId":7871192,"toponymName":"Vehokylä","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Vehokylä","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.75173","fcode":"PPL"},{"adminCode1":"06","lng":"23.91518","geonameId":632000,"toponymName":"Velaatta","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Velaatta","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.74624","fcode":"PPL"},{"adminCode1":"06","lng":"24.0495","geonameId":631570,"toponymName":"Viitapohja","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Viitapohja","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.65318","fcode":"PPL"},{"adminCode1":"06","lng":"23.88835","geonameId":7838831,"toponymName":"Yrjölänkylä","countryId":"660013","fcl":"P","population":0,"countryCode":"FI","name":"Yrjölänkylä","fclName":"city, village,...","adminCodes1":{"ISO3166_2":"11"},"countryName":"Suomi","fcodeName":"populated place","adminName1":"Pirkanmaa","lat":"61.754","fcode":"PPL"}]}),
  //data),
  setAreas5: (state, data) => (state.areas4 = data),
  //data),
  setCity: (state, data) => (state.city = data),
  setCities: (state, data) => (state.cities = data),
  setLang: (state, data) => (state.lang = data),
  setTranslations: (state, data) => (state.t = data),     
  setCode: (state, data) => (state.code = data), 
  setMenu: (state, data) => (state.menu = data), 
  setOrderDetails: (state, data) => (state.orderDetails = data),
    setFoodTypes: (state, data) => (state.foodTypes = data), 
    setSelFoodTypes: (state, data) => (state.selFoodTypes = data),     
    setMealGroups: (state, data) => (state._mealGroups = data),
    setMeals: (state, data) => (state._meals = data),
    setIngredients: (state, data) => (state._ingredients = data),
    // setFoodTypes: (state, data) => (state.foodTypes = data),
    setRestaurants: (state, restaurants) => (state.restaurants = restaurants),
    setRestaurant: (state, restaurant) => (state.restaurant = restaurant),    
    addMeal: (state, data) => (state._meals.push(data)),
    //setMeals: (state, meals) => (state.meals = meals),
    setMealVariations: (state, mealVariations) => (state.mealVariations = mealVariations),
    //setIngredients: (state, ingredients) => (state.ingredients = ingredients),
    setOrders: (state, orders) => (state.orders = orders),
    setOrder: (state, data) => (state.order = data),
    setReview: (state, review) => (state.review = review),
    setReviews: (state, reviews) => (state.reviews = reviews),
    setReport: (state, report) => (state.report = report),
    setUnknownUser: (state, unknownUser) => (state.unknownUser = unknownUser),
    setUser: (state, user) => (state.user = user)
};
    
    
export default {
    state,
    getters,
    actions,
    mutations
};


// -------------------------- functions ----------------------------------
// all queries to DB are done here
function getData(contentName, commit, data=null, method='POST', restaurantId=null) {    
  console.log('STORE getData: ', contentName);
  let url = 'https://stuffonaut.com/pizza/' + contentName;    
  let fileType = '.php';
  if(contentName == 'translations') { url += '_' + data; fileType = '.json?6724df855ttt7s78374hudhfuy3'; } // use to bypass cache
  if(contentName == 'translations_menuCreator') { url += '_' + data; fileType = '.json?67247875ttt74664374hudhfuy3'; }
  if(contentName == 'cities') { url += '_' + data; fileType = '.json'; 
    console.log('contentName == cities, url:', url + fileType);
    }    
  url += fileType;
  // url += "?rId=" + '1';// TEMP!!!!!!!!!!!!!!!
  if(contentName == 'getAreas') { 
    //url = 'http://api.geonames.org/childrenJSON?q=a&geonameId='+data+'&maxRows=100&username=adssite8578578&lang=fi'; method='GET'; 
    commit('setAreas1', null); // temp
    commit('setAreas2', null); // temp
    commit('setAreas3', null); // temp
    commit('setAreas4', null); // temp
    commit('setAreas5', null); // temp
  }
    var postData = null;
    if(method=='POST' && data) { postData  = JSON.stringify(data); }    
    let self = this;
    fetch(url, {
      method: method,
      headers: new Headers({
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        }),
        body: postData 
    }).then(res => {
      if (res.ok) {
       return res.json();
      } else {
        console.log('Nothing found: ', res);
      }  
    }).then(data => {
      console.log(contentName + ' data found : ', data); // https://stuffonaut.com/pizza/translations_menuCreator_en.json?nocache=1423
      switch (contentName) {
        case "saveUser": commit('setUser', data[0]); break;
        case 'getUser': commit('setUser', data[0]); break;
        case 'getAreas': commit('setAreas1', data); break;
        case 'cities': commit('setCities', data); break;
        case 'getMenu': commit('setMenu', data); break;
        case 'getFoodTypes': commit('setFoodTypes', data); break;
        case 'getMealGroups': commit('setMealGroups', data); break;  
        case 'getMeals': commit('setMeals', data); break; 
        case 'getIngredients': commit('setIngredients', data); break;
        // saveMealGroups      
        
        case 'getRestaurants': commit('setRestaurants', data); break;
        case 'getRestaurant': commit('setRestaurant', data[0]); 
        case 'saveRestaurant': //commit('setRestaurant', data); 
            console.log('res saved');
            break;
          //let selFoodTypesObjArr = copyFoodTypeData(data[0].foodTypeIds);
          //commit('setSelFoodTypes', selFoodTypesObjArr);
          //commit('setSelFoodTypes', copyFoodTypeData(data[0].foodTypeIds));
          break;
        case 'translations':
          console.log('- - - STORE case translations');
          console.log('translations:', data[0]);
          commit('setTranslations', data[0]);
          break;
        default: commit('setTranslations', data[0]); // translations_menuCreator is default
          break;
      }
    })
    .catch(error => { 
      console.error(error);
    });
}
// adds or decreases .amount in object array
function changeAmount(items, id, change) {
  let index = items.findIndex(item => item.mealId === id);
  let currAmount = parseInt(items[index].amount);
  if(change == 'decrease') {
    if(currAmount == 1) {
      items = items.filter(el => el.mealId !== id); // delete item
    } else {
      items[index].amount = parseInt(items[index].amount) - 1; // decrease by 1
    }
  } else if(currAmount < 51) { /* max amount to order one dish is 50  */
    items[index].amount = parseInt(items[index].amount) + 1; // increase by 1
  }
  return items;
}

// adds object in object array
// state.order.items = changeAmount(JSON.parse(JSON.stringify(state.order.items)), editedObj.orderItemId, 'increase');
function addItem(items, newItem) {
  let index = items.findIndex(item => item.orderItemId === id);
  /*
  let currAmount = parseInt(items[index].amount);
  if(change == 'decrease') {
    if(currAmount == 1) {
      items = items.filter(el => el.orderItemId !== id); // delete item
    } else {
      items[index].amount = parseInt(items[index].amount) - 1; // decrease by 1
    }
  } else { 
    items[index].amount = parseInt(items[index].amount) + 1; // increase by 1
  }
  */
  return items;
}

function calculateSums() {
  let subTotal = 0;
  state.order.items.forEach(item => {
    subTotal += (item.amount * item.price);
  });
  state.order.subTotalPrice = subTotal;
  state.order.totalPrice = subTotal + parseInt(state.order.deliveryFee);
}
