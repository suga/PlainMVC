<?php

/* arquivo.tpl */
class __TwigTemplate_7c56420749492bd4735f61666417dbd0 extends Twig_Template
{
  public function display(array $context)
  {
    // line 1
    echo "<html>
    <head>
        <meta http-equiv=\"content-type\" content=\"text/html;charset=UTF-8\" />
    </head>
<body>

<h1>";
    // line 7
    echo (isset($context['foo']) ? $context['foo'] : null);
    echo "</h1>
<p>Site home for module: modulo</p>

<p>Retrieving othername GET parameter: ";
    // line 10
    echo (isset($context['baz']) ? $context['baz'] : null);
    echo "</p>

</body>
</html>";
  }

  public function getName()
  {
    return "arquivo.tpl";
  }

}
