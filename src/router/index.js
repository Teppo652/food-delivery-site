import Vue from 'vue'
import VueRouter from 'vue-router'
import Listing from '../components/Listing.vue'
import Restaurant from '../components/Restaurant.vue'
import RegisterRestaurant from '@/components/RegisterRestaurant'
import Menu from '@/components/Menu'
import Orders from '@/components/Orders'
import Login from '@/components/Login'
import Register from '@/components/Register'

Vue.use(VueRouter)

const routes = [
	{
		path: '/',
		name: 'Menu',
		component: Menu
	},
	{
		path: '/Register',
		name: 'Register',
		component: Register
	},
	{
		path: '/Menu',
		name: 'Menu',
		component: Menu
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
		path: '/registerRestaurant',
		name: 'registerRestaurant',
		component: RegisterRestaurant
	}, /*
    {
      path: '/Listing',
      name: 'Listing',
      component: Listing
    }, */
	{
		path: '/orders',
		name: 'orders',
		component: Orders
	},
	{
		path: '/login',
		name: 'login',
		component: Login
	},
	{
		path: '/register',
		name: 'register',
		component: Register
	}
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
