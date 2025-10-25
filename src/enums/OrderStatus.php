<?php

namespace App\Enums;

enum OrderStatus: int
{
  case PENDING = 1;
  case PROCESSING = 2;
  case COMPLETED = 3;
  case ON_HOLD = 4;
  case REFUNDED = 5;
  case CANCELLED = 6;
  case FAILED = 7;
}
