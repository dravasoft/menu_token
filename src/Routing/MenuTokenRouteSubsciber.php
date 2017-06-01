<?php

namespace Drupal\menu_token\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class MenuTokenRouteSubsciber.
 *
 * @package Drupal\menu_token\Routing
 * Listens to the dynamic route events.
 */
class MenuTokenRouteSubsciber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {


      //error_log("Klicem se in poskusam spremeniti route! tako kot mi je
    // podal uporabnik");

      //$a = $collection;
     // $a++;
    // Kako najdem menu reute...???!"!!

    //die("alterRoutes");


  }
}
