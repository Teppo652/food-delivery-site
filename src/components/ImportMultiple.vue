<template>
  <div>

    <div class="field has-addons is-fullWidth" style="clear:left">
			<p class="control has-icons-right wide">
				<textarea v-model="items"
						style="z-index:0"						
						class="input wide"
            :placeholder = placeholderText
            type="text"
				></textarea> 
        <!-- :class="charsLeft(2000, items)[0] ? 'exceedTextLength' : ''" -->
        <!--
				<span class="is-right">												
					<span style="margin-top:1px" class="textLimiter is-pulled-right is-size-7" 
							:class="charsLeft(2000, items)[0] 
							? 'has-text-danger' 
							: ''">{{ charsLeft(2000, items)[1] }}</span> 
				</span> -->
			</p>
			<button @click.prevent="addItems" class="button is-primary">Add</button>
		</div>  
  </div>
</template>

<script>
export default {
  name: 'ImportMultiple',
	data () {
		return {      
      items: null
		}
	},
  props: {
    placeholderText: String    
  },
  methods: {
    addItems () {
      this.$emit('add', this.items);
      this.items = null;
    }    
  }
}
</script>

<style scoped>
button {
  border-bottom-left-radius: 0;
  border-top-left-radius: 0;
  transition-delay: .15s;
}
</style>