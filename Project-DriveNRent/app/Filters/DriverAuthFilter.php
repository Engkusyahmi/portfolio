<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class DriverAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $currentUrl = current_url();

        log_message('info', "DRIVER_FILTER: Checking access for URI: {$currentUrl}");

        // Check if user is logged in
        if (!$session->has('userlevel')) {
            log_message('warning', 'DRIVER_FILTER: No userlevel in session. Redirecting to login.');
            return redirect()->to(base_url('login'))->with('error', 'You must be logged in to access the driver portal.');
        }

        // Ensure the user is a driver
        if ($session->get('userlevel') !== 'driver') {
            log_message('warning', 'DRIVER_FILTER: Access denied. Not a driver.');
            return redirect()->to(base_url('/'))->with('error', 'Access Denied: Drivers only.');
        }

        log_message('info', 'DRIVER_FILTER: Access granted for driver.');
        return null; // Let the request continue
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No post-processing required
    }
}
