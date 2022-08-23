<?php

function environment2()
{
    $statistics = function($data) {
        $ret = "ID: {$data['id']} | {$data['type']} | {$data['points']['earned']} of {$data['points']['max']} point(s) | {$data['points']['percent']} % correct";
        return $ret;
    };
    $givenanswer = function ($content) {
        $ret = $content;
        return $ret;
    };

    $bestanswer= function ($content) {
        $ret = $content;
        return $ret;
    };

    $feedback = function ($content) {
        $ret = $content;
        return $ret;
    };

    return  array(
        'statistics' => $statistics,
        'given-answer' => $givenanswer,
        'best-answer' => $bestanswer,
        'feedback' => $feedback
    );
}
