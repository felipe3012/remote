@extends('layouts.form')
@section('content')
{!!Form::open(['route'=>'incidencias.store','method'=>'POST','name'=>'frm','id'=>'frm','role'=>'form','data-toggle'=>'validator','class'=>'form-horizontal','files'=>true])!!}

@if($id==1)
{!! Form::hidden('reporte', 'xtenico', []) !!}
@endif
@if($id==2)
{!! Form::hidden('reporte', 'general', []) !!}
@endif
@if($id==3)
{!! Form::hidden('reporte', 'incidencia', []) !!}
@endif
@if($id==4)
{!! Form::hidden('reporte', 'acuerdo', []) !!}
@endif
@if($id==5)
{!! Form::hidden('reporte', 'usurios', []) !!}
@endif
{!!Form::close()!!}
@stop
