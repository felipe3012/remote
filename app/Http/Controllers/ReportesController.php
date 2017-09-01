<?php

namespace App\Http\Controllers;

use App\Entidades;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class ReportesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('reportes.admin');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

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
        if ($request['reporte'] == "xtenico") {
            return $this->xtenico($request);
        }
        if ($request['reporte'] == "general") {
            return $this->general($request);
        }
        if ($request['reporte'] == "incidencia") {
            return $this->incidencia($request);
        }
        if ($request['reporte'] == "acuerdo") {
            return $this->acuerdos($request);
        }
        if ($request['reporte'] == "usurios") {
            return $this->usuarios($request);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //
        $raiz     = $this->build_raiz([]);
        $tecnicos = User::lists('realname', 'id')->toArray();
        return view('reportes.modals', compact('id', 'raiz','tecnicos'));
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * [build_raiz description]
     * @param  [type] $entidades [description]
     * @return [type]            [description]
     */
    public function build_raiz($entidades)
    {
        $entidad = [];
        $raiz    = '';
        $raizes  = Entidades::all();

        foreach ($raizes as $value) {
            $subraiz = $value->entities_id;
            $boolean = "false";
            if (in_array($value->id, $entidad)) {
                $boolean = "true";
            }
            if ($subraiz < 0) {
                $subraiz = '#';
            }
            $raiz .= '{ "id" : "' . $value->id . '", "parent" : "' . $subraiz . '", "text" : "' . $value->name . '", "state": {"selected": ' . $boolean . '}},';
        }
        return $raiz;
    }

}
