<template>
	<div>
		<div class="container is-fluid">
			<section class="section">
        <div class="columns is-centered">
          <div class="column is-5 is-3-desktop">

				    <h1>Login</h1>

				    <!-- error messages -->
            <article v-show="typeof errors !== 'undefined' && errors.length > 0"
                class="message is-danger">
              <div class="message-header">Please check</div>
              <ul class="message-body errors">
                  <li v-for="(err, index) in errors" :key="index">{{ err }}</li>
              </ul>
            </article>

            <!-- email -->  
            <div class="field">
              <div class="control">
                <label for="email">Email</label>
                <input id="email"
                      type="email"
                      class="input"
                      name="email"
                      v-model="user.email"
				  	          :class="charsLeft(50, user.email)[0] ? 'exceedTextLength' : ''"
                />
				        <span class="is-right">												
				        	<span class="textLimiter is-pulled-right is-size-7" 
				        			:class="charsLeft(50, user.email)[0] ? 'has-text-danger' 
				        			: ''">{{ charsLeft(50, user.email)[1] }}
				        	</span> 
				        </span>
              </div>
            </div>            
  
            <!-- password -->  
              <p class="control has-addons">
                <label for="password">Password</label>
                <input id="password"
                        type="password"
                        class="input"
                        placeholder="Password"
                        v-model="user.password"
				  	            :class="charsLeft(50, user.password)[0] ? 'exceedTextLength' : ''"
				        />
				        <span class="is-right">												
				        	<span class="textLimiter is-pulled-right is-size-7" 
				        			:class="charsLeft(50, user.password)[0] ? 'has-text-danger' 
				        			: ''">{{ charsLeft(50, user.password)[1] }}
				        	</span> 
				        </span>                
              </p>
              <button @click.prevent="passwordHelper ? passwordHelper = false : passwordHelper = true"
                  class="button moreInfo">
                <span class="icon is-primary">
                  <i class="fas fa-info-circle"></i>
                </span>
              </button>

				      <!-- password help text -->
              <div v-if="passwordHelper" class="notification is-link">
                <button class="delete" @click.prevent="passwordHelper = false"></button> 
                <ul>Password has at least:
                  <li>One number</li>
                  <li>One lowercase letter</li>
                  <li>One uppercase letter</li>
                  <li>Six characters long</li>
                </ul>
              </div>

            <!-- remember  -->
            <div class="field">
              <div class="control">
                <label class="checkbox">
                <input v-model="remember" type="checkbox">
                  Remember me on this device
                </label>
              </div>
            </div>

            <!-- login btn -->  
            <div class="field">
              <div class="control">
                <button type="submit"
                  @click.prevent="login" 
                  class="button is-primary is-fullwidth">Login</button>
              </div>
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
	name: 'Login',
	data () {
		return {
      user: {
        email: 'test2@test.com', //null,
        password: '123qweQWE', //null
      },
      remember: false,
			passwordHelper: false,
      errors: []
		}
	},
	methods: {
		login: function() {
      this.errors = [];
      if(this.user.email == null)  { this.errors.push('Email'); }
      if(!emailIsValid(this.user.email)) { this.errors.push('Email'); }
      if(!passwordIsValid(this.user.password)) { this.errors.push('Password'); }
      if(this.user.password == null) { this.errors.push('Password'); }
      console.log('this.errors:', this.errors);
      if(this.errors.length == 0) {
        this.user.email = clean(this.user.email.trim());
        this.user.password = clean(this.user.password.trim());

        /*            
                  //this.apiCall('register', this.user); // register
									//this.saveUser(this.user);
				*/
      }
		},
		...mapActions(["getUser"]),
		// calculates number of characters left, returns array: [is limit exceeded, characters left / max]
		charsLeft(maxLen, str) {
			return [ str.length > maxLen ? true : false,
			str.length>maxLen/2 ? maxLen - str.length + " / " + maxLen : ''];
		},
    // reset error message after 5 seconds
    errorMsg:function() {
      var self = this;
      if(this.errorMsg != '') {
        setTimeout(function() {
            self.errorMsg = '';
        }, 5000);
      }
    },
		forwardToNextPage() {
			// this.$router.replace({name: 'xxxxxxx'});
		}
	},
	created: function () {
		
	},
	watch: {
		xxxxx: function() {

		}
	},
	computed: mapGetters(["XXXuser"])
}
</script>

<style scoped>
</style>
