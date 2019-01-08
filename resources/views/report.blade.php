@extends('layouts.app')

@section('content')
    <report :group="{{ $group }}"></report>
@endsection
