<?php

namespace Acme\Core;

class View
{
   public function render($templateFile, array $vars = array())
   {
      ob_start();
      extract($vars);
      require(config('root_path') . config('views_path') . '/' . $templateFile . '.' . config('template_engine'));

      return ob_get_clean();
   }
}