<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    // Runs before the controller method
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Check if user is logged in
        if (!$session->get('logged_in')) {
            // Not logged in, redirect to login page
            return redirect()->to('/login');
        }

        // Optionally, you can check for user role if $arguments passed
        if ($arguments) {
            $userLevel = $session->get('userlevel');
            if (!in_array($userLevel, $arguments)) {
                // User does not have permission, redirect or show error
                return redirect()->to('/login')->with('error', 'You do not have permission to access that page.');
            }
        }
    }

    // Runs after the controller method
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed here for now
    }
}
