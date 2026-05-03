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

        // Limit login attempts to 5 per minute from a single IP (MD5 hash to avoid reserved characters in IPv6)
        if ($throttle->check(md5($request->getIPAddress()), 5, MINUTE) === false) {
            return \Config\Services::response()->setStatusCode(429)->setBody('Too Many Requests. Please wait a minute before trying again.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
