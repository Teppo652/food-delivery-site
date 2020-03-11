const state = {  
    code: [],
    foodTypes: [],
    restaurants: [],
    restaurant: null,
    meals: [],
    mealVariations: [],
    ingredients: [],
    orders: [],
    order: null,
    review: null,
    reviews: [],
    report: null,
    unknownUser: null,
    user: null
};
    
const getters = {
    foodTypes: state => state.foodTypes,
    ingredients: state => state.ingredients,
    restaurants: state => state.restaurants,
    restaurant: state => state.restaurant,
    meals: state => state.meals,
    mealVariations: state => state.mealVariations,
    ingredients: state => state.ingredients,
    orders: state => state.orders,
    order: state => state.order,
    review: state => state.review,
    reviews: state => state.reviews,
    report: state => state.report,
    unknownUser: state => state.unknownUser,
    user: state => state.user
};

const actions = {
  async getFoodTypes({ commit }, langId ) { 
    let data = [ 
     { "id":  1, "name": "Aasialainen" },
     { "id":  2, "name": "Falafel" },
     { "id":  3, "name": "Grillattua kanaa" } 
   ];
   commit('setFoodTypes', data);
 },
 async getIngredients({ commit }) {
    let data = [
      { "id":  1, "cat": 3, "name": "Ananasta" },
      { "id":  2, "cat": 1, "name": "Anjovista" },
      { "id":  3, "cat": 1, "name": "Artisokkaa" },
      { "id":  4, "cat": 4, "name": "Aurajuustoa" },
      { "id":  5, "cat": 1, "name": "Aurinkokuivattuja tomaatteja" },
      { "id":  6, "cat": 1, "name": "Avocadoa" },
      { "id":  7, "cat": 5, "name": "Balsamicoa" },
      { "id":  8, "cat": 2, "name": "Balsamicosipuleita" },
      { "id":  9, "cat": 5, "name": "Barbeque-kastiketta" },
      { "id": 10, "cat": 5, "name": "Basilikaa" },
      { "id": 11, "cat": 1, "name": "Bolognese-kastiketta" },
      { "id": 12, "cat": 6, "name": "Béarnaise-kastiketta" },
      { "id": 13, "cat": 6, "name": "Caesar-kastiketta" },
      { "id": 14, "cat": 5, "name": "Chilihiutale" },
      { "id": 15, "cat": 1, "name": "Chorizo-makkaraa" },
      { "id": 16, "cat": 1, "name": "Etanoita" },
      { "id": 17, "cat": 4, "name": "Fetajuustoa" },
      { "id": 18, "cat": 2, "name": "Grillattua munakoisoa" },
      { "id": 19, "cat": 5, "name": "Habaneromurskaa" },
      { "id": 20, "cat": 2, "name": "Herkkusieniä" },
      { "id": 21, "cat": 2, "name": "Herkkutatteja" },
      { "id": 22, "cat": 1, "name": "Hirveä" },
      { "id": 23, "cat": 1, "name": "Härkää" },
      { "id": 24, "cat": 2, "name": "Jalapenoa" },
      { "id": 25, "cat": 4, "name": "Juustoa" },
      { "id": 26, "cat": 2, "name": "Jättikaprista" },
      { "id": 27, "cat": 1, "name": "Jättikatkaravunpyrstöjä" },
      { "id": 28, "cat": 2, "name": "Kaktussuikaleita" },
      { "id": 29, "cat": 1, "name": "Kanaa" },
      { "id": 30, "cat": 1, "name": "Kananmunaa" },
      { "id": 31, "cat": 1, "name": "Katkarapuja" },
      { "id": 32, "cat": 1, "name": "Kebablihaa" },
      { "id": 33, "cat": 1, "name": "Kinkkua" },
      { "id": 34, "cat": 2, "name": "Kirsikkatomaattia" },
      { "id": 35, "cat": 1, "name": "Kylmäsavulohta" },
      { "id": 36, "cat": 4, "name": "Lisäjuustoa" },
      { "id": 37, "cat": 5, "name": "Luomuhunajaa" },
      { "id": 38, "cat": 2, "name": "Marinoitua seitanlastua" },
      { "id": 39, "cat": 4, "name": "Mascarpone-tuorejuustoa" },
      { "id": 40, "cat": 1, "name": "Metsäsieniä" },
      { "id": 41, "cat": 4, "name": "Mozzarellaraastetta" },
      { "id": 42, "cat": 1, "name": "Mustekalaa" },
      { "id": 43, "cat": 1, "name": "Napoli -salamin siivuja" },
      { "id": 44, "cat": 1, "name": "Nyhtöpossua" },
      { "id": 45, "cat": 2, "name": "Oliiveja" },
      { "id": 46, "cat": 1, "name": "Paneroituja mustekalarenkaita" },
      { "id": 47, "cat": 2, "name": "Paprikaa" },
      { "id": 48, "cat": 1, "name": "Parmankinkkua" },
      { "id": 49, "cat": 4, "name": "Parmesan lastuja" },
      { "id": 50, "cat": 4, "name": "Parmesan-juustoa" },
      { "id": 51, "cat": 2, "name": "Parsaa" },
      { "id": 52, "cat": 1, "name": "Pekonia" },
      { "id": 53, "cat": 1, "name": "Pepperonimakkaraa" },
      { "id": 54, "cat": 3, "name": "Persikkaa" },
      { "id": 55, "cat": 5, "name": "Pestokastiketta" },
      { "id": 56, "cat": 6, "name": "Pinjansiemeniä" },
      { "id": 57, "cat": 4, "name": "Provolonejuustoa" },
      { "id": 58, "cat": 2, "name": "Punasipulia" },
      { "id": 59, "cat": 6, "name": "Puolukkahilloa" },
      { "id": 60, "cat": 3, "name": "Päärynää" },
      { "id": 61, "cat": 2, "name": "Rucolaa" },
      { "id": 62, "cat": 6, "name": "Saksanpähkinää" },
      { "id": 63, "cat": 1, "name": "Salamia" },
      { "id": 64, "cat": 1, "name": "Salsicciaa" },
      { "id": 65, "cat": 1, "name": "Savuriistakäristystä" },
      { "id": 66, "cat": 1, "name": "Simpukoita" },
      { "id": 67, "cat": 2, "name": "Sipulia" },
      { "id": 69, "cat": 1, "name": "Teriyakikanaa" },
      { "id": 70, "cat": 5, "name": "Tilliä" },
      { "id": 71, "cat": 2, "name": "Tomaattia" },
      { "id": 72, "cat": 2, "name": "Tomaattisiivuja" },
      { "id": 73, "cat": 2, "name": "Tomaattisosetta" },
      { "id": 74, "cat": 1, "name": "Tonnikalaa" },
      { "id": 75, "cat": 5, "name": "Tulista chilihilloa" },
      { "id": 76, "cat": 4, "name": "Tuoremozzarellaa" },
      { "id": 77, "cat": 5, "name": "Tuoretta basilikaa" },
      { "id": 78, "cat": 5, "name": "Valkosipulia" },
      { "id": 79, "cat": 4, "name": "Vegaanijuusto" },
      { "id": 80, "cat": 1, "name": "Villisikaa" },
      { "id": 81, "cat": 4, "name": "Vuohenjuustoa" }
   ];
   commit('setIngredients', data);
 },
  async getRestaurants({ commit }) {
      getData('restaurants', commit); 
  },
  async getRestaurant({ commit }, data) { 
    getData('restaurant', commit, data ); 
  },
  async addMeal({ commit }, data) {
    // getData('addMeal', commit, data);
    commit('addMeal', data); // adds only into state, not DB!
  },
};

