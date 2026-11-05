<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Home extends BaseController
{
    public function index()
    {
        if (session()->has('usuario_id')) {
            return redirect()->to(site_url('panel'));
        }
        return view('login');
    }

    public function registro()
    {
        if (session()->has('usuario_id')) {
            return redirect()->to(site_url('panel'));
        }
        return view('registro', ['datos' => [], 'errores' => []]);
    }

    public function registrar()
    {
        $datos = ['nombre' => trim($this->texto('nombre')), 'correo' => strtolower(trim($this->texto('correo')))];
        $password = $this->texto('password');
        $confirmacion = $this->texto('confirmar_password');
        $this->validateData($datos + ['password' => $password, 'confirmar_password' => $confirmacion], [
            'nombre' => 'required|min_length[3]|max_length[120]',
            'correo' => 'required|max_length[254]|valid_email|is_unique[usuarios.correo]',
            'password' => 'required|min_length[8]|max_length[72]',
            'confirmar_password' => 'required|matches[password]',
        ]);
        $errores = $this->validator->getErrors();
        if ($errores === [] && ! preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^a-zA-Z0-9\s])/u', $password)) {
            $errores['password'] = 'La contraseña debe incluir mayúscula, minúscula, número y símbolo.';
        }
        if ($errores !== []) {
            $this->response->setStatusCode(422);
            return view('registro', ['datos' => $datos, 'errores' => $errores]);
        }
        $creado = (new UsuarioModel())->insert($datos + ['clave_hash' => password_hash($password, PASSWORD_BCRYPT), 'rol' => 'ADMIN', 'activo' => 1]);
        if ($creado === false) {
            $this->response->setStatusCode(500);
            return view('registro', ['datos' => $datos, 'errores' => ['registro' => 'No se pudo crear la cuenta.']]);
        }
        return redirect()->to(site_url('/'))->with('exito', 'Cuenta creada. Ya puedes iniciar sesión.');
    }

    public function autenticar()
    {
        $correo = strtolower(trim($this->texto('correo')));
        $password = $this->texto('password');
        $registro = null;
        if (strlen($correo) <= 254 && strlen($password) <= 72) {
            $registro = (new UsuarioModel())->where('correo', $correo)->where('activo', 1)->first();
        }
        if ($registro === null || ! password_verify($password, $registro['clave_hash'])) {
            return redirect()->to(site_url('/'))->with('error', 'Correo o contraseña incorrectos.');
        }
        session()->regenerate(true);
        session()->set(['usuario_id' => $registro['id'], 'usuario' => $registro['nombre'], 'rol' => $registro['rol']]);
        return redirect()->to(site_url('panel'));
    }

    public function salir()
    {
        session()->destroy();
        return redirect()->to(site_url('/'));
    }

    private function texto(string $campo): string
    {
        $valor = $this->request->getPost($campo);
        return is_string($valor) ? $valor : '';
    }
}
