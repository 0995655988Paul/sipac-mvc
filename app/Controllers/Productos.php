<?php

namespace App\Controllers;

use App\Models\ProductoModel;
use App\Services\InventarioService;
use CodeIgniter\Exceptions\PageNotFoundException;

class Productos extends BaseController
{
    public function index()
    {
        return view('productos/index', ['titulo' => 'Productos', 'productos' => (new ProductoModel())->orderBy('prioridad', 'DESC')->orderBy('nombre')->findAll(), 'saldos' => (new InventarioService())->saldos()]);
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

    public function eliminar(int $id)
    {
        $this->buscar($id);
        (new ProductoModel())->update($id, ['activo' => 0]);
        return redirect()->to(site_url('productos'))->with('exito', 'Producto desactivado; se conservó su historial.');
    }

    private function persistir(?int $id)
    {
        $modelo = new ProductoModel();
        $datos = [
            'codigo' => strtoupper(trim((string) $this->request->getPost('codigo'))),
            'nombre' => trim((string) $this->request->getPost('nombre')),
            'unidad' => trim((string) $this->request->getPost('unidad')),
            'stock_seguridad' => (int) $this->request->getPost('stock_seguridad'),
            'prioridad' => (int) $this->request->getPost('prioridad'),
            'activo' => 1,
        ];
        $consulta = $modelo->where('codigo', $datos['codigo']);
        if ($id !== null) {
            $consulta->where('id !=', $id);
        }
        $errores = $consulta->first() !== null ? ['codigo' => 'Ese código ya está registrado.'] : [];
        if ($errores === [] && ($id === null ? $modelo->insert($datos) : $modelo->update($id, $datos)) === false) {
            $errores = $modelo->errors();
        }
        if ($errores !== []) {
            $this->response->setStatusCode(422);
            return $this->formulario($id ? $this->buscar($id) : null, $datos, $errores);
        }
        return redirect()->to(site_url('productos'))->with('exito', 'Producto guardado.');
    }

    private function buscar(int $id): array
    {
        $producto = (new ProductoModel())->find($id);
        if ($producto === null) {
            throw PageNotFoundException::forPageNotFound('Producto no encontrado.');
        }
        return $producto;
    }

    private function formulario(?array $producto, array $datos, array $errores): string
    {
        return view('productos/formulario', ['titulo' => $producto ? 'Editar producto' : 'Nuevo producto', 'producto' => $producto, 'datos' => $datos !== [] ? $datos : ($producto ?? ['codigo' => '', 'nombre' => '', 'unidad' => 'unidades', 'stock_seguridad' => 0, 'prioridad' => 2]), 'errores' => $errores]);
    }
}
