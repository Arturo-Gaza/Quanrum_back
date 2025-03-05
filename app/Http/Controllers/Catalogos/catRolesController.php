<?php

namespace App\Http\Controllers\Catalogos;

use App\Classes\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalogos\Store\StoreCatRolRequest;
use App\Http\Requests\Catalogos\Update\UpdateCatRolRequest;
use App\Interface\Catalogos\catRolesRepositoryInterface;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class catRolesController extends Controller
{
    protected $_catRoles;

    public function __construct(catRolesRepositoryInterface $catRoles)
    {
        $this->_catRoles = $catRoles;
    }

    public function getAll()
    {
        try{
            $getAll = $this->_catRoles->getAll();
            return ApiResponseHelper::sendResponse($getAll, 'Catálogo obtenido', 200);
        }
        catch (Exception $ex){
            return ApiResponseHelper::sendResponse($ex, 'No se obtuvo la lista', 500);
        }
    }

    public function getById($Id)
    {
        try{
            $getById = $this->_catRoles->getById($Id);
            return ApiResponseHelper::sendResponse($getById,'Datos obtenidos', 200);
        }
        catch(Exception $ex){
            return ApiResponseHelper::sendResponse($ex, 'No se obtuvo el dato', 500);
        }
        
    }

    public function getAllHabilitados()
    {
        try{
            $getAll = $this->_catRoles->getAllHabilitados();
            return ApiResponseHelper::sendResponse($getAll, 'Catalogo obtenido', 200);
        }catch (HttpResponseException $ex) {
            DB::rollBack();
            $response = $ex->getResponse();
            $response = $response->original ?? [$ex->getMessage()];
            return ApiResponseHelper::rollback(false, 'No se pudo obtener los datos', $response['data'], $response['errors'], 500);
        } catch (Exception $ex) {
            DB::rollBack();
            return ApiResponseHelper::rollback(false, 'Ocurrio un error inesperado', null, [$ex->getMessage()], 500);

        }
    }

    public function store(StoreCatRolRequest $cat)
    {
        try{
            DB::beginTransaction();
        $data = [
            'nombre_rol'=> $cat->nombre_rol,
            'habilitado'=> $cat->habilitado
        ];
        $catalog = $this->_catRoles->store($data);
        DB::commit();
        return ApiResponseHelper::sendResponse(null, 'Catalogo creado correctamente', 201);
        }catch (Exception $ex){
            DB::rollBack();
            return ApiResponseHelper::rollback($ex);
        }
        
    }

    public function update(UpdateCatRolRequest $cat, $id)
    {
        try{
            DB::beginTransaction();
        $data = [
            'nombre_rol'=> $cat->nombre_rol,
            'habilitado'=> $cat->habilitado
        ];
        $catalog = $this->_catRoles->update($data, $id);
        DB::commit();
        return ApiResponseHelper::sendResponse(null, 'Catalogo adctualiozado correctamente', 201);
        }catch (Exception $ex){
            DB::rollBack();
            return ApiResponseHelper::rollback($ex);
        }
    }
}
