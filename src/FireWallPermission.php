<?php

namespace Hunter\firewall;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use M6Web\Component\Firewall\Firewall;

/**
 * Provides firewall module permission auth.
 */
class FireWallPermission {

  /**
   * Returns bool value of firewall permission.
   *
   * @return bool
   */
  public function handle(ServerRequestInterface $request, ResponseInterface $response, callable $next) {
    $whiteList = array_filter(explode("\n", variable_get('firewall_whitelist')));
    $blackList = array_filter(explode("\n", variable_get('firewall_blacklist')));

    $firewall = new Firewall();

    if(!empty($whiteList)){
      $firewall->addList($whiteList, 'local', true);
    }

    if(!empty($blackList)){
      $firewall->addList($blackList, 'localBad', false);
    }

    $connAllowed = $firewall->setIpAddress(get_client_ip())->handle();

    if (!$connAllowed) {
      http_response_code(403);
      echo '403 Access Forbidden, You are in IP Black List!';
      exit();
    }

    return $next($request, $response);
  }

}
