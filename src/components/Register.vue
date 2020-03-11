<template>
	<div>
		<div class="container is-fluid">
			<section class="section">
        <div class="columns is-centered">
          <div class="column is-5 is-3-desktop">

				    <h1>Register</h1>

				    <!-- error messages -->
            <article v-show="typeof errors !== 'undefined' && errors.length > 0"
                class="message is-danger">
              <div class="message-header">Please check</div>
              <ul class="message-body errors">
                  <li v-for="(err, index) in errors" :key="index">{{ err }}</li>
              </ul>
            </article>

            <!-- name -->
            <div class="control">
              <label for="name">Name</label>
              <input id="name"
                    type="text"
                    class="input"
                    v-model="user.name"
				  	        :class="charsLeft(50, user.name)[0] ? 'exceedTextLength' : ''"
				      />
				      <span class="is-right">												
				      	<span class="textLimiter is-pulled-right is-size-7" 
				      			:class="charsLeft(50, user.name)[0] ? 'has-text-danger' 
				      			: ''">{{ charsLeft(50, user.name)[1] }}
				      	</span> 
				      </span>
            </div>

				    <!-- address -->
            <div class="control">
              <label for="address">Street address</label>
              <input id="address"
                      type="text"
                      class="input"
                      v-model="user.address"
				  	 :class="charsLeft(50, user.address)[0] ? 'exceedTextLength' : ''"
				      />
				      <span class="is-right">												
				      	<span class="textLimiter is-pulled-right is-size-7" 
				      			:class="charsLeft(50, user.address)[0] ? 'has-text-danger' 
				      			: ''">{{ charsLeft(50, user.address)[1] }}
				      	</span> 
				      </span>
            </div>

				    <!-- city -->
            <div class="control">
              <label for="city">City</label>
              <input id="city"
                type="text"
                class="input"
                v-model="user.city"
				  	    :class="charsLeft(50, user.city)[0] ? 'exceedTextLength' : ''"
				      />
				      <span class="is-right">												
				      	<span class="textLimiter is-pulled-right is-size-7" 
				      			:class="charsLeft(50, user.city)[0] ? 'has-text-danger' 
				      			: ''">{{ charsLeft(50, user.city)[1] }}
				      	</span> 
				      </span>
            </div>

            <!-- phone -->
            <div class="control">
              <label for="phone">Phone</label>
              <input id="phone"
                    type="text"
                    class="input"
                    v-model="user.phone"
				  	        :class="charsLeft(20, user.phone)[0] ? 'exceedTextLength' : ''"
				      />
				      <span class="is-right">												
				      	<span class="textLimiter is-pulled-right is-size-7" 
				      			:class="charsLeft(20, user.phone)[0] ? 'has-text-danger' 
				      			: ''">{{ charsLeft(20, user.phone)[1] }}
				      	</span> 
				      </span>
            </div>

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
            <div class="field">
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
                <ul>Password must include at least:
                  <li>One number</li>
                  <li>One lowercase letter</li>
                  <li>One uppercase letter</li>
                  <li>Six characters long</li>
                </ul>
              </div>

              <!-- passwordAgain -->
				      <p class="control has-addons">
                <label for="passwordAgain">Password again</label>
                <input id="passwordAgain"
                        type="password"
                        class="input"
                        v-model="passwordAgain"
				  	            :class="charsLeft(50, passwordAgain)[0] ? 'exceedTextLength' : ''"
				        />
				        <span class="is-right">												
				        	<span class="textLimiter is-pulled-right is-size-7" 
				        			:class="charsLeft(50, passwordAgain)[0] ? 'has-text-danger' 
				        			: ''">{{ charsLeft(50, passwordAgain)[1] }}
				        	</span> 
				        </span>                
              </p>
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

            <!-- terms  -->
            <div class="field">
              <div class="control">
                <label class="checkbox">
                <input v-model="terms" type="checkbox">
                  I accept <a href="#">site terms</a>
                </label>
              </div>
            </div>

            <!-- register btn -->  
            <div class="field">
              <div class="control">
                <button type="submit"
                  @click.prevent="register" 
                  class="button is-primary is-fullwidth">Register</button>
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
	name: 'Register',
	data () {
		return {
      user: {
        name: 'John Doe', //null,
        email: 'test2@test.com', //null,        
        phone: '1234567890', //null,
        password: '123qweQWE', //null
        address: 'Test street 1', //null
        city: 'Test city' //null
      },
      remember: false,
      terms: false,
			passwordHelper: false,
      passwordAgain:  '123qweQWE', //null
      errors: []
		}
	},
	methods: {
		register: function() {
      this.errors = [];
      if(this.user.name == null)  { this.errors.push('Name'); }
      if(this.user.email == null)  { this.errors.push('Email'); }
      if(this.user.phone == null)  { this.errors.push('Phone number'); }
      if(!phoneIsValid(this.user.phone)) { this.errors.push('Phone number'); }
      if(!emailIsValid(this.user.email)) { this.errors.push('Email'); }
      if(!passwordIsValid(this.user.password)) { this.errors.push('Password'); }
      if(this.user.password == null) { this.errors.push('Password'); }
      if(this.passwordAgain == null) { this.errors.push('Password again'); } 
      if(this.user.address == null)  { this.errors.push('Address'); }
      if(this.user.city == null)  { this.errors.push('City'); }
      if(this.terms == false)  { this.errors.push('You must accept site terms to use the web site'); }      
      if(this.user.password !== this.passwordAgain) { this.errors.push('Passwords must match'); }      
      console.log('this.errors:', this.errors);
      if(this.errors.length == 0) {
        this.user.name = clean(this.user.name.trim());
        this.user.email = clean(this.user.email.trim());
        this.user.phone = clean(this.user.phone.trim());
        this.user.password = clean(this.user.password.trim());
        this.user.address = clean(this.user.address.trim());
        this.user.city = clean(this.user.city.trim());



        /*
        if(phoneIsValid(this.user.phone)) {
          if(emailIsValid(this.user.email)) {
              console.log('Email is valid');
              if(passwordIsValid(this.user.password)) {
                  console.log('Password is valid');                
                  //this.apiCall('register', this.user); // register
                  //this.saveUser(this.user);
              } else {
                  this.errors.push('Please check password: It must have at least: one number, one lowercase and one uppercase letter and at least six characters');
              }
          } else {
              this.errors.push('Please check email');
          }
        } else {
          this.errors.push('Please check phone number');
        } */
      }
		},
		...mapActions(["saveUser"]),
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
