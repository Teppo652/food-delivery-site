import Vue from 'vue'
import VueRouter from 'vue-router'
import SelectCity from '@/components/SelectCity'
import Main from '@/components/Main'
import DefineDeliveryArea from '@/components/DefineDeliveryArea'
import Listing from '@/components/Listing.vue'
import Restaurant from '@/components/Restaurant.vue'
import RegisterRestaurant from '@/components/RegisterRestaurant'
import Menu from '@/components/Menu'
import Orders from '@/components/Orders'
import Login from '@/components/Login'
import Register from '@/components/Register'
import DeliveryDetails from '@/components/DeliveryDetails'

Vue.use(VueRouter)


let router = new VueRouter({
  /*mode: 'history',
  base: process.env.BASE_URL, */
  routes: [
  {
    path: '/', // path: '/:lang',
    name: 'Main', //  { path: '/user/:id', component: User } /user/:id', co
    component: Main
	},	
	{
		path: '/Main',
		name: 'Main',
		component: Main
	},
	{
		path: '/Listing',
		name: 'Listing',
		component: Listing
	},
	{
		path: '/Restaurant/:Pid',
		name: 'Restaurant',
		component: Restaurant
	},
	{
		path: '/DeliveryDetails',
		name: 'DeliveryDetails',
		component: Orders
	},
	{
		path: '/Login',
		name: 'Login',
		component: Login
	},
	{
		path: '/Register',
		name: 'Register',
		component: Register
	},
	{
		path: '/RegisterRestaurant',
		name: 'RegisterRestaurant',
		component: RegisterRestaurant
	},
	{
		path: '/Menu',
		name: 'Menu',
		component: Menu
	},
	{
		path: '/Orders',
		name: 'Orders',
		component: Orders
	},
]
});
	
var IS_LOGGED_IN = true; // ------------------ TEMP ------------------------

// Nav Guard 
router.beforeEach((to, from, next) => {
  // Check for requiresAuth guard
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // Check if NO logged user
    if (IS_LOGGED_IN) {
      // Go to login
      next({
        path: '/Login',
        query: {
          redirect: to.fullPath
        }
      }), () => {}; // catches promise rejection
    } else {
      next(), () => {};
    }
  } else if (to.matched.some(record => record.meta.requiresGuest)) {
    // Check if NO logged user
    if (IS_LOGGED_IN) {
      // Go to login
      next({
        path: '/',
        query: {
          redirect: to.fullPath
        }
      }), () => {}; 
    } else {
      next(), () => {};
    }
  } else {
    next(), () => {}; 
  }
});



/*OLD1
const router = new VueRouter({
  routes: [
    { path: '/', component: DeliveryDetails },
    { path: '/Login', component: Login },
    { path: '/Restaurant', component: Restaurant } 
  ]
})


OLD2
//const routes = [
let router = new VueRouter({
  routes: [
	{
		path: '/',
    //name: 'Menu',
		//component: Menu
		name: 'Listing',
    component: Listing
    //name: 'RegisterRestaurant',
		//component: RegisterRestaurant
	},
	{
		path: '/Restaurant',
		name: 'Restaurant',
		component: Restaurant
	},
	{
		path: '/Listing',
		name: 'Listing',
		component: Listing
	},
	{
		path: '/Orders',
		name: 'Orders',
		component: Orders
	},
	{
		path: '/DeliveryDetails',
		name: 'DeliveryDetails',
		component: Orders
	},
	{
		path: '/Login',
		name: 'Login',
		component: Login
	},
	{
		path: '/Register',
		name: 'Register',
		component: Register
	},
	{
		path: '/RegisterRestaurant',
		name: 'RegisterRestaurant',
		component: RegisterRestaurant
	},
	{
		path: '/Menu',
		name: 'Menu',
		component: Menu
	},
]
});
*/
//]
/* const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
}) */

/*
// Nav Guard 
router.beforeEach((to, from, next) => {
  // Check for requiresAuth guard
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // Check if NO logged user
    if (IS_LOGGED_IN) {
      // Go to login
      next({
        path: '/Login',
        query: {
          redirect: to.fullPath
        }
      }), () => {}; // catches promise rejection
    } else {
      next(), () => {};
    }
  } else if (to.matched.some(record => record.meta.requiresGuest)) {
    // Check if NO logged user
    if (IS_LOGGED_IN) {
      // Go to login
      next({
        path: '/',
        query: {
          redirect: to.fullPath
        }
      }), () => {}; 
    } else {
      next(), () => {};
    }
  } else {
    next(), () => {}; 
  }
});
*/
export default router
