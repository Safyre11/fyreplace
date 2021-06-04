<?php


namespace fyreplace;


use fyreplace\views\View;

interface Result {

    function getSource(): Controller;

    function doAction(): View|Result;

}