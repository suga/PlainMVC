<?php
/**
 * Front Controller application
 * @author Hélio Costa e Silva <hlegius@foobug.com.br>
 * @package \web
 * @version January, 17 2010
 */
require_once "../library/simplemvc/core/Autoload.php";

SimpleHttpRequest::getInstance()->dispatch(dirname(__FILE__));
