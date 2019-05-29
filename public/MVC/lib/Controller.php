<?php
class Controller {
	public function action404() {
		Response::render("default/404");
	}
}

function money_format($decimals,$price) {
	return "$".number_format($price,$decimals,",",".");
}
