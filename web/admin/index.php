<?php
/**
 * Front Controller application
 * @author Hélio Costa e Silva <hlegius@foobug.com.br>
 * @package \web
 * @version January, 17 2010
 */
require_once "../../library/plainmvc/core/Autoload.php";

PlainHttpRequest::getInstance()->dispatch(dirname(__FILE__));
