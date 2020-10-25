/* global questionId, code */
/* eslint-disable no-new */

// Js vendors ——————————————————————————————————————————————————————————————————
import Vue from 'vue'
import Clipboard from 'clipboard'
import Toastr from 'toastr'

// CSS vendors —————————————————————————————————————————————————————————————————
require('purecss/build/pure-min.css')
require('toastr/build/toastr.min.css')

// CSS custom ——————————————————————————————————————————————————————————————————
require('../css/side-menu.css')
require('../css/buttons.css')
require('../css/app.css')

new Vue({
  el: '#layout', // main id of global div (layout.html)
  delimiters: ['{', '}'], // because of Twig we don't take standard {{ }}
  data: {
    questionId: questionId, // Id of the current question (comes from the Sf javascript block)
    question: null, // question json object (see mounted).
    questionUrl: questionUrl, // URL to get the question object
    code: code, // raw PHP code of the question
    ready: false, // can the user answer the question? (question object must be available)
    hasValidated: false, // user has validated its answer?
    answer: null, // user answer (vue form model)
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
     * The user has clicked on the validate button. Force HTML5 validation.
     */
    validateAnswer() {
      if (!this.$refs.form.checkValidity()) {
        this.$refs.form.click()
      } else {
        this.hasValidated = true
      }
    },
    /**
     * Custom "text" function to copy the code without to display the textarea
     */
    initClipboard() {
      new Clipboard('.copy', {
        text: function() {
          const code = document.getElementById('code').value
          if (code !== '') {
            Toastr.info('Done! ✅')
          }

          return code
        }
      })
    },
    /**
     * @see loadQuestion
     */
    async fetchQuestion() {
      const response = await fetch(this.questionUrl)
      if (!response.ok) {
        const message = `Error : ${response.status}`;
        throw new Error(message);
      }

      return await response.json(); // return question JSON
    },
    loadQuestion() {
      self = this;
      this.fetchQuestion()
        .then(json => {
          self.question = json; // store the question
          self.ready = true // show the submit button
        })
        .catch(error => {
          alert('An error occured sorry: '+error)
        })
    }
  },
  mounted() {
    this.initClipboard()
    this.loadQuestion()
  }
})
