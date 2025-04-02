<?php

// Se define el espacio de nombres donde está el controlador.
namespace App\Http\Controllers\Catalogos;

// Se importan clases necesarias para el controlador.
use App\Classes\ApiResponseHelper; // Helper para formatear respuestas API.
use App\Http\Controllers\Controller; // Clase base para controladores en Laravel.
use App\Http\Requests\Catalogos\Store\StoreCatRolRequest; // Validación al crear un rol.
use App\Http\Requests\Catalogos\Update\UpdateCatRolRequest; // Validación al actualizar un rol.
use App\Interface\Catalogos\catRolesRepositoryInterface; // Interfaz para manejar datos de roles.
use Exception; // Se usa para manejar errores.
use Illuminate\Http\Exceptions\HttpResponseException; // Excepción específica de respuestas HTTP.
use Illuminate\Http\Request; // Manejo de solicitudes HTTP.
use Illuminate\Support\Facades\DB; // Facade para trabajar con la base de datos.


// Definición de la clase del controlador, que extiende de Controller.
class catRolesController extends Controller
{
    // Variable protegida donde se almacenará el repositorio de roles.
    protected $_catRoles;

    // Constructor del controlador. Se inyecta la interfaz del repositorio de roles.
    public function __construct(catRolesRepositoryInterface $catRoles)
    {
        $this->_catRoles = $catRoles; // Se asigna el repositorio a la variable protegida.
    }

    // Método para obtener todos los roles.
    public function getAll()
    {
        try {
            // Llama al método getAll() del repositorio para obtener todos los roles.
            $getAll = $this->_catRoles->getAll();

            // Retorna la respuesta formateada con el helper.
            return ApiResponseHelper::
            sendResponse($getAll, 'Catálogo obtenido', 200);
        } catch (Exception $ex) {
            // Manejo de errores si falla la consulta.
            return ApiResponseHelper::
            sendResponse($ex, 'No se obtuvo la lista', 500);
        }
    }

    // Método para obtener un rol por su ID.
    public function getById($Id)
    {
        try {
            // Llama al método getById() del repositorio para obtener un rol específico.
            $getById = $this->_catRoles->getById($Id);

            // Retorna la respuesta con los datos obtenidos.
            return ApiResponseHelper::
            sendResponse($getById, 'Datos obtenidos', 200);
        } catch (Exception $ex) {
            // Manejo de errores si falla la consulta.
            return ApiResponseHelper::
            sendResponse($ex, 'No se obtuvo el dato', 500);
        }
    }

    // Método para obtener solo los roles que están habilitados.
    public function getAllHabilitados()
    {
        try {
            // Llama al método getAllHabilitados() del repositorio.
            $getAll = $this->_catRoles->getAllHabilitados();

            // Devuelve los datos en una respuesta JSON.
            return ApiResponseHelper::
            sendResponse($getAll, 'Catálogo obtenido', 200);
        } catch (HttpResponseException $ex) {
            // En caso de error HTTP, se revierte la transacción.
            DB::rollBack();

            // Obtiene la respuesta original del error.
            $response = $ex->getResponse();
            $response = $response->original ?? [$ex->getMessage()];

            // Retorna un mensaje de error con rollback.
            return ApiResponseHelper::
            rollback(false, 'No se pudo obtener los datos', $response['data'], $response['errors'], 500);
        } catch (Exception $ex) {
            // Si ocurre cualquier otro error, se revierte la transacción.
            DB::rollBack();
            return ApiResponseHelper::
            rollback(false, 'Ocurrió un error inesperado', null, [$ex->getMessage()], 500);
        }
    }

    // Método para crear un nuevo rol.
    public function store(StoreCatRolRequest $cat)
    {
        try {
            // Inicia una transacción para asegurar que la operación sea atómica.
            DB::beginTransaction();

            // Se crea un arreglo con los datos del nuevo rol.
            $data = [
                'nombre_rol' => $cat->nombre_rol, // Nombre del rol.
                'habilitado' => $cat->habilitado // Estado del rol (habilitado o no).
            ];

            // Llama al método store() del repositorio para guardar el rol en la base de datos.
            $catalog = $this->_catRoles->store($data);

            // Confirma la transacción.
            DB::commit();

            // Retorna una respuesta indicando éxito.
            return ApiResponseHelper::sendResponse(null, 'Catálogo creado correctamente', 201);
        } catch (Exception $ex) {
            // Si ocurre un error, revierte la transacción.
            DB::rollBack();

            // Retorna un mensaje de error con rollback.
            return ApiResponseHelper::rollback($ex);
        }
    }

    // Método para actualizar un rol existente.
    public function update(UpdateCatRolRequest $cat, $id)
    {
        try {
            // Inicia una transacción para asegurar la integridad de la actualización.
            DB::beginTransaction();

            // Se preparan los datos a actualizar.
            $data = [
                'nombre_rol' => $cat->nombre_rol, // Nuevo nombre del rol.
                'habilitado' => $cat->habilitado // Nuevo estado del rol.
            ];

            // Llama al método update() del repositorio para actualizar el rol en la base de datos.
            $catalog = $this->_catRoles->update($data, $id);

            // Confirma la transacción.
            DB::commit();

            // Retorna una respuesta indicando éxito.
            return ApiResponseHelper::
            sendResponse(null, 'Catálogo actualizado correctamente', 201);
        } catch (Exception $ex) {
            // Si ocurre un error, revierte la transacción.
            DB::rollBack();

            // Retorna un mensaje de error con rollback.
            return ApiResponseHelper::rollback($ex);
        }
    }
}
