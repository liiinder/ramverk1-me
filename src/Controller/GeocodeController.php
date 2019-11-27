<?php

namespace Linder\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

/**
 * A controller that handles a get request
 * and returns if its a valid ip or not.
 */
class GeocodeController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * This is the index method action, it handles:
     *
     * @return object
     */
    public function indexAction() : object
    {
        $page = $this->di->get("page");

        $data = [
            "lon" => "15.586703",
            "lat" => "56.160817"
        ];

        $page->add("geocode/main", $data);

        return $page->render([
            "title" => "Geocode",
        ]);
    }
}
