@extends('layouts.app')
@section('content')
     <main class="pt-5 mt-5">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
      <h2 class="page-title">My Account</h2>
      <div class="row">
        <div class="col-lg-3">
        @include('user.account-nav')
        </div>
        <div class="col-lg-9">
          <div class="page-content my-account__dashboard">
            <p >Hello <strong class="fs-3">{{Auth::user()->name}}</strong></p>
            <p class="fs-5">From your account dashboard you can view your <a class="unerline-link" href="account_orders.html">recent
                orders</a>, manage your <a class="unerline-link" href="account_edit_address.html">shipping
                addresses</a>, and <a class="unerline-link" href="account_edit.html">edit your password and account
                details.</a></p>
          </div>
        </div>
      </div>
    </section>
  </main>

@endsection