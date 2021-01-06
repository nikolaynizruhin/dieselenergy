@extends('layouts.app')

@section('title', __('Заборонено'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Заборонено'))
