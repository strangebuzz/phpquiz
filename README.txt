
————————————————————————————————————————————————————————————————————————————————
            = phpquiz.xyz, are you a real PHP professional? 🐘
————————————————————————————————————————————————————————————————————————————————

@Bugs
————————————————————————————————————————————————————————————————————————————————

* Joins OK in the show action, query count seems weird? To verify.
* Can't set the admin password! Symfony binary bug?


@Todo
————————————————————————————————————————————————————————————————————————————————

* Add quiz menu entry
* Add fixtures for the quiz mode
* Add tests for the quiz mode


@Quiz ideas
————————————————————————————————————————————————————————————————————————————————

* Next: https://twitter.com/FredBouchery/status/1304314751628070912
* https://twitter.com/dkarlovi/status/1295312397780037632


@Ideas/To decide
————————————————————————————————————————————————————————————————————————————————

* OK to use the carbon Twitter image or host it? (
* Mailing list to notify when a new quiz is out?
* Or create a simple RSS ?


@Nice to have
————————————————————————————————————————————————————————————————————————————————

* Allow to choose the number of questions to pass?


@Infra
————————————————————————————————————————————————————————————————————————————————

* Deploy on bref.sh?
* Deploy on SensioCloud, ask for a free account if possible? As it is an open-source
  project.


@Refactoring/cleanup
————————————————————————————————————————————————————————————————————————————————


@Social/Twitter
————————————————————————————————————————————————————————————————————————————————

* https://cards-dev.twitter.com/validator


@References
————————————————————————————————————————————————————————————————————————————————

* https://twitter.com/FredBouchery


@Ressources
————————————————————————————————————————————————————————————————————————————————

* https://docs.moodle.org/dev/Quiz_database_structure
* https://codeseven.github.io/toastr/
* https://clipboardjs.com/
* https://twig.symfony.com/doc/2.x/functions/block.html
* https://schema.org
* https://carbon.now.sh
* About the .xyz TLD: https://en.wikipedia.org/wiki/.xyz


@Tweets
————————————————————————————————————————————————————————————————————————————————


@SEO
————————————————————————————————————————————————————————————————————————————————


@Design/CSS
————————————————————————————————————————————————————————————————————————————————

* https://purecss.io/
* https://favicon.io/emoji-favicons/elephant/


@Webperfs
————————————————————————————————————————————————————————————————————————————————


@Debug
————————————————————————————————————————————————————————————————————————————————

* //dump($question, $question->getSuggestedBy(), $question->getPreviousQuestion(), $question->getNextQuestion(), $question->getAnswers());
* const question = {{ question|serialize(block('jsapp') )|raw }};
