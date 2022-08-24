<?php

$question1_givenanswer = <<<EOT
<div class="ilc_question_Standard">
<div id="focus"></div>
<div class="ilc_question_SingleChoice">
    <div class="ilc_qtitle_Title">In a single choice question, how many answers are correct? Please ponder
        this question carefully and select the correct option below. If you select the wrong option, you
        won't get any points. That's just how it is: No points for wrong answers.</div>
    <div class="ilc_answers answers answer-table ilClearFloat">

        <div class="ilc_qanswer_Answer">
            <div>
                <input type="radio" name="multiple_choice_result" value="3" id="answer_3">
            </div>
            <div>
                <label for="answer_3" class="answertext">


                    Three
                </label>
            </div>
        </div>


        <div class="ilc_qanswer_Answer">
            <div>
                <input type="radio" name="multiple_choice_result" value="2" id="answer_2" checked="checked">
            </div>
            <div>
                <label for="answer_2" class="answertext">


                    All of them
                </label>
            </div>
        </div>

        <div>
            <span class="feedback">No... Wouldn't that be nice?</span>
        </div>


        <div class="ilc_qanswer_Answer">
            <div>
                <input type="radio" name="multiple_choice_result" value="0" id="answer_0">
            </div>
            <div>
                <label for="answer_0" class="answertext">


                    Exactly one option and one option only is correct.
                </label>
            </div>
        </div>


        <div class="ilc_qanswer_Answer">
            <div>
                <input type="radio" name="multiple_choice_result" value="1" id="answer_1">
            </div>
            <div>
                <label for="answer_1" class="answertext">


                    Multiple
                </label>
            </div>
        </div>


    </div>
</div>

<ul class="ilAssQuestionRelatedNavigationContainer nav navbar-nav">

    <li>
        <div class="navbar">

            <input class="ilc_qsubmit_Submit btn btn-default" type="submit" name="cmd[showInstantResponse]"
                value="Prüfen">


        </div>
    </li>

    <li>
        <div class="navbar">

            <input class="ilc_qsubmit_Submit btn btn-default" type="submit" name="cmd[confirmHintRequest]"
                value="Lösungshinweis anfordern">


        </div>
    </li>

</ul>

</div>
EOT;

$allquestions = [$question1_givenanswer];
return $allquestions;