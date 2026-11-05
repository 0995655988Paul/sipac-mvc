<?php

namespace App\Controllers;

use App\Models\ProveedorModel;
use App\Services\RucEcuador;
use CodeIgniter\Exceptions\PageNotFoundException;

class Proveedores extends BaseController
{
    public function index()
    {
        return view('proveedores/index', ['titulo' => 'Proveedores', 'proveedores' => (new ProveedorModel())->orderBy('razon_social')->findAll()]);
    }

    public function nuevo()
    {
        return $this->formulario(null, [], []);
    }

    public function guardar()
    {
        return $this->persistir(null);
    }

    public function editar(int $id)
    {
        return $this->formulario($this->buscar($id), [], []);
    }

    public function actualizar(int $id)
    {
        $this->buscar($id);
        return $this->persistir($id);
    }

    private function persistir(?int $id)
    {
        $modelo = new ProveedorModel();
        $datos = [
            'razon_social' => trim((string) $this->request->getPost('razon_social')),
            'identificacion_fiscal' => RucEcuador::normalizar((string) $this->request->getPost('identificacion_fiscal')),
            'contacto' => trim((string) $this->request->getPost('contacto')),
            'correo' => strtolower(trim((string) $this->request->getPost('correo'))),
            'telefono' => preg_replace('/[\s().-]+/', '', (string) $this->request->getPost('telefono')),
            'activo' => 1,
        ];
        $errores = [];
        if (! RucEcuador::esValido($datos['identificacion_fiscal'])) {
            $errores['identificacion_fiscal'] = 'El RUC no es válido. Debe tener 13 dígitos, terminar en 001 y pasar el dígito verificador.';
        }
        $consulta = $modelo->where('identificacion_fiscal', $datos['identificacion_fiscal']);
        if ($id !== null) {
            $consulta->where('id !=', $id);
        }
        if ($consulta->first() !== null) {
            $errores['identificacion_fiscal'] = 'Ese RUC ya está registrado.';
        }
        if ($datos['razon_social'] === '' || mb_strlen($datos['razon_social']) > 160) {
            $errores['razon_social'] = 'La razón social es obligatoria y no puede superar 160 caracteres.';
        }
        if (! filter_var($datos['correo'], FILTER_VALIDATE_EMAIL)) {
            $errores['correo'] = 'Escribe un correo válido.';
        }
        if (! preg_match('/\A\+?[0-9]{7,15}\z/', $datos['telefono'])) {
            $errores['telefono'] = 'El teléfono debe contener entre 7 y 15 dígitos.';
        }
        if ($errores === []) {
            $ok = $id === null ? $modelo->insert($datos) : $modelo->update($id, $datos);
            if ($ok === false) {
                $errores = $modelo->errors() ?: ['proveedor' => 'No se pudo guardar el proveedor.'];
            }
        }
        if ($errores !== []) {
            $this->response->setStatusCode(422);
            return $this->formulario($id ? $this->buscar($id) : null, $datos, $errores);
        }
        return redirect()->to(site_url('proveedores'))->with('exito', 'Proveedor guardado.');
    }

    private function buscar(int $id): array
    {
        $proveedor = (new ProveedorModel())->find($id);
        if ($proveedor === null) {
            throw PageNotFoundException::forPageNotFound('Proveedor no encontrado.');
        }
        return $proveedor;
    }

    private function formulario(?array $proveedor, array $datos, array $errores): string
    {
        return view('proveedores/formulario', ['titulo' => $proveedor ? 'Editar proveedor' : 'Nuevo proveedor', 'proveedor' => $proveedor, 'datos' => $datos !== [] ? $datos : ($proveedor ?? ['razon_social' => '', 'identificacion_fiscal' => '', 'contacto' => '', 'correo' => '', 'telefono' => '']), 'errores' => $errores]);
    }
}
