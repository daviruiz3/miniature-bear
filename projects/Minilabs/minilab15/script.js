// scripts.js
// handle dropdown nav using JS

$('nav select').change(function() {
   window.location = this.value;
});