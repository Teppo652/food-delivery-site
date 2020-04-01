<template>
   <div>      
    <section class="section">
      <div class="container has-text-centered">

          <h2 class="title">{{ t.register_title }}</h2>
          
          <div class="columns is-centered">
            <div class="column is-5 is-3-desktop">
              <form>
                                      
                <!-- error message -->
                <div v-show="errorMsg != ''" class="notification is-danger">                
                  <strong>{{ errorMsg }}</strong>
                </div>

                    <!-- name 
                    <div v-show="!isAdmin" class="field">
                      <div class="control">
                        <label for="name">Name</label>
                        <input id="name"
                          type="text"
                          class="input" 
                          :disabled="!codeAccepted"
                          v-model="newUser.name"
                        />
                      </div>
                    </div>-->
                    
                    <!-- apartment number 
                    <div v-show="!isAdmin" class="field">
                      <div class="control">
                        <label for="aptNumber">Apartment number</label>
                        <input id="aptNumber"
                          type="text"
                          class="input" 
                          :disabled="!codeAccepted"
                          v-model="newUser.aptNumber"
                        />
                      </div>
                    </div>-->

                    <!-- email -->  
                    <div class="field">
                      <div class="control">
                        <label for="email">{{ t.email }}</label>
                        <input id="email"
                        type="email"
                        class="input"
                        :placeholder=t.email
                        name="email"
                        v-model="newUser.email"
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
                          :placeholder=t.pw
                          v-model="newUser.password"
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
                      <ul>{{ t.register_pwRules }}:
											<li>{{ t.pwRule1 }}</li>
											<li>{{ t.pwRule2 }}</li>
											<li>{{ t.pwRule3 }}</li>
											<li>{{ t.pwRule4 }}</li>
                      </ul>
                    </div>

                    <!-- passwordAgain 
                    <div class="field">
                      <p class="control has-addons">
                        <label for="passwordAgain">Password again</label>
                        <input id="passwordAgain"
                          type="password"
                          class="input"
                           placeholder="Password again"
                          v-model="passwordAgain"
                        />
                      </p>
                    </div>  -->
                    
                    <!-- remember
                    <div class="field">
                      <div class="control">
                        <label class="checkbox">
                        <input v-model="newUser.remember" type="checkbox">
                          Remember me
                        </label>
                      </div>
                    </div> --> 

                    <!-- register btn -->  
                    <div class="field">
                      <div class="control">
                        <button type="submit"
                          @click.prevent="formSubmitted" 
                          class="button is-primary is-fullwidth">{{ t.register_title }}</button>
                      </div>
                    </div>

                  <small>
                    <router-link class="has-text-centered" to="/Login">{{ t.register_goToLogin }}</router-link>
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
  name: "register",
  data() {
    return {
      userId: null,
      usersHouseId: null,
      isAdmin: false,
      newUser: {
        houseId: -1,
        isAdmin: 0,
        name: '', 
        email: null,
        password: null,
        remember: false,     
        aptNumber: ''
      },
      tr: null,
      passwordHelper: false,
      passwordAgain: '',
      userCreated: false,
      userCreatedInAuthSystem: false,
      userSaved: false,
      errorMsg: ''
    };
  },
  methods: {
    formSubmitted: function(e) {       
      if(this.newUser.remember == true) { this.newUser.remember = '1'; }
      this.newUser.email = this.newUser.email.trim();
      this.passwordAgain = this.passwordAgain.trim();
      this.newUser.password = this.newUser.password.trim();

      if(this.errorMsg == '') {
        if(emailIsValid(this.newUser.email)) {
          if(passwordIsValid(this.newUser.password)) {
            this.saveUser(this.newUser);   
          } else {
						//this.errorMsg = 'Please check password: It must have at least: one number, one lowercase and one uppercase letter and at least six characters';
						this.errorMsg = this.t.pwErrMsg;
          }
        } else {
					//this.errorMsg = 'Please check email';
					this.errorMsg = this.t.emailErrMsg;
        }
      }
    },
    ...mapActions(["getTranslations", "saveUser"])
  }, // end methods
	created(){	
    this.getTranslations('fi');
	},
  watch: {
    // after saveUser() code execution continues here
    user: function() {
      //handler() {
        if(this.user === undefined || this.user.length == 0) {
					//this.errorMsg = 'Please check your input data';
					this.errorMsg = this.t.register_checkYourInput;
        } else {
          // not in use yet
          if(this.user.id == 'userExists') {
						//this.errorMsg = 'Email exists already';
						this.errorMsg = this.t.register_emailExists;
          } else {
            // user save successful
            if(this.isAdmin != 1) {  this.user.houseId = this.house.id; }
            if(this.user.remember != '') {
              // save into local storage
              localStorage.setItem("remember", this.user.remember);
              console.log('saved to local storage: ', this.user.remember);
            }
            // forward to next 
            this.$router.push({ path: '/DeliveryDetails' });
          }
        }
      //} // handler      
    }, // user
    // reset error message after 5 seconds
    errorMsg:function() {
      var self = this;
      if(this.errorMsg != '') {
        setTimeout(function() {
            self.errorMsg = '';
        }, 5000);
      }
    }
  },                  
  created() {
  },
  computed: mapGetters(["t", "user"])
};
</script>