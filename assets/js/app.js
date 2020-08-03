/* global question */
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
    question: question, // question object
    hasAnswered: false, // has the user answered the current question?
    answer: null, // user answer
  },
  methods: {
    validate () {
      console.log(this.answer)
    },
  },
  mounted () {
  }
})
