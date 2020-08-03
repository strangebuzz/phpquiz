/* global require, isProd */
/* eslint-disable no-new */

// Js vendors ——————————————————————————————————————————————————————————————————
import Vue from 'vue'

// App / Vue ———————————————————————————————————————————————————————————————————

// CSS vendors —————————————————————————————————————————————————————————————————
require('purecss/build/pure-min.css')

// CSS custom ——————————————————————————————————————————————————————————————————
require('../css/side-menu.css')
require('../css/buttons.css')
require('../css/app.css')

new Vue({
  el: '#layout',
  delimiters: ['{', '}'], // because of Twig we don't take standard {{ }}
  data: {
    isProd: isProd,
  },
  methods: {
    selectAnswer (code) {
      // console.log(document.getElementById('answer_'+code))
    },
  },
  mounted () {
    console.log('monted OK, isProd:'+isProd)
  }
})
