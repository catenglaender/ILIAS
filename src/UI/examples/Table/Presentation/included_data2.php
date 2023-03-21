<?php

function included_data2()
{
    $question1_givenanswer = <<<EOT
    <div class="ilc_question_Standard">	 <div id="focus"></div><div class="ilc_question_SingleChoice">
	<div class="ilc_qtitle_Title">In a single choice question, how many answers are correct? Please ponder this question carefully and select the correct option below. If you select the wrong option, you won't get any points. That's just how it is: No points for wrong answers.</div>
	<div class="ilc_answers answers answer-table ilClearFloat">

		<div class="ilc_qanswer_Answer">
			<div>
				<input type="radio" name="multiple_choice_result" value="2" id="answer_2">
			</div>
			<div>
				<label for="answer_2" class="answertext">


					All of them
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


		<div class="ilc_qanswer_Answer">
			<div>
				<input type="radio" name="multiple_choice_result" value="0" id="answer_0" checked="checked">
			</div>
			<div>
				<label for="answer_0" class="answertext">


					Exactly one option and one option only is correct. <img style="display: inline;" src="./templates/default/images/icon_ok.svg" alt="Ihre Lösung ist korrekt." title="Ihre Lösung ist korrekt.">
				</label>
			</div>
		</div>

		<div>
			<span class="feedback">Yes this is correct! In a single choice question only one single option is correct. One is the lonliest number!</span>
		</div>


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

	
	</div>
</div>



	</div>
EOT;

$question1_bestanswer = <<<EOT
<div class="ilc_question_Standard">
						<div class="ilc_question_SingleChoice">
	<div class="ilc_qtitle_Title"></div>
	<div class="ilc_answers answers answer-table ilClearFloat">

		<div class="ilc_qanswer_Answer">
			<div>
				
				<img src="./templates/default/images/radiobutton_unchecked.png" alt="Nicht ausgewählt" title="Nicht ausgewählt">
				
				
			</div>
			<div>

				<span class="answertext">All of them</span>

	

			</div>
		</div>


		<div class="ilc_qanswer_Answer">
			<div>
				
				<img src="./templates/default/images/radiobutton_unchecked.png" alt="Nicht ausgewählt" title="Nicht ausgewählt">
				
				
			</div>
			<div>

				<span class="answertext">Multiple</span>

	

			</div>
		</div>


		<div class="ilc_qanswer_Answer">
			<div>
				
				<img src="./templates/default/images/radiobutton_checked.png" alt="Ausgewählt" title="Ausgewählt">
				
				
			</div>
			<div>

				<span class="answertext">Exactly one option and one option only is correct.</span>

	

			</div>
		</div>


		<div class="ilc_qanswer_Answer">
			<div>
				
				<img src="./templates/default/images/radiobutton_unchecked.png" alt="Nicht ausgewählt" title="Nicht ausgewählt">
				
				
			</div>
			<div>

				<span class="answertext">Three</span>

	

			</div>
		</div>

	
	</div>
</div>

					</div>
EOT;

$question1_feedback = <<<EOT
<div class="ilc_qfeedr_FeedbackRight">That is absolutely correct. Just one option is correct!</div>
EOT;

$question2_givenanswer = <<<EOT
<div class="ilc_question_Standard">	 <div id="focus"></div><div class="ilc_question_MultipleChoice">
	<div class="ilc_qtitle_Title">Which of these options are colors?</div>
	
	<div class="ilc_answers answers answer-table ilClearFloat">

		<div class="ilc_qanswer_Answer">
			<div>
				<input type="checkbox" name="multiple_choice_result_1" value="1" id="answer_1" checked="checked" class="ilAssMultipleChoiceOption ilAssMultipleChoiceResult" data-qst-id="4" data-ans-id="1">
			</div>
			<div>
				<label for="answer_1" class="answertext">


					Elephant <img style="display: inline;" src="./templates/default/images/icon_not_ok.svg" alt="Ihre Lösung ist falsch." title="Ihre Lösung ist falsch.">
				</label>
			</div>
		</div>

		<div>
			<span class="feedback">That's not a color. That's a huge gray animal.</span>
		</div>


		<div class="ilc_qanswer_Answer">
			<div>
				<input type="checkbox" name="multiple_choice_result_2" value="2" id="answer_2" checked="checked" class="ilAssMultipleChoiceOption ilAssMultipleChoiceResult" data-qst-id="4" data-ans-id="2">
			</div>
			<div>
				<label for="answer_2" class="answertext">


					Yellow <img style="display: inline;" src="./templates/default/images/icon_ok.svg" alt="Ihre Lösung ist korrekt." title="Ihre Lösung ist korrekt.">
				</label>
			</div>
		</div>

		<div>
			<span class="feedback">Correct answer.</span>
		</div>


		<div class="ilc_qanswer_Answer">
			<div>
				<input type="checkbox" name="multiple_choice_result_3" value="3" id="answer_3" class="ilAssMultipleChoiceOption ilAssMultipleChoiceResult" data-qst-id="4" data-ans-id="3">
			</div>
			<div>
				<label for="answer_3" class="answertext">


					Banana <img style="display: inline;" src="./templates/default/images/icon_ok.svg" alt="Ihre Lösung ist korrekt." title="Ihre Lösung ist korrekt.">
				</label>
			</div>
		</div>

		<div>
			<span class="feedback">No, banana is a food, not a color.</span>
		</div>


		<div class="ilc_qanswer_Answer">
			<div>
				<input type="checkbox" name="multiple_choice_result_0" value="0" id="answer_0" class="ilAssMultipleChoiceOption ilAssMultipleChoiceResult" data-qst-id="4" data-ans-id="0">
			</div>
			<div>
				<label for="answer_0" class="answertext">


					Green <img style="display: inline;" src="./templates/default/images/icon_not_ok.svg" alt="Ihre Lösung ist falsch." title="Ihre Lösung ist falsch.">
				</label>
			</div>
		</div>

		<div>
			<span class="feedback">Yes, this is a color. Although the grass is always greener across the fence</span>
		</div>


	</div>
</div>


	</div>
EOT;

$question2_bestanswer = <<<EOT
<div class="ilc_question_Standard">
						<div class="ilc_question_MultipleChoice">
	<div class="ilc_qtitle_Title"></div>
	<div class="ilc_answers answers answer-table ilClearFloat">
	
		<div class="ilc_qanswer_Answer">
			<div>
				
				<img src="./templates/default/images/checkbox_unchecked.png" alt="Nicht ausgewählt" title="Nicht ausgewählt">
				
				
			</div>
			<div>

				<span class="answertext">Elephant</span>



			</div>
		</div>

	
		<div class="ilc_qanswer_Answer">
			<div>
				
				<img src="./templates/default/images/checkbox_checked.png" alt="Ausgewählt" title="Ausgewählt">
				
				
			</div>
			<div>

				<span class="answertext">Yellow</span>



			</div>
		</div>

	
		<div class="ilc_qanswer_Answer">
			<div>
				
				<img src="./templates/default/images/checkbox_unchecked.png" alt="Nicht ausgewählt" title="Nicht ausgewählt">
				
				
			</div>
			<div>

				<span class="answertext">Banana</span>



			</div>
		</div>

	
		<div class="ilc_qanswer_Answer">
			<div>
				
				<img src="./templates/default/images/checkbox_checked.png" alt="Ausgewählt" title="Ausgewählt">
				
				
			</div>
			<div>

				<span class="answertext">Green</span>



			</div>
		</div>

	
	</div>
</div>

					</div>
EOT;

$question2_feedback = <<<EOT
<div class="ilc_qfeedw_FeedbackWrong">At least one selected option wasn't correct. Better luck next time.</div>
EOT;

$question3_givenanswer = <<<EOT
<div class="ilc_question_Standard">	 <div class="ilc_question_ClozeTest">
<div class="ilc_qtitle_Title">Please complete the following text</div>
<div class="ilc_qanswer_Answer ilc_answers answers ilAssClozeTest ilClearFloat"><p>This here text has some <input class="ilc_qinput_TextInput" type="text" spellcheck="false" autocomplete="off" autocorrect="off" autocapitalize="off" name="gap_0" value="words"> <img style="display: inline;" src="./templates/default/images/icon_not_ok.svg" alt="Ihre Lösung ist falsch." title="Ihre Lösung ist falsch.">. There could also be a larger gap, for example this one talking about how ILIAS is <select class="ilc_qinput_ClozeGapSelect" name="gap_1">
	<option value="-1">---- bitte auswählen ----</option>

	<option value="0">an e-Learning system, also called an LMS to organize courses and groups for online and offline learning.</option>

	<option value="1">a pizza ofen that cooks pizzas just right (I think they call this al dente)</option>

	<option value="2" selected="selected">a bird feeder with a decorative water bowl retailing for just 29 euros.</option>

	

</select><img style="display: inline;" src="./templates/default/images/icon_not_ok.svg" alt="Ihre Lösung ist falsch." title="Ihre Lösung ist falsch."> What a highly interesting text.</p></div>
<div class="ilClearFloat"></div>
</div>


	</div>
EOT;

$question3_bestanswer = <<<EOT
<div class="ilc_question_Standard">
						<div class="ilc_question_ClozeTest">

<div class="ilc_qanswer_Answer ilc_answers answers ilAssClozeTest ilClearFloat"><p>This here text has some 


<span class="ilc_qinput_TextInput solutionbox">gaps</span>




. There could also be a larger gap, for example this one talking about how ILIAS is 


<span class="ilc_qinput_TextInput solutionbox">an e-Learning system, also called an LMS to organize courses and groups for online and offline learning.</span>




 What a highly interesting text.</p></div>
<div class="ilClearFloat"> </div>
</div>

					</div>
EOT;

$question3_feedback = <<<EOT
<div class="ilc_qfeedw_FeedbackWrong">Oh no... that is not quite the correct answer. Well, better luck next time!</div>
<div class="test_specific_feedback"><table class="test_specific_feedback"><tbody><tr><td>Lücke 1: </td><td>Whatever you typed here is incorrect.</td> </tr><tr><td>Lücke 2: </td><td>A great offer, but the incorrect answer.</td> </tr></tbody></table></div>
EOT;

$question4_givenanswer = <<<EOT
<div class="ilc_question_Standard">	 <div id="focus"></div><div class="ilc_question_KprimChoice">
<div class="ilc_qtitle_Title">Which of these statements are true and which ones are false?</div>
<p class="ilAssKprimInstruction ilClearFloat">You have to decide on every statement: [right] or [wrong]</p>
	
<div class="ilc_answers ilAssKprimChoiceTable ilClearFloat">
	<div class="row ilc_qanswer_Answer">
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 optionLabel">right</div>
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 optionLabel">wrong</div>
	</div>
	
	<div class="row ilc_qanswer_Answer">
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 kprimInput"><input type="radio" name="kprim_choice_result_0" value="1" id="0" checked="checked"></div>
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 kprimInput"><input type="radio" name="kprim_choice_result_0" value="0" id="0"></div>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-8">
			
			
			The earth is round <img style="display: inline;" src="./templates/default/images/icon_ok.svg" alt="Ihre Lösung ist korrekt." title="Ihre Lösung ist korrekt.">
		</div>
	</div>
	
	<div>
		<span class="feedback">This is correct.</span>
	</div>
	
	
	<div class="row ilc_qanswer_Answer">
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 kprimInput"><input type="radio" name="kprim_choice_result_1" value="1" id="1"></div>
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 kprimInput"><input type="radio" name="kprim_choice_result_1" value="0" id="1" checked="checked"></div>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-8">
			
			
			Spiders have two legs <img style="display: inline;" src="./templates/default/images/icon_ok.svg" alt="Ihre Lösung ist korrekt." title="Ihre Lösung ist korrekt.">
		</div>
	</div>
	
	<div>
		<span class="feedback">No, just count the legs next time you see one.</span>
	</div>
	
	
	<div class="row ilc_qanswer_Answer">
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 kprimInput"><input type="radio" name="kprim_choice_result_2" value="1" id="2" checked="checked"></div>
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 kprimInput"><input type="radio" name="kprim_choice_result_2" value="0" id="2"></div>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-8">
			
			
			ILIAS is an e-Learning software <img style="display: inline;" src="./templates/default/images/icon_ok.svg" alt="Ihre Lösung ist korrekt." title="Ihre Lösung ist korrekt.">
		</div>
	</div>
	
	<div>
		<span class="feedback">Yes!</span>
	</div>
	
	
	<div class="row ilc_qanswer_Answer">
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 kprimInput"><input type="radio" name="kprim_choice_result_3" value="1" id="3" checked="checked"></div>
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 kprimInput"><input type="radio" name="kprim_choice_result_3" value="0" id="3"></div>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-8">
			
			
			Nothing lasts forever <img style="display: inline;" src="./templates/default/images/icon_ok.svg" alt="Ihre Lösung ist korrekt." title="Ihre Lösung ist korrekt.">
		</div>
	</div>
	
	<div>
		<span class="feedback">...until the heat death of the universe.</span>
	</div>
	
	
</div>
</div>
<ul class="ilAssQuestionRelatedNavigationContainer nav navbar-nav">
	
		<li>
		<div class="navbar">
			
			<input class="ilc_qsubmit_Submit btn btn-default" type="submit" name="cmd[showInstantResponse]" value="Check">
			
			
		</div>
		</li>
	
</ul>

	</div>
EOT;

$question4_bestanswer = <<<EOT
<div class="ilc_question_Standard">
						<div class="ilc_question_KprimChoice">
<div class="ilc_qtitle_Title"></div>
<p class="ilAssKprimInstruction ilClearFloat"></p>
<div class="ilc_answers answers ilAssKprimChoiceTable ilClearFloat">
	<div class="row ilc_qanswer_Answer">
		<div class="col-xs-3 col-sm-2 col-md-3 col-lg-2 optionLabel">right</div>
		<div class="col-xs-3 col-sm-2 col-md-3 col-lg-2 optionLabel">wrong</div>
	</div>
	
	<div class="row ilc_qanswer_Answer">
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 kprimInput">
			
			<img src="./templates/default/images/radiobutton_checked.png" alt="Checked" title="Checked">
			
			
		</div>
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 kprimInput">
			
			<img src="./templates/default/images/radiobutton_unchecked.png" alt="Unchecked" title="Unchecked">
			
			
		</div>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-8">
			
			The earth is round
		</div>
		<div class="col-sm-1">
			
			
		</div>
		<div class="col-sm-2">
			
		</div>
	</div>
	
	
	<div class="row ilc_qanswer_Answer">
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 kprimInput">
			
			<img src="./templates/default/images/radiobutton_unchecked.png" alt="Unchecked" title="Unchecked">
			
			
		</div>
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 kprimInput">
			
			<img src="./templates/default/images/radiobutton_checked.png" alt="Checked" title="Checked">
			
			
		</div>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-8">
			
			Spiders have two legs
		</div>
		<div class="col-sm-1">
			
			
		</div>
		<div class="col-sm-2">
			
		</div>
	</div>
	
	
	<div class="row ilc_qanswer_Answer">
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 kprimInput">
			
			<img src="./templates/default/images/radiobutton_checked.png" alt="Checked" title="Checked">
			
			
		</div>
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 kprimInput">
			
			<img src="./templates/default/images/radiobutton_unchecked.png" alt="Unchecked" title="Unchecked">
			
			
		</div>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-8">
			
			ILIAS is an e-Learning software
		</div>
		<div class="col-sm-1">
			
			
		</div>
		<div class="col-sm-2">
			
		</div>
	</div>
	
	
	<div class="row ilc_qanswer_Answer">
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 kprimInput">
			
			<img src="./templates/default/images/radiobutton_checked.png" alt="Checked" title="Checked">
			
			
		</div>
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 kprimInput">
			
			<img src="./templates/default/images/radiobutton_unchecked.png" alt="Unchecked" title="Unchecked">
			
			
		</div>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-8">
			
			Nothing lasts forever
		</div>
		<div class="col-sm-1">
			
			
		</div>
		<div class="col-sm-2">
			
		</div>
	</div>
	
	
</div>
</div>


					</div>
EOT;

$question4_feedback = <<<EOT
<div class="ilc_qfeedr_FeedbackRight">You made all the right choices.</div>
EOT;

$allquestions = [
    'question1' => [
        'given' => $question1_givenanswer,
        'best' => $question1_bestanswer,
        'feedback' => $question1_feedback
    ],
    'question2' => [
        'given' => $question2_givenanswer,
        'best' => $question2_bestanswer,
        'feedback' => $question2_feedback
    ],
    'question3' => [
        'given' => $question3_givenanswer,
        'best' => $question3_bestanswer,
        'feedback' => $question3_feedback
    ],
    'question4' => [
        'given' => $question4_givenanswer,
        'best' => $question4_bestanswer,
        'feedback' => $question4_feedback
    ]
];
    $IconPassed = '<img style="display: inline;" src="./templates/default/images/icon_ok.svg" alt="Ihre Lösung ist korrekt." title="Ihre Lösung ist korrekt."> ';
    $IconNotPassed = '<img style="display: inline;" src="./templates/default/images/icon_not_ok.svg" alt="Ihre Lösung ist falsch." title="Ihre Lösung ist falsch."> ';
    return  array(
        array(
            'id' => 2,
            'given-answer' => $allquestions['question1']['given'],
            'best-answer' => '',
            'feedback' => $allquestions['question1']['feedback'],
            'type' => 'Single Choice',
            'points' => [
                'max' => 4,
                'earned' => 4,
                'percent' => 100,
                'assessment' => 'correct'
            ],
            'question_title' => $IconPassed . 'A difficult choice',
            'question_txt' => "In a single choice question, how many answers are correct? Please ponder this question carefully and select the correct option below. If you select the wrong option, you won't get any points. That's just how it is: No points for wrong answers."
        ),

        array(
            'id' => 4,
            'given-answer' => $allquestions['question2']['given'],
            'best-answer' => $allquestions['question2']['best'],
            'feedback' => $allquestions['question2']['feedback'],
            'type' => 'Multiple Choice',
            'points' => [
                'max' => 4,
                'earned' => 1,
                'percent' => 25,
                'assessment' => 'incorrect'
            ],
            'question_title' => $IconNotPassed . 'One is not enough',
            'question_txt' => 'Which of these options are colors?',
        ),

        array(
            'id' => 6,
            'given-answer' => $allquestions['question3']['given'],
            'best-answer' => $allquestions['question3']['best'],
            'feedback' => $allquestions['question3']['feedback'],
            'type' => 'Cloze Test',
            'points' => [
                'max' => 0,
                'earned' => 0,
                'percent' => 0,
                'assessment' => 'incorrect'
            ],
            'question_title' => $IconNotPassed . 'Text with gaps',
            'question_txt' => 'Please complete the following text',
            ),

            array(
                'id' => 8,
                'given-answer' => $allquestions['question4']['given'],
                'best-answer' => '',
                'feedback' => $allquestions['question4']['feedback'],
                'type' => 'Multiple True/False Choice',
                'points' => [
                    'max' => 4,
                    'earned' => 4,
                    'percent' => 100,
                    'assessment' => 'correct'
                ],
                'question_title' => $IconPassed . 'What is right? What is wrong?',
                'question_txt' => 'Please complete the following text',
            )
    );
}
