@extends('layouts.app')
@section('title', 'CodeInsect | Dashboard')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> User Management
        <small>Add, Edit, Delete</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="#"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Users List</h3>
                    <div class="box-tools">
                        <form action="#" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Role</th>
                        <th>Created On</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    @foreach($users as $rec)
                    <tr>
                        <td>{{$rec->name}}</td>
                        <td>{{$rec->email}}</td>
                        <td>{{$rec->mobile}}</td>
                        <td>{{$rec->role}}</td>
                        <td>{{$rec->createdDtm}}</td>
                        <td></td>
                    </tr> 
                    @endforeach
                  </table>                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              {{ $users->links() }}
            </div>
        </div>
    </section>
</div>
@endsection