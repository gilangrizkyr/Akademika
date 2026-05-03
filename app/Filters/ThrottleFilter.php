<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AuthLoginModel;

class ThrottleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $throttle = \Config\Services::throttler();
        
        $limit = 10;
        $time = MINUTE;

        if ($arguments) {
            $limit = (int)$arguments[0];
        }

        // MD5 hash to avoid reserved characters in IPv6 for cache keys
        if ($throttle->check(md5($request->getIPAddress()), $limit, $time) === false) {
            return \Config\Services::response()->setStatusCode(429)->setBody('Too Many Requests. Please wait a minute.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
