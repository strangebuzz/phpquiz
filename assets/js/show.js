/* global question */
/* eslint-disable no-new */

// Js vendors ——————————————————————————————————————————————————————————————————
import Vue from 'vue'

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
    hasValided: false, // user has validated its answer?
    answer: null, // user answer (vue model)
  },
  methods: {
    validate () {
      if (this.answer === question.correctAnswerCode) {
        console.log('Correct answer, congratulations !')
      } else {
        console.log('Wrong answer sorry.')
      }
    },
  },
})
