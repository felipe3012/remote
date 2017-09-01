@extends('layouts.base')
@section('title','titulos | Nueva')
@section('name',' <i class="fa fa-plus"></i> Nuevo usuario')
@section('breadcrumb','<li>Administración</li><li>titulos</li><li class="active">Nueva</li>')
@section('content')
<div class="row">
        <div class="col-md-12">
          <div class="white-box">
{!!Form::open(['route'=>'administracion_titulos.store','method'=>'POST','name'=>'frm','id'=>'frm','role'=>'form','data-toggle'=>'validator','class'=>'form-horizonta'])!!}
@include('forms.form_titulos')
<br/><br/><br/><br/><br/>
<div align="center" class="form-group col-md-12">
    <button class="btn btn-sm btn-primary" id="btsubmit" type="submit">
        Guardar
    </button>
    <button class="btn btn-sm btn-warning" onclick="window.parent.location.href = '{{config('domains.Base')[0]}}administracion_titulos'" type="button">
         <i class="fa fa-close"></i> Cancelar
    </button>
</div>
<div class="hidden-xs">
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
</div>
      </div>        
    </div>
 </div>
{!!Form::close()!!}
@stop