const mutations = {
    setCode: (state, code) => (state.code = code), 
    setFoodTypes: (state, data) => (state.foodTypes = data), 
    
    // setFoodTypes: (state, data) => (state.foodTypes = data),
    setRestaurants: (state, restaurants) => (state.restaurants = restaurants),
    setRestaurant: (state, restaurant) => (state.restaurant = restaurant),    
    addMeal: (state, data) => (state.meals.push(data)),

    setMeals: (state, meals) => (state.meals = meals),
    setMealVariations: (state, mealVariations) => (state.mealVariations = mealVariations),
    setIngredients: (state, ingredients) => (state.ingredients = ingredients),
    setOrders: (state, orders) => (state.orders = orders),
    setOrder: (state, order) => (state.order = order),
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
function getData(contentName, commit, data=null, method='GET') {
    let url = 'https://stuffonaut.com/pizza/';
    switch (contentName) {
      case 'foodTypes': url += 'getFoodTypes'; break;
      case 'restaurants': 
      case 'restaurant': url += 'getRestaurants'; break;
    }    
    var postData = null;
    if(data) { postData  = JSON.stringify(data); }
    let self = this;
    fetch(url+'.php', {
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
      console.log('Data found : ', data);
      switch (contentName) {
        case 'foodTypes': 
        console.log(' case foodTypes');
        data = [
          { "id":  1, "name": "Aasialainen" },
          { "id":  2, "name": "Falafel" },
          { "id":  3, "name": "Grillattua kanaa" },
          { "id":  4, "name": "Grilliruokaa" }
        ];
        console.log('foodTypes: ', data);
                          commit('setFoodTypes', data); break;
        case 'restaurants': commit('setRestaurants', data); break;
        case 'restaurant': commit('setRestaurant', data); break;
      }
    })
    .catch(error => { 
      console.error(error);
    });
}


