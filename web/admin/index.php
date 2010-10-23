<?php
namespace Web\admin;
require_once "../../Library/PlainMVC/Core/Autoload.php";

use Library\PlainMVC\Core\View\PlainHttpRequest;

/**
 * Front Controller application
 * @author Hélio Costa e Silva <hlegius@foobug.com.br>
 * @package \web
 * @version January, 17 2010
 */

PlainHttpRequest::getInstance()->dispatch(dirname(__FILE__));
