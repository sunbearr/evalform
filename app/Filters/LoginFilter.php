<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\Config\Services;

class LoginFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = Services::session();
        $uri = $request->getPath();
        $segments = explode('/', $uri);
        
        // Find the position of 'surveys/' in the URL
        $surveyIndex = array_search('surveys', $segments);
        
        // Check if 'surveys/' is found in the URL and there is a segment after it
        if ($surveyIndex !== false && isset($segments[$surveyIndex + 1])) {
            $userIdFromUrl = $segments[$surveyIndex + 1];
            
            // Check if the user is not logged in
            if (!$session->get('isLoggedIn')) {
                // Prepare a response object to return a message
                $response = Services::response();
                $response->setStatusCode(200); // You can set this to 401 if it's an unauthorized access
                $response->setBody('Not logged In');
                return $response; // Return the response object with the message
            } elseif ($session->get('userId') != $userIdFromUrl && !$session->get('isAdmin')) {
                $response = Services::response();
                $response->setStatusCode(401); // You can set this to 401 if it's an unauthorized access
                $response->setBody("Not authorized");
                return $response;
            }
        } else {
            // Handle the case where 'surveys/' is not found in the URL or there is no segment after it
            // You can return an error response or handle it according to your application's logic
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed after the controller method is executed
    }
}
