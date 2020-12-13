
————————————————————————————————————————————————————————————————————————————————
            🐘 phpquiz.xyz, are you a real PHP professional? 🐘
————————————————————————————————————————————————————————————————————————————————

@Bugs
————————————————————————————————————————————————————————————————————————————————

* Joins OK in the show action, query count seems weird? To verify.


@Todo
————————————————————————————————————————————————————————————————————————————————

* See to add scrutinizer.yml
  > example: https://github.com/scheb/2fa/blob/5.x/.scrutinizer.yml
* Add PHP versions the quiz is related too. Show in the question header.


@Tests
————————————————————————————————————————————————————————————————————————————————

* Add code coverage


@Refactoring/cleanup
————————————————————————————————————————————————————————————————————————————————

* Migration Doctrine 3


@Quiz ideas
————————————————————————————————————————————————————————————————————————————————

* Next quiz to enter:
- [16/11/2020] https://twitter.com/FredBouchery/status/1329330579146465280
- Typical commit to add a quiz: https://github.com/strangebuzz/phpquiz/commit/43921de379f4642364ab7f5d9be524ab14cd17a2


@Ideas/To decide
————————————————————————————————————————————————————————————————————————————————

* Store image filename with question id or twitter random string?
* OK to use the carbon Twitter image or host it? (seems better for share)
* Mailing list to notify when a new quiz is out?
* Or create a simple RSS?


@Nice to have
————————————————————————————————————————————————————————————————————————————————

* Allow to choose the number of questions to pass (when more than 50)


@Infra
————————————————————————————————————————————————————————————————————————————————

* Deploy on bref.sh?
* Deploy on SensioCloud, ask for a free account if possible? As it is an open-source
  project.


@Social/Twitter
————————————————————————————————————————————————————————————————————————————————

* https://cards-dev.twitter.com/validator


@References
————————————————————————————————————————————————————————————————————————————————

* https://github.com/strangebuzz/phpquiz/commit/44b83215de64b28db32e7cd353b2307d45bd7271
* https://twitter.com/FredBouchery


@Ressources
————————————————————————————————————————————————————————————————————————————————

* https://symfony.com/doc/master/bundles/EasyAdminBundle/actions.html#adding-actions
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
* <li><a href="{{ path('question_last') }}">Show the last question of {{ last.createdAt|format_datetime('short', 'none', locale='fr') }}</a></li>
* <li><a href="{{ path('question_last') }}">Show the last question of {{ last.createdAt|format_datetime('short', 'none', '', null, 'gregorian', locale='fr') }}</a></li>
* <li><a href="{{ path('question_last') }}">Show the last question of {{ last.createdAt|format_datetime(locale='fr') }}</a></li>
