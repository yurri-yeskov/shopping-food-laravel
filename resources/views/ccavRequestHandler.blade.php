@extends('layouts.app')
@section('title', 'CCAvenue Payment - FirstMeal')
@section('content')
<center>
<form method="post" name="redirect" action="https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction">
@php
echo "<input type=hidden name=encRequest value=$encrypted_data>";
echo "<input type=hidden name=access_code value=$access_code>";
echo "<input type=hidden name=custom_code value=$custom_code>";
@endphp
</form>
</center>
<script language='javascript'>document.redirect.submit();</script>
@endsection

