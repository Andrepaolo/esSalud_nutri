<?php

namespace App\Helpers;

use Illuminate\Contracts\Support\Renderable;

interface View extends Renderable
{
  /** @return static */
  public function layout();
}
