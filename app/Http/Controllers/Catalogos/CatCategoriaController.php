<?php

namespace App\Http\Controllers\Catalogos;

use App\Classes\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalogos\Store\StoreCatCategoriaRequest;
use App\Http\Requests\Catalogos\Update\UpdateCatCategoriaRequest;
use App\Interface\Catalogos\catCategoriasRepositoryInterface;
use App\Models\Catalogos\CatCategoria;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class CatCategoriaController extends Controller
{
    protected $_catCategorias;

    public function __construct(catCategoriasRepositoryInterface $catCategorias)
    {
        $this->_catCategorias = $catCategorias;
    }

    // Metodo para obener todas las categorias

    public function getAll()
    {
        try {
            $getAll = $this->_catCategorias->getAll();

            return ApiResponseHelper::sendResponse($getAll, 'Catálogo obtenido', 200);
        } catch (Exception $ex) {

            return ApiResponseHelper::sendResponse($ex, 'No se obtuvieron los datos', 500);
        }
    }

    public function getById($Id)
    {
        try {
            $getById = $this->_catCategorias->getByID($Id);

            return ApiResponseHelper::sendResponse($getById, 'Datos obtenidos', 200);
        } catch (Exception $ex) {
            return ApiResponseHelper::sendResponse($ex, 'Error al obtener los datos', 500);
        }
    }

    public function getAllHabilitados()
    {
        try {
            // Obtiene las categorías habilitadas del repositorio
            $getAllHabilitados = $this->_catCategorias->getAllHabilitados();

            // Retorna la respuesta con los datos obtenidos
            return ApiResponseHelper::sendResponse($getAllHabilitados, 'Datos obtenidos', 200);
        } catch (Exception $ex) {
            // En caso de error, devuelve una respuesta con el mensaje de error
            return ApiResponseHelper::sendResponse(null, 'Ocurrió un error inesperado', 500, [$ex->getMessage()]);
        }
    }

    public function store(StoreCatCategoriaRequest $cat)
    {
        try {
            DB::beginTransaction();
    
            $data = [
                'nombre_categoria' => $cat->nombre_categoria,
                'habilitado' => $cat->habilitado
            ];
    
            $catalog = CatCategoria::create($data); // Guardar en la base de datos
    
            DB::commit();

    
            return response()->json([
                'success' => true,
                'data' => $catalog,
                'message' => 'Registro creado con éxito'
            ], 201);
    
        } catch (Exception $ex) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error inesperado',
                'error' => $ex->getMessage()
            ], 500);
        }
    }
    

    public function update(UpdateCatCategoriaRequest $cat, $Id)
    {
        try{

            DB::beginTransaction();

            $data = [
                'nombre_categoria' => $cat->nombre_categoria,
                'habilitado' => $cat->habilitado
            ];

            $catalog =  $this->_catCategorias->update($data, $Id);

            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $catalog,
                'message' => 'Registro creado con éxito'
            ], 201);
    
        } catch (Exception $ex) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error inesperado',
                'error' => $ex->getMessage()
            ], 500);
        }
    }
}
