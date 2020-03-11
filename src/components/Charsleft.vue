<template>
  <div> <!-- placeholder=placeholderStr -->
  <!--
    <input class="input wide" type="text" 
    v-on:change="onLenChange($event.target.value)"
		style="z-index:0"
    :class="charsLeft(max)[0] ? 'exceedTextLength' : ''"
		>		
    <span class="is-right">												
			<span class="textLimiter is-pulled-right is-size-7" 
					:class="calculateCharsLeft(max)[0] 
					? 'has-text-danger' 
					: ''">{{ calculateCharsLeft(max)[1] }}
      </span> 
		</span>-->



      <input class="input wide" type="text" 
        v-on:change="onLenChange($event.target.value)"
		    style="z-index:0"    
		  >		
			<span class="is-right">												
				<span class="textLimiter is-pulled-right is-size-7" 
						:class="calculateCharsLeft(max)[0] 
						? 'has-text-danger' 
						: ''">{{ calculateCharsLeft(max)[1] }}</span> 
			</span>





      <!--
			<span class="is-right">												
				<span class="textLimiter is-pulled-right is-size-7" 
						:class="calculateCharsLeft(max)[0] 
						? 'has-text-danger' 
						: ''">{{ calculateCharsLeft(max)[1] }}</span> 
			</span>-->

  </div>
</template>

<script>
export default {
  name: 'Charsleft',
  props: {
    max: Number,
    // placeholderStr: String,
    data: String
  },
  methods: {
    calculateCharsLeft(max) {
			return [ this.data.length > max ? true : false,
			this.data.length > max/2 ? max - this.data.length + "/" + max : ''];
    }, 
    onLenChange (str) {
      this.$emit('lenChanged', '***'+str)
    }    
      
  }
}
</script>