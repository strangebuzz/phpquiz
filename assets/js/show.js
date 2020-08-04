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
  el: '#layout', // main id of global layout (layout.html)
  delimiters: ['{', '}'], // because of Twig we don't take standard {{ }}
  data: {
    question: question, // question json object, comes from Sf
    hasValidated: false, // user has validated its answer?
    answer: null, // user answer (vue model)
  },
  computed: {
    /**
     * Is the user answer correct? Must be used only if hasValidated is true.
     */
    isCorrect: function () {
      return this.question.correctAnswerCode === this.answer
    }
  },
  methods: {
    /**
     * The user has click on the validate button.
     */
    validateAnswer() {
      this.hasValidated = true
    },
  },
})
