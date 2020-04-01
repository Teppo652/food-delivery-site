<template>
  <span>
    <a @click.prevent="" 
        :data-tooltip=toolTip
		    class="">
			<span class="icon">
				<!--<i class="fa fa-question-circle fa-2x" aria-hidden="true"></i>-->
        <i class="fa fa-info-circle fa-2x" aria-hidden="true"></i>
			</span>											
		</a>
  </span>
</template>

<script>
export default {
  name: 'ToolTip',
  props: {
    toolTip: String
  }
}
</script>

<style scoped>
 /* ----------------- Tooltip Styles ----------------- */
[data-tooltip] {
  position: relative;
  z-index: 2;
  cursor: pointer;
}
/* Hide the tooltip content by default */
[data-tooltip]:before,
[data-tooltip]:after {
  visibility: hidden;
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
  filter: progid: DXImageTransform.Microsoft.Alpha(Opacity=0);
  opacity: 0;
  pointer-events: none;
}

/* Position tooltip above the element */
[data-tooltip]:before {
  position: absolute;
  bottom: 150%;
  left: 50%;
  margin-bottom: 12px;
  margin-left: -80px;
  padding: 12px 7px;
  width: 160px;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
  background-color: #000;
  background-color: hsla(0, 0%, 20%, 0.9);
  color: #fff;
  content: attr(data-tooltip);
  text-align: center;
  font-size: 15px;
  line-height: 1.2;
  /* handle multiline long text */
  max-width: 15rem;
  text-overflow: clip;
  white-space: normal;
  word-break: keep-all;
}

/* Triangle hack to make tooltip look like a speech bubble */
[data-tooltip]:after {
  position: absolute;
  bottom: 150%;
  left: 50%;
  margin-left: -5px;
  width: 0;
  border-top: 5px solid #000;
  border-top: 5px solid hsla(0, 0%, 20%, 0.9);
  border-right: 5px solid transparent;
  border-left: 5px solid transparent;
  content: " ";
  font-size: 0;
  line-height: 0;
  margin-bottom: 7px;
}

/* Show tooltip content on hover */
[data-tooltip]:hover:before,
[data-tooltip]:hover:after {
  visibility: visible;
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
  filter: progid: DXImageTransform.Microsoft.Alpha(Opacity=100);
  opacity: 1;
}
a {
  color: #dbdbdb;
}
.fa-2x {
    font-size: 1.5em;
}
</style>