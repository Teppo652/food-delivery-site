<template>
    <div>      
      <section class="section">
        <div class="container has-text-centered">
						{{ t }}
          <h2 class="title">{{ t.login_title }}</h2>

          <div class="columns is-centered">
            <div class="column is-5 is-3-desktop">              
              <form>
                <!-- error 
                <div v-if="error" class="alert alert-danger">{{error}}</div> -->

                <!-- error msg  
                <div v-show="errorMsg" class="field">
                  <div class="control">
                      <div class="notification is-danger">
                        {{errorMsg}}
                      </div>
                  </div>
                </div> -->

                <!-- email -->  
                <div class="field">
                  <div class="control">
                    <label for="email">{{ t.email }}</label>
                    <input id="email"
                    type="email"
                    class="input" 
                    name="email"
                    value="test@test.com"
                    required
                    autofocus
                    :placeholder=t.email
                    v-model="lUser.email"
                  />
                  </div>
                </div>
                
                <!-- password -->  
                <div class="field">
                  <p class="control has-addons">
                    <label for="password">{{ t.pw }}</label>
                    <input id="password"
                      type="password"
                      class="input"
                       :placeholder= t.pw
                      v-model="lUser.password"
                    />
                  </p>
                  <button @click.prevent="passwordHelper ? passwordHelper = false : passwordHelper = true" 
                      class="button moreInfo">
                    <span class="icon is-primary">
                      <i class="fas fa-info-circle"></i>
                    </span>
                  </button>
                </div>
                <div v-if="passwordHelper" class="notification is-link">
                  <button class="delete" @click.prevent="passwordHelper = false"></button> 
                  <ul>{{ t.login_pwRules }}:
										<li>{{ t.pwRule1 }}</li>
										<li>{{ t.pwRule2 }}</li>
										<li>{{ t.pwRule3 }}</li>
										<li>{{ t.pwRule4 }}</li>
                  </ul>
                </div>

                <!-- remember user on this machine 
                <div class="field">
                  <div class="control">
                    <label class="checkbox">
                    <input v-model="lUser.remember" type="checkbox">
                      Remember me
                    </label>
                  </div>
                </div> --> 

                <!-- login btn -->  
                <div class="field">
                  <div class="control">
                    <button 
                        class="button is-primary is-fullwidth"
                        @click.prevent="login()">{{ t.login_title }}</button>
                  </div>
                </div>

                <small>
                  <router-link class="has-text-centered" to="/Register">{{ t.login_goToRegister }}</router-link>
                </small>

              </form>

            </div>
          </div>

        </div>
      </section>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex"
export default {
  name: "login",
        data() {
            return {
              lUser: {
                email: '',
                password: '',
                remember: false
              },
              errorMsg: null,
              passwordHelper: false
            }
        },
        methods: {
          login() {
            console.log('Login this.errorMsg:', this.errorMsg);
            console.log('Login this.lUser:', this.lUser);
            this.lUser.email = this.lUser.email.trim();
            this.lUser.password = this.lUser.password.trim();
            if(emailIsValid(this.lUser.email)) {
              if(passwordIsValid(this.lUser.password)) {
								if(this.lUser.remember == true) { this.lUser.remember = '1'; }
								let data = { "email": this.lUser.email, "password": this.lUser.password, "remember": this.lUser.remember ? '1' : '0' };
                this.getUser(data);
                console.log('Login this.user:', this.lUser);
              } else {
								//this.errorMsg = 'Please check password: It must have at least: one number, one lowercase and one uppercase letter and at least six characters';
								this.errorMsg = this.t.pwErrMsg;								
              }
            } else {
							//this.errorMsg = 'Please check email'; 
							this.errorMsg = this.t.emailErrMsg;
            }
          },
          ...mapActions(["getTranslations", "getUser"])
        }, // end methods
        watch: {
          // after loginUser() code execution continues here
          user: function() {
            console.log('user watch - this.user:', this.user);
            if (this.user === undefined || this.user.length == 0) { 
							// this.errorMsg = 'User not found with this email and password';
							this.errorMsg = t.login_noUserFound;
            } else {
              console.log('user found - this.user:', this.user);
               // if user checked remember, getUser() returned encrypted userId (remember)
               if (this.user.remember != '') {
                // save in local storage
                localStorage.setItem("remember", this.user.remember); 
                console.log('saved to local storage');
							}
							// get users postal code
              // this.$router.replace({name: 'Listing'});
            }
          },
					// after getHouseData() code execution continues here
					/*
          house() {          
            console.log('house watch - this.house:', this.house);
            // if (this.house.length>0) {
            if (this.house === undefined || this.house.length == 0) {
              this.errorMsg = 'Oh no! - The Laundry room you are registered to could not be found, please contact your house management.';
              console.log('no house found');
            } else {
            // house was found with registration code
            console.log('house found');
            this.isAdmin = false;
            this.codeAccepted = true;
            this.$router.replace({name: 'booking'});
            } 
					},
					*/

          // reset error message after 5 seconds
          /*
          errorMsg: function() {
            var self = this;
            if(this.errorMsg != '') {
              setTimeout(function() {
                  self.errorMsg = '';
              }, 5000);
            }
          }
          */
        },               
        created(){		
  		  //this.changeLang('en');	
    		this.getTranslations('fi');
	
          // try read userId from local storage
          /*
          let userId = localStorage.getItem("remember");
          if(userId) {
            console.log('Logging in using userId found in localStorage:', userId);
            this.lUser.id = parseInt(userId);
            this.loginUser(this.lUser); // if local storage string found - redirect to booking
          }
          */
        },
        computed: mapGetters(["t", "user"])      
};
</script>

<style scoped>


</style>