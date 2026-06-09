<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class StudentAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $currentUrl = current_url();

        log_message('info', "STUDENT_FILTER: Checking access for URI: {$currentUrl}");

        // Check if the session has userlevel
        if (!$session->has('userlevel')) {
            log_message('warning', 'STUDENT_FILTER: No userlevel found. Redirecting to login.');
            return redirect()->to(base_url('login'))->with('error', 'You must be logged in to access this area.');
        }

        // Check if the userlevel is 'student'
        if ($session->get('userlevel') !== 'student') {
            log_message('warning', 'STUDENT_FILTER: Access denied. Userlevel is not student.');
            return redirect()->to(base_url('/'))->with('error', 'Access Denied: Student access only.');
        }

        log_message('info', 'STUDENT_FILTER: Access granted to student.');
        return null; // allow request
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing after
    }
}
