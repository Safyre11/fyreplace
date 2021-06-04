<?php


namespace fyreplace\views;


abstract class View {

    /**
     * Renders a section of a webpage
     * @return string a string containing HTML that is eventually sent to the browser for displaying
     */
    abstract public function render(): string;

}