<?php


namespace fyreplace;


use fyreplace\views\View;

interface Controller {

    /** Returns a view from the controller.
     * Path is the url requested by user not including the controller
     * Parameters are either the get or post parameters sent with the
     * @param string $path Url requested by user
     * @param array $parameters Parameters from get or post
     * @return View|Result A view that can be rendered to display to the user or a result to be used for further processing
     */
    static function getView(string $path, array $parameters): View|Result;

}