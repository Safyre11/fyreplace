<?php


namespace fyreplace\views\basic;


use fyreplace\views\View;

/**
 * A View that when rendered displays the text it was constructed with
 * @package fyreplace\views\basic
 */
class TextView extends View {

    public function __construct(
        private string $text
    ){

    }

    /**
     * @inheritDoc
     */
    public function render(): string {
        return $this->text;
    }
}