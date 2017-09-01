<?php

namespace App\Http\Controllers;

use App\Departamentos;
use App\Entidades;
use App\Http\Controllers\Controller;
use App\Municipios;
use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Session;

class EntidadesController extends Controller
{
    /**
     * [__construct description]
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => []]);
        $this->beforeFilter('@find', ['only' => ['edit', 'update']]);
    }

/**
 * [find description]
 * @param  Route  $route [description]
 * @return [type]        [description]
 */
    public function find(Route $route)
    {
        $this->entidades = entidades::find($route->getParameter('administracion_entidades'));
        $this->notFound($this->entidades);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if ($this->security(23)) {
            $entidades = Entidades::all();
            return view('administracion.entidades.admin', compact('entidades'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if ($this->security(24)) {
            $entidades     = Entidades::all();
            $departamentos = Departamentos::lists('descripcion', 'id')->toArray();
            $municipios    = Municipios::lists('descripcion', 'id')->toArray();
            return view('administracion.entidades.new', compact('entidades', 'departamentos', 'municipios'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if ($this->security(24)) {
            if (empty($request['entities_id'])) {
                $request['entities_id'] = -1;
            }
            $u                       = Entidades::select(DB::Raw('max(id) as id'))->get();
            $entidad                 = $this->entidad($request['entities_id']);
            $request['completename'] = $this->arbol($entidad, $request['name']);
            $request['level']        = $this->level($entidad);
            $request['id']           = $u[0]->id + 1;
            $entidades               = Entidades::create($request->all());
            if ($entidades) {
                Session::flash('message-success', 'Entidad ' . $request['name'] . ' creada correctamente');
            } else {
                Session::flash('message-error', 'Error al crear entidad' . $request['name']);
            }
            return $this->retorno("administracion_entidades");
        }
    }

    /**
     * [entidad description]
     * @return [type] [description]
     */
    public function entidad($arr)
    {
        $en = [];
        if (!empty($arr)) {
            $e = Entidades::where('id', $arr)->get();
            if (count($e) > 0) {
                $en = $e[0];
            }
        }
        return $en;
    }

    /**
     * [entidad description]
     * @return [type] [description]
     */
    public function level($arr)
    {
        if (!empty($arr->completename)) {
            return count(explode(">", $arr->completename));
        } else {
            return 1;
        }
    }

    /**
     * [arbol description]
     * @return [type] [description]
     */
    public function arbol($arr, $name)
    {
        if (!empty($arr->completename)) {
            return $arr->completename . " > " . $name;
        } else {
            return $name;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        if ($this->security(25)) {
            $entidad       = $this->entidades;
            $departamentos = Departamentos::lists('descripcion', 'id')->toArray();
            $municipios    = Municipios::where('id_departamento', $entidad->state)->lists('descripcion', 'id')->toArray();
            $entidades     = Entidades::all();
            return view('administracion.entidades.edit', compact('entidad', 'entidades', 'departamentos', 'municipios'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if ($this->security(25)) {
            $entidad                 = $this->entidad($request['entities_id']);
            $request['completename'] = $this->arbol($entidad, $request['name']);
            $request['level']        = $this->level($entidad);

            $this->entidades->fill($request->all());
            if ($this->entidades->save()) {
                Session::flash('message-success', 'Entidad ' . $request['nombre'] . ' actualizada correctamente');
            } else {
                Session::flash('message-error', 'Error al actualizar entidad' . $request['nombre']);
            }
            return $this->retorno("administracion_entidades");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $nombre)
    {
        //
        if ($this->security(25)) {
            if (Entidades::destroy($id)) {
                Session::flash('message-success', 'Entidad ' . $nombre . ' eliminada correctamente');
            } else {
                Session::flash('message-error', 'Error al eliminar entidad' . $nombre);
            }
            return $this->retorno("administracion_entidades");
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function municipios(Request $request, $id)
    {
        //
        if ($request->ajax()) {
            $ciudades = Municipios::where('id_departamento', $id)->get();
            return response()->json($ciudades);
        }
        abort(403);
    }

    /**
     * [change description]
     * @return [type] [description]
     */
    public function change()
    {
        $raiz = $this->build_raiz('');
        return view('administracion.entidades.change', compact('raiz'));
    }

    /**
     * [change description]
     * @return [type] [description]
     */
    public function entities_change(Request $request)
    {
        $entidad = Entidades::select('id')->where('name', $request['entida'])->get();
        $id      = 0;
        if (count($entidad) > 0) {
            $id = $entidad[0]->id;
        }
        DB::update('update users set entities_select = ? where id = ?', [$id, Auth::user()->id]);
        return $this->retorno("");
    }

/**
 * [build_raiz description]
 * @param  [type] $entidades [description]
 * @return [type]            [description]
 */
    public function build_raiz($entidades)
    {
        $entidad = [];
        $content = [];
        $raiz    = '';
        $ent     = Auth::user()->entities_id;
        $in      = $this->recursivo($ent);
        $aux     = substr($ent . "," . $in, 0, -1);
        $raizes  = Entidades::whereRaw('id IN (' . $aux . ')')->orderBy('entities_id', 'ASC')->get();
        foreach ($raizes as $value) {
            $subraiz = $value->entities_id;
            array_push($content, $value->id);
            $boolean = "false";
            if (in_array($value->id, $entidad)) {
                $boolean = "true";
            }
            if ($subraiz < 0 || !in_array($subraiz, $content)) {
                $subraiz = '#';
            }
            $raiz .= '{ "id" : "' . $value->id . '", "parent" : "' . $subraiz . '", "text" : "' . $value->name . '", "state": {"selected": ' . $boolean . '}},';
        }
        return $raiz;
    }
}
