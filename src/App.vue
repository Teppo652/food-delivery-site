<template>
  <div id="app">
    <div class="container is-fluid">
                
      <nav class="navbar">
        <div class="container">
          <div class="navbar-brand">
            <!-- logo 
            <img src="./assets/washing-machine.svg" />
            <router-link id="logo" class="navbar-item"  to="/">Laundrier</router-link>
            -->

            <!--
            <a class="navbar-burger" role="button" aria-label="menu" aria-expanded="false"><span aria-hidden="true"></span><span aria-hidden="true"></span><span aria-hidden="true"></span></a>
            -->
            <span class="navbar-burger burger" data-target="navMenu">
              <span></span>
              <span></span>
              <span></span>
            </span>
          </div>
          <div class="navbar-menu">
            <div class="navbar-start">
              <!-- change language
              <div class="navbar-item has-dropdown is-hoverable"><a class="navbar-link">Language</a>
                <div class="navbar-dropdown">
                  <a class="navbar-item navbar-item-dropdown" href="#">English</a>
                <a class="navbar-item navbar-item-dropdown" href="#">Swedish</a></div>
              </div>
              -->
            </div>
            <div class="navbar-end">
              <!-- orig from laundrier: 
              <router-link class="navbar-item"  to="/booking">My bookings</router-link>               
              <router-link class="navbar-item"  to="/Help">How does it work</router-link>
              <div class="navbar-item">                                               
                <small v-if="!rememberEnded && user.remember"><a @click.prevent="endRemember">Forget me on this device</a></small>
                <small v-if="rememberEnded && user.remember">{{ rememberEnded }}</small>
                <p v-show="user.email" class="loginEmail">Logged in as<br>{{ user.email }}</p>
                <div class="buttons">                  
                  <a v-show="user.email" class="button is-light" href="#" @click.prevent="logout()">Log out</a>
                  <router-link v-show="!user.email" class="button is-light" to="/Register">Register</router-link>
                  <router-link v-show="!user.email" class="button is-light" to="/Login">Login</router-link>
                </div>                
              </div>
              -->
              <router-link class="navbar-item" to="/">Home</router-link>
              <router-link class="navbar-item" to="/Listing\">Listing</router-link>
              <router-link class="navbar-item" to="/Restaurant\">Restaurant</router-link>
              <router-link class="navbar-item" to="/RegisterRestaurant\">Register restaurant</router-link>
              <router-link class="navbar-item" to="/Menu\">Menu</router-link>
              <router-link class="navbar-item" to="/Orders\">Orders</router-link>
              <router-link class="navbar-item" to="/Login\">Login</router-link>
              <router-link class="navbar-item" to="/Register\">Register</router-link>
            </div>
          </div>
        </div>
      </nav>
    </div>
    <router-view/>
    <footer>
      Icons made by <a href="https://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a>
    </footer>
    <!-- loader 
    <div class="loader-wrapper">
      <div class="loader is-loading"></div>
    </div>-->
  </div>
</template>

<style>

#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  /*background-color: #fff7f0; */
}
/*
#nav {
  padding: 30px;
  background-color: #fff1e5;
}
.navbar.is-light {
    background-color: #fff1e5 !important;
}

#nav a {
  font-weight: bold;
  color: #2c3e50;
}

#nav a.router-link-exact-active {
  color: #42b983;
}

#logo {
  font-family: 'Baloo', cursive;
  font-size: 2.4rem;
  color: #dc7115;
}
#slogan {
    color: #9a745c;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 1.4px;
    font-size: xx-small;
    text-align: left;
    margin-top: 5px;
}
*/
/* icon 
.seat {
  background: url(./public/seat.svg) no-repeat top left;
  background-size: contain;
}*/

.textLimiter {
  margin: -1px 4px;
  z-index: 99999;
  position: relative;
  color: #c5c5c5;
}

.moreInfo {
    float: right;
    margin: -37px 4px 0 0;
    border: none;
    padding: 0 !important;
    width: 34px;
    height: 34px !important;
}
.notification {
    margin-top: 8px;
}
.notification ul {
  list-style: square;
  font-size: 15px;
  font-weight: 600;  
  padding: 7px;
}
.notification ul li {
  text-align: left !important;
  font-weight: 100;
}
.message.is-danger .message-body {
  list-style-type: square;
  text-align: left;
  font-size: 14px;
  padding: 25px;
}
.message-header span {
  float: left;
}/*
.errIcon {
	background-image: url("./assets/cancel.svg");
	width: 18px;
  height: 18px;
  background-repeat: no-repeat;
  position: relative;
	opacity: .9;
}*/
footer {
    -webkit-box-flex: 1;
    -ms-flex-positive: 1;
    flex-grow: 1;
    position: fixed;
    bottom: 0;
    width: 100%;
    color: #6392dd;
    opacity: 1;
    font-size: .8rem;
}
.noSelect {
  -webkit-touch-callout: none; /* iOS Safari */
    -webkit-user-select: none; /* Safari */
     -khtml-user-select: none; /* Konqueror HTML */
       -moz-user-select: none; /* Old versions of Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
            user-select: none; /* Non-prefixed version, currently
                                  supported by Chrome, Opera and Firefox */
}

</style>
