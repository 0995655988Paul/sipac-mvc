<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    // Comprueba la sesión antes del CRUD.
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->has('usuario_id')) {
            return redirect()->to(site_url('/'))
                ->with('error', 'Inicia sesión para acceder al inventario.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $response->setHeader('Cache-Control', 'no-store');
    }
}
