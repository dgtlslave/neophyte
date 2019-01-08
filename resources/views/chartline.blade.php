@extends('layouts.app')

@section('content')
<chartline :progress="{{ $progress }}"></chartline>
@endsection