@extends('master')
@section('title', 'Cartas Novas')
@section('conteudo')
  @include('components.navbarHome', ['cadastroId' => $cadastro->IDCadastro])

  <livewire:cartas-novas-cards :vendedor="$vendedor" :cadastro="$cadastro" />

  @include('components.floatMenu', ['cadastro' => $cadastro, 'vendedor' => $vendedor])

@endsection
